<?php

use Illuminate\Database\Seeder;
use App\Fai;

class FaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array  = [
            ['name' => 'orange'], ['name' => 'free'], ['name' => 'gmail'], ['name' => 'sfr'], ['name' => 'laposte'], ['name' => 'autre'], ['name' => 'hotmail'], ['name' => 'yahoo'], ['name' => 'aol'], ['name' => 'bbox'], ['name' => 'apple'], ['name' => 'autrefr'], ['name' => 'suisse'], ['name' => 'belgique'], ['name' => 'tiscali']
        ];
        Fai::insert($array);
    }
}
