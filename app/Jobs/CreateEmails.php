<?php

namespace App\Jobs;

use App\Base;
use App\Email;
use App\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $base_id;
    public $timeout = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $base_id)
    {
        $this->data = $data;
        $this->base_id = $base_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Base::where('id', $this->base_id)->update(['statut' => true]);
        $base_name = Base::find($this->base_id)->pluck('name')->first();
        $json = json_encode([$base_name]);
        Tag::insertOrIgnore(['name' => $base_name]);
        $emails = [];
        $handle = fopen(public_path($this->data->path), 'r');
        while($ligne = fgets($handle))
        {
            if(filter_var(trim($ligne), FILTER_VALIDATE_EMAIL)){
                $emails[] = [
                    'email' => filter_var(trim($ligne), FILTER_VALIDATE_EMAIL),
                    'base_id' => $this->base_id,
                    'tags' => $json,
                    'sha256' => hash('sha256', filter_var(trim($ligne), FILTER_VALIDATE_EMAIL)),
                    'md5' => md5(filter_var(trim($ligne), FILTER_VALIDATE_EMAIL)),
                ];
            }
        }
        $this->addToDB($emails);
    }

    public function addToDB($emails){
        $sendNbr = 10000;
        $cutEmails = array_slice($emails, 0, $sendNbr);
        if(count($cutEmails) > 0){
            Email::insertOrIgnore($cutEmails);
            $this->addToDB(array_slice($emails, $sendNbr, count($emails)));
        }
        Base::where('id', $this->base_id)->update(['statut' => false]);
        return true;
    }
}
