<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptController extends Controller
{
    /**
     * Display a list of all files
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('encrypt.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('encrypt.create');
    }

    /**
     * Return a file of email in normal or sha256 who match with our database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sha256Method(Request $request){

    }

    /**
     * Return a file of email in normal or md5 who match with our database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function md5Method(Request $request){

    }
}
