<?php

namespace App\Http\Controllers;

use App\Jobs\Comparator\withDatabaseJob;
use App\Jobs\Comparator\withFilesJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComparatorController extends Controller
{
    /**
     * Display a list of all compared files
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('comparator.index', ['comparators' => DB::table('waiting_files')->where('name', 'comparator')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('comparator.create');
    }

    /**
     * Return an array of email who match between the two files
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function between2Files(Request $request){
        $path1 = $request->get('path1');
        $path2 = $request->get('path2');
        $statut = $request->get('statut');
        withFilesJob::dispatch($path1, $path2, $statut)->onQueue('comparator');
        return true;
    }

    /**
     * Return an array of email who match with our database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withDatabase(Request $request){
        $path = $request->get('path');
        withDatabaseJob::dispatch($path)->onQueue('comparator');
        return true;
    }
}
