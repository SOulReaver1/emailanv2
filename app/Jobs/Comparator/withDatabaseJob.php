<?php

namespace App\Jobs\Comparator;

use App\Email;
use App\WaitingFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class withDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;
    public $path;
    public $date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->date = strtotime(now());
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('waiting_files')->insert([
            'name' => 'comparator',
            'path' => '/storage/download/'.$this->date.'-matchs.txt',
            'statut' => true
        ]);
        $emails = [];
        $currentFile = fopen(public_path($this->path), 'r');
        while($ligne = fgets($currentFile))
        {
            $email = filter_var(trim($ligne), FILTER_VALIDATE_EMAIL);
            $email && $emails[] = $email;
        }
        $this->checkInDatabase($emails);
    }

    public function checkInDatabase($emails){
        $sendNbr = 10000;
        $cutEmails = array_slice($emails, 0, $sendNbr);
        if(count($cutEmails) > 0){
            $matchs = Email::whereIn('email', $cutEmails)->pluck('email')->toArray();
            $this->addMatchToDlFile($matchs);
            $this->checkInDatabase(array_slice($emails, $sendNbr, count($emails)));
        }
        return DB::table('waiting_files')->where('path', '/storage/download/'.$this->date.'-matchs.txt')->update(['statut' => false]);
    }

    public function addMatchToDlFile($matchs){
        $dlFile = fopen(public_path('/storage/download/'.$this->date.'-matchs.txt'), 'a');
        fputcsv($dlFile, $matchs, "\n");
    }
}
