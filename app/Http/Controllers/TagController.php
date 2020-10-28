<?php

namespace App\Http\Controllers;

use App\Base;
use App\Email;
use App\Http\Requests\CreateTagRequest;
use App\Jobs\ImportTagsJob;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create', ['bases' => Base::all(), 'tags' => Tag::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CreateTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {
        $tags = json_decode($request->get('tags'));
        $bases = json_decode($request->get('bases'));
        if(Email::whereIn('base_id', $bases)->first()){
            switch ($request->get('method')){
                case 'base':
                    ImportTagsJob::dispatch($tags, $bases)->onQueue('tags');
                break;
                case 'file':
                    $path = $request->get('path');
                    ImportTagsJob::dispatch($tags, $bases, $path)->onQueue('tags');
                break;
                case 'domains':
                    // Not ready
                break;
            }
            return true;
        }
        return redirect()->back()->with('error', 'Il n\'y a pas d\'email dans la / les base(s)');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Sync all tags with different methods
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request){

    }

    /**
     * Display the delete tag page
     * @return \Illuminate\Http\Response
     */
    public function delete(){
        return view('tags.delete', ['bases' => Base::all(), 'tags' => Tag::all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
