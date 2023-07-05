<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\known;
use App\Models\simple;
use App\Models\unknown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::id();
        $simple = simple::where('user',$user)->get();
        return view('admin.simpleWord.index',compact('simple'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $rows = array();
//
//        $results = known::pluck('word');
//        foreach ($results as $row) {
//            $rows[] = $row;
//        }
//        echo json_encode($rows);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $item = unknown::findorfail($id);
       $word = $item->word;

        simple::create([
            'word' => $word,
            'translate' =>'-',
            'user' => Auth::id()
        ]);
        $item->destroy($id);
        return redirect()->route('unknown.index');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function view()
    {

    }

}
