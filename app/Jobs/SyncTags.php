<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \App\Destinataire;
use DB;

class SyncTags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 0;
    public $bases;
    public $base;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($base, $bases)
    {
        $this->bases = $bases;
        $this->base = $base;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // La récéption des mails peut prendre du temps, tout dépend du nombre de mail dans une base. En général, il y a en des millions.
        $from = Destinataire::where('base_id', $this->base)->pluck('tags', 'email')->toArray();
        $to = Destinataire::whereIn('base_id', $this->bases)->select('id', 'tags', 'email')->get()->toArray();

        $this->getUniqueMails($from, $to);
    }

    public function getUniqueMails($from, $to){
        // A cette étape, je fais du récursif en coupant mon tableau par 10000 mails pour éviter de 1 que sa prenne trop de temps pour lancer la function sync(), et de 2 pour que mySQL ne crash par lors de l'update
        $sendNbr = 10000;
        $cutFrom = array_slice($from, 0, $sendNbr);
        $cutTo = array_slice($to, 0, $sendNbr);
        if(count($cutFrom) > 0 && count($cutTo) > 0){
            $i = 0;
            $count = count($cutTo);
            $newFrom = [];
            while($i < $count){
                if(!in_array($cutTo[$i]['email'], array_keys($cutFrom))){
                    unset($cutTo[$i]);
                }else{
                    $newFrom[$cutTo[$i]['email']] = $cutFrom[$cutTo[$i]['email']];
                }
                $i++;
            }
            empty($newFrom) ?: $this->sync($newFrom, array_values($cutTo));
            $this->getUniqueMails(array_slice($from, $sendNbr, count($from)), array_slice($to, $sendNbr, count($to)));
        }
        return true;
    }

    public function sync($from, $to){
        $i = 0;
        $string = '';
        $array_id = [];
        while($i < count($to)){
            array_push($array_id, $to[$i]['id']);
            $newTags = array_unique(array_merge($to[$i]['tags'], $from[$to[$i]['email']]));
            $string .= " WHEN ".$to[$i]['id']." THEN '".json_encode(array_values($newTags), JSON_HEX_APOS)."'";
            $i++;
        }
        $all_id = implode(', ', $array_id);
        return DB::update("UPDATE `destinataires` SET `tags` = CASE `id` $string ELSE `tags` END WHERE `id` IN ($all_id)");
    }
}
