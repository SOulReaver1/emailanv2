<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaiDomainsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            // Orange
            ['fais_id' => 1, 'name' => 'orange.fr'], 
            ['fais_id' => 1, 'name' => 'wanadoo.fr'], 
            ['fais_id' => 1, 'name' => 'voila.fr'],
            // Free
            ['fais_id' => 2, 'name' => 'free.fr'],
            ['fais_id' => 2, 'name' => 'freesbee.fr'],
            ['fais_id' => 2, 'name' => 'libertysurf.fr'],
            ['fais_id' => 2, 'name' => 'worldonline.fr'],
            ['fais_id' => 2, 'name' => 'online.fr'],
            ['fais_id' => 2, 'name' => 'alicepro.fr'],
            ['fais_id' => 2, 'name' => 'aliceadsl.fr'],
            ['fais_id' => 2, 'name' => 'alicemail.fr'],
            ['fais_id' => 2, 'name' => 'infonie.fr'],
            // Gmail
            ['fais_id' => 3, 'name' => 'gmail.com'],
            // Sfr
            ['fais_id' => 4, 'name' => 'sfr.fr'],
            ['fais_id' => 4, 'name' => 'neuf.fr'],
            ['fais_id' => 4, 'name' => 'cegetel.net'],
            ['fais_id' => 4, 'name' => 'club-internet.fr'],
            ['fais_id' => 4, 'name' => 'numericable.fr'],
            ['fais_id' => 4, 'name' => 'numericable.com'],
            ['fais_id' => 4, 'name' => 'noos.fr'],
            ['fais_id' => 4, 'name' => 'neufcegetel.fr'],
            // La poste
            ['fais_id' => 5, 'name' => 'laposte.net'],
            ['fais_id' => 5, 'name' => 'laposte.fr'],
            // Autre
            ['fais_id' => 6, 'name' => 'blabla.com'],
            // Hotmail
            ['fais_id' => 7, 'name' => 'hotmail.fr'],
            ['fais_id' => 7, 'name' => 'msn.fr'],
            ['fais_id' => 7, 'name' => 'live.fr'],
            ['fais_id' => 7, 'name' => 'outlook.fr'],
            ['fais_id' => 7, 'name' => 'outlook.com'],
            ['fais_id' => 7, 'name' => 'msn.com'],
            // Yahoo
            ['fais_id' => 8, 'name' => 'yahoo.fr'],
            ['fais_id' => 8, 'name' => 'yahoo.com'],
            // Aol
            ['fais_id' => 9, 'name' => 'aol.com'],
            ['fais_id' => 9, 'name' => 'aol.fr'],
            // Bbox
            ['fais_id' => 10, 'name' => 'bbox.fr'],
            // Apple
            ['fais_id' => 11, 'name' => 'icloud.com'],
            // Autrefr
            ['fais_id' => 12, 'name' => 'autrefr'],
            // Suisse
            ['fais_id' => 13, 'name' => 'adressesuisse'],
            // Belgique
            ['fais_id' => 14, 'name' => 'adressebelgique'],
            // Tiscali
            ['fais_id' => 15, 'name' => 'tiscali.fr'],
        ]; 
        DB::table('fais_domains')->insert($array);
    }
}
