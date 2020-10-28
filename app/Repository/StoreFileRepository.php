<?php 

namespace App\Repository;

class StoreFileRepository
{
    public function getFileParams($file){
        return (object) [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => str_replace("/", "-", $file->getClientMimeType()),
            'path' => $file->getSize().'-'.str_replace("/", "-", $file->getClientMimeType()).$file->getClientOriginalName()
        ];
    }
}