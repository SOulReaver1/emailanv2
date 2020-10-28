<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \App\Base;
use \App\Destinataire;
use DB;

class DeleteTags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 0;
    public $bases_id;
    public $tags;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($base, $tags)
    {
        $this->bases_id = $base;
        $this->tags = $tags;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tags = Destinataire::whereIn('base_id', $this->bases_id)->whereJsonContains('tags', $this->tags)->select('id', 'tags')->get()->toArray();
        if(!empty($tags)){
            $this->delete($tags);
        }
    }

    public function delete($tags){
        // J'utilise encore une fois de la récursivité car j'édit chaque emails qui a les tags a delete grâce à un array_diff;
        $sendNbr = 10000;
        $cutTags = array_slice($tags, 0, $sendNbr);
        if(count($cutTags) > 0){
            $i = 0;
            $array_id = [];
            $string = '';
            while($i < count($cutTags)){
                array_push($array_id, $tags[$i]['id']);
                $newTags = array_diff($tags[$i]['tags'], $this->tags);
                $string .= " WHEN ".$tags[$i]['id']." THEN '".json_encode(array_values($newTags), JSON_HEX_APOS)."'";
                $i++;
            }
            $all_id = implode(', ', $array_id);
            DB::update("UPDATE `destinataires` SET `tags` = CASE `id` $string ELSE `tags` END WHERE `id` IN ($all_id)");
            return $this->delete(array_slice($tags, $sendNbr, count($tags)));
        }
        return true;
    }
}
