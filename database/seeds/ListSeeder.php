<?php

use Illuminate\Database\Seeder;
use App\Base;

class ListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Base::insert([
            'name' => 'Clients',
        ]);
    }
}
