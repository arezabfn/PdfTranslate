<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\known;
use App\Models\unknown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::id();
        $file = File::where('user',$user)->get();
        return view('home',compact('file'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('pdf');
        $pdfFile = "";
        if(!empty($file)){
            $pdfFile = "file-".time().".".$file->getClientOriginalExtension();
            $file->move('file',$pdfFile);

        }
        File::create([
            'name' => $pdfFile,
            'user' => Auth::id(),
        ]);

        $name = File::orderBy('id', 'desc')->first()->name;
        $pdf_path ='file/'.$name;
        $this->save_words($pdf_path);


        return redirect()->route('unknown.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $file = File::FindOrFail($id);

        $name = $file->name;
        $pdf_path ='file/'.$name;
        $this->save_words($pdf_path);

        return redirect()->route('unknown.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::findOrFail($id);
        if(file_exists('file/'.$file->name)){
            unlink('file/'.$file->name);
        }
        $file->destroy($id);
        return redirect()->route('dashboard.index');

    }


    function save_words($file_name){
        global $known_words, $unknowns, $db;
        $known_words = [];
        $this->set_knowns();
        $unknowns = [];
        $text = $this->read_pdf($file_name);
        $this->filter_text($text);
        $counted = array_count_values($unknowns);
        arsort($counted);
        $this->insert_unknowns_words($counted);
    }

    function read_pdf($file_name){
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($file_name);
        return $pdf->getText();
    }

    function filter_text($text){
        global $unknowns;

        foreach(explode('\n', $text) as $line){
            $text = strtolower($line);
            preg_match_all("/(?!([a-z]+es\b|[a-z]+ed\b))[a-z]{3,}/", $text, $matches);
            $array = array_filter($matches[0], function ($word) {
                global $known_words;
                if (in_array($word, $known_words)) {
                    return false;
                } else {
                    return true;
                }
            });
            $unknowns = array_merge($unknowns, $array);
        }
    }

    function insert_unknowns_words($counted){

        unknown::query()->truncate();
        $source = 'en';
        $target = 'fa';
        $trans = new GoogleTranslate();
        foreach ($counted as $word => $frequency) {
            $stemmed = \Nadar\Stemming\Stemm::stem($word, 'en');

            $translate = $trans->translate($source, $target, $word);
            echo "<meta charset=utf-8><pre dir=rtl>";
            unknown::create([
                'word'=>$word,
                'repetition'=>$frequency,
                'translate'=>$translate,
                'root'=>$stemmed,
                'level'=>$this->determineDifficulty($word),
                'difficultyRate'=>$this->rate($word),
                'type'=>'-',
                'user'=> Auth::id()
            ]);
        }

    }

    function set_knowns()
    {
        global $known_words;
        $results = known::pluck('word');
        foreach ($results as $words) {
            $known_words[] = $words;
        }
    }
    function rate($word) {
        $base = 20;
        $rate = (strlen($word)/$base) * 100;
        return $rate;
    }
    function determineDifficulty($word) {
        $wordLength = strlen($word);

        if ($wordLength < 5) {
            return "Easy";
        } elseif ($wordLength >= 5 && $wordLength <= 8) {
            return "Moderate";
        } else {
            return "Difficult";
        }
    }



}

//Start Section Translate Words
/**
 * GoogleTranslate.class.php
 *
 * Class to talk with Google Translator for free.
 *
 * @package PHP Google Translate Free;
 * @category Translation
 * @author Adrián Barrio Andrés
 * @author Paris N. Baltazar Salguero <sieg.sb@gmail.com>
 * @copyright 2016 Adrián Barrio Andrés
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License 3.0
 * @version 2.0
 * @link https://statickidz.com/
 */

/**
 * Main class GoogleTranslate
 *
 * @package GoogleTranslate
 *
 */
class GoogleTranslate
{

    /**
     * Retrieves the translation of a text
     *
     * @param string $source
     *            Original language of the text on notation xx. For example: es, en, it, fr...
     * @param string $target
     *            Language to which you want to translate the text in format xx. For example: es, en, it, fr...
     * @param string $text
     *            Text that you want to translate
     *
     * @return string a simple string with the translation of the text in the target language
     */
    public static function translate($source, $target, $text)
    {
        // Request translation
        $response = self::requestTranslation($source, $target, $text);

        // Get translation text
        // $response = self::getStringBetween("onmouseout=\"this.style.backgroundColor='#fff'\">", "</span></div>", strval($response));

        // Clean translation
        $translation = self::getSentencesFromJSON($response);

        return $translation;
    }

    /**
     * Internal function to make the request to the translator service
     *
     * @param string $source
     *            Original language taken from the 'translate' function
     * @param string $target
     *            Target language taken from the ' translate' function
     * @param string $text
     *            Text to translate taken from the 'translate' function
     *
     * @return object[] The response of the translation service in JSON format
     * @internal
     *
     */
    protected static function requestTranslation($source, $target, $text)
    {

        // Google translate URL
        $url = "https://translate.google.com/translate_a/single?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=es-ES&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e";

        $fields = array(
            'sl' => urlencode($source),
            'tl' => urlencode($target),
            'q' => urlencode($text)
        );

        if (strlen($fields['q']) >= 5000)
            throw new \Exception("Maximum number of characters exceeded: 5000");

        // URL-ify the data for the POST
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        rtrim($fields_string, '&');

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1');

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
    }

    /**
     * Dump of the JSON's response in an array
     *
     * @param string $json
     *            The JSON object returned by the request function
     *
     * @return string A single string with the translation
     */
    protected static function getSentencesFromJSON($json)
    {
        $sentencesArray = json_decode($json, true);
        $sentences = "";

        foreach ($sentencesArray["sentences"] as $s) {
            $sentences .= isset($s["trans"]) ? $s["trans"] : '';
        }

        return $sentences;
    }
}
