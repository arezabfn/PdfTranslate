<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\unknown;
use App\Models\known;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;

class UnknownController extends Controller
{

    public function index()
    {
//        $files = File::all();
//        if(empty($files))
//        {
//            $name = File::orderBy('id', 'desc')->first()->name;
//            $pdf_path ='file/'.$name;
//            $this->save_words($pdf_path);
//        }

        $user = Auth::id();
        $unknown = unknown::where('user',$user)->get();
        return view('admin.unknownWord.index',compact('unknown'));
    }

    public function create()
    {
        unknown::query()->truncate();
        return redirect()->route('unknown.index');
    }

    public function store(Request $request)
    {


    }

    public function show(string $id)
    {
//        return view('admin.unknownWord.index',compact('unknown'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function remove()
    {

    }


}
