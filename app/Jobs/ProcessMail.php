<?php

namespace App\Jobs;

use \App\Destinataire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \App\Base,
    \App\Tag;
class ProcessMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 0;
    public $array;
    public $emails;
    public $file_id;
    public $base_id;
    public $base_name;

    public function __construct($emails, $file_id, $base)
    {
        ini_set("memory_limit", "-1");
        $this->file_id = intval($file_id);
        $this->base_id = $base[0];
        $this->base_name = $base[1];
        $this->array = $emails;

    }

    public function handle()
    {
        $json = json_encode([$this->base_name]);
        foreach ($this->array as $key => $mail) {
            $this->emails[] = [
                'email' => $mail,
                'file_id' => $this->file_id,
                'base_id' => $this->base_id,
                'sha256' => hash('sha256', $mail),
                'md5' => md5($mail),
                'tags' => $json
            ];
        }
        Tag::insertOrIgnore(['name' => $this->base_name]);
        $this->sendMailToServer();
    }

    public function sendMailToServer(){
        Destinataire::insert($this->emails);
    }

}
