<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Http\Request;
use App\Repository\StoreFileRepository;
use Illuminate\Support\Facades\DB;

class StoreFileController extends Controller
{
    protected $repository;

    /**
     * Initialize file informations from StoreFileRepository
     * @param App\Repository\StoreFileRepository $request
     * 
     */
    public function __construct(StoreFileRepository $repository){
        $this->repository = $repository;
    }

    /**
     * Store the file in storage folder and some informations in database
     * @param App\Http\Requests\StoreFileRequest $request
     * @return  array
     */
    public function storeFile(StoreFileRequest $request){
        $fileParams = $this->repository->getFileParams($request->file('file'));
        $request->file('file')->storeAs('public/upload/', $fileParams->path);
        $myFile = File::create([
            'path' => 'storage/upload/'.$fileParams->path,
            'name' => $fileParams->name,
            'size' => $fileParams->size,
            'type' => $fileParams->type
        ]);
        return $myFile;
    }

    /**
     * Check if the file already exist or not
     * @param App\Http\Requests\StoreFileRequest $request
     * @return  array
     */
    public function check(StoreFileRequest $request){
        $fileParams = $this->repository->getFileParams($request->file('file'));
        return File::where('path', 'storage/upload/'.$fileParams->path)->first() ?? [];
    }
}
