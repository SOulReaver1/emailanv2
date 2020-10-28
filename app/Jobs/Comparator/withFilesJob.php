<?php

namespace App\Jobs\Comparator;

use App\WaitingFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class withFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;
    public $path1;
    public $path2;
    public $statut;
    public $date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path1, $path2, $statut)
    {
        $this->path1 = $path1;
        $this->path2 = $path2;
        $this->statut = $statut;
        $this->date = strtotime(now());
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        WaitingFile::insert([
                'name' => 'comparator',
                'path' => '/storage/download/'.$this->date.'-matchs.txt',
                'statut' => true
        ]);
        $file1 = fopen(public_path($this->path1), 'r');
        $file2 = fopen(public_path($this->path2), 'r');

        $tabliste1 = array();
        $tabliste2 = array();

        while($ligne = fgets($file1))
        {
            $tabliste1[trim($ligne)]="";
        }
        while($ligne = fgets($file2))
        {
            $tabliste2[trim($ligne)]="";
        }

        $uniques = array_keys(array_diff_key($tabliste1, $tabliste2));
        $doublons = array_keys(array_intersect_key($tabliste1, $tabliste2));

        $matchsFile = fopen(public_path('/storage/download/'.$this->date.'-matchs.txt'), 'a');
        fputcsv($matchsFile, $doublons, "\n");

        if($this->statut !== 'null'){
            WaitingFile::insert([
                    'name' => 'comparator',
                    'path' => '/storage/download/'.$this->date.'-uniques.txt',
                    'statut' => true
            ]);
            $notMatchsFile = fopen(public_path('/storage/download/'.$this->date.'-uniques.txt'), 'a');
            fputcsv($notMatchsFile, $uniques, "\n");
            WaitingFile::where('path', '/storage/download/'.$this->date.'-uniques.txt')->update(['statut' => false]);
        }

        return WaitingFile::where('path', '/storage/download/'.$this->date.'-matchs.txt',)->update(['statut' => false]);
    }
}
