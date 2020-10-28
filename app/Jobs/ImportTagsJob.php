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

class ImportTagsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;
    public $tags;
    public $bases;
    public $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tags, $bases, $path = null)
    {
        $this->tags = $tags;
        $this->bases = $bases;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Base::whereIn('id', $this->bases)->update(['statut' => true]);
        $tags = [];
        foreach ($this->tags as $key => $value) {
            $tags[] = ['name' => $value];
        }
        Tag::insertOrIgnore($tags);
        $this->path ? $this->getEmailsInFile() : $this->importTagsToEmail(Email::whereIn('base_id', $this->bases)->select('id', 'tags')->get()->toArray());
    }

    public function getEmailsInFile(){
        $emails = [];
        $handle = fopen(public_path($this->path), 'r');
        while($ligne = fgets($handle)){
            $email = filter_var(trim($ligne), FILTER_VALIDATE_EMAIL);
            $email && $emails[] = $email;
        }
        $this->getMatchInBdd($emails);
    }

    public function getMatchInBdd($emails){
        $sendNbr = 10000;
        $cutEmails = array_slice($emails, 0, $sendNbr);
        if(count($cutEmails) > 0){
            $matchs = Email::whereIn('base_id', $this->bases)->whereIn('email', $cutEmails)->select('id', 'tags')->get()->toArray();
            $this->importTagsToEmail($matchs);
            $this->getMatchInBdd(array_slice($emails, $sendNbr, count($emails)));
        }
        Base::whereIn('id', $this->bases)->update(['statut' => false]);
        return true;
    }

    public function importTagsToEmail($emails){
        $i = 0;
        $string = '';
        $array_id = [];
        while($i < count($emails)){
            array_push($array_id, $emails[$i]["id"]);
            $newTags = array_unique(array_merge($emails[$i]["tags"], $this->tags));
            $string .= " WHEN ".$emails[$i]["id"]." THEN '".json_encode(array_values($newTags), JSON_HEX_APOS)."'";
            $i++;
        }
        if(count($emails) > 0){
            $all_id = implode(', ', $array_id);
            return DB::update("UPDATE `emails` SET `tags` = CASE `id` $string ELSE `tags` END WHERE `id` IN ($all_id)");
        }
        return true;
    }
}
