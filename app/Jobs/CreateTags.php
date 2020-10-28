<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \App\Tag;
use \App\Destinataire;
use \App\Base;
use DB;

class CreateTags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 0;
    public $elements;
    public $tags;
    public $emails;
    public $bases_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tags, $bases, $elements = 'undefined')
    {
        $this->tags = $tags;
        $this->bases_id = $bases;
        $this->elements = $elements;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->elements == 'undefined'):
            $this->baseMethod(Destinataire::whereIn('base_id', $this->bases_id)->select('id', 'tags')->get()->toArray());
        else:
            $this->fileMethod($this->elements);
        endif;
    }

    public function baseMethod($emails){
        $sendNbr = 10000;
        $cutEmails = array_slice($emails, 0, $sendNbr);
        if(count($cutEmails) > 0){
            $i = 0;
            $string = '';
            $array_id = [];
            while($i < count($cutEmails)){
                array_push($array_id, $cutEmails[$i]['id']);
                $tags = array_unique(array_merge($cutEmails[$i]["tags"], $this->tags));
                $string .= " WHEN ".$cutEmails[$i]['id']." THEN '".json_encode(array_values($tags), JSON_HEX_APOS)."'";
                $i++;
            }
            $all_id = implode(', ', $array_id);
            DB::update("UPDATE `destinataires` SET `tags` = CASE `id` $string ELSE `tags` END WHERE `id` IN ($all_id)");
            return $this->baseMethod(array_slice($emails, $sendNbr, count($emails)));
        }
        return true; 
    }

    public function fileMethod($emails){
        $i = 0;
        $tags = Destinataire::whereIn('base_id', $this->bases_id)->whereIn('email', $emails)->select('id', 'tags')->get()->toArray();
        $array_id = [];
        $string = '';
        while($i < count($tags)){
            array_push($array_id, $tags[$i]['id']);
            $newTags = array_unique(array_merge($tags[$i]["tags"], $this->tags));
            $string .= " WHEN ".$tags[$i]['id']." THEN '".json_encode(array_values($newTags), JSON_HEX_APOS)."'";
            $i++;
        }
        $all_id = implode(', ', $array_id);
        DB::update("UPDATE `destinataires` SET `tags` = CASE `id` $string ELSE `tags` END WHERE `id` IN ($all_id)");
        return true;
    }
}
