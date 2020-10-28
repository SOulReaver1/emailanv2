<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fai;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class FaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fais.index');
    }

    /**
     * Return an object of all fais and domains for datatable.js
     */
    public function datatable(){
        $fais = Fai::leftjoin('fais_domains', 'fais_domains.fais_id', '=', 'fais.id')
            ->select('fais.id', 'fais.name')->selectRaw('GROUP_CONCAT(fais_domains.name SEPARATOR ", ") AS domains')
            ->groupByRaw('fais.id, fais.name')
            ->orderBy('fais.id')->get();
        return DataTables::of($fais)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fais.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Fai::where('name', $request->get('name'))->get()->toArray()){
            $id = Fai::insertGetId([
                'name' => $request->get('name')
            ]);
            foreach (explode(', ', $request->get('domains')) as $key => $value) {
                DB::table('fais_domains')::insert([
                    'fais_id' => $id,
                    'domains' => $value
                ]);
            }
            return redirect(route('fais.index'))->with('success', 'Votre FAI a bien été créer');
        }else{
            return redirect()->back()->with('error', 'Le FAI existe déjà !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Fai::leftjoin('fais_domains', 'fais_domains.fais_id', '=', 'fais.id')
        ->select('fais.id', 'fais.name')->selectRaw('GROUP_CONCAT(fais_domains.name SEPARATOR ", ") AS domains')
        ->groupByRaw('fais.id, fais.name')
        ->orderBy('fais.id')->where('fais.id', $id)->first();
        return view('fais.show', ['fais' => $data]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Fai::find($id)->delete();
        return redirect()->back()->with('success', 'Le FAI a bien été supprimer !');
    }
}
