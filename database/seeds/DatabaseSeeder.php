<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        $this->call([FaiSeeder::class]);
        $this->call([FaiDomainsSeeder::class]);
        $this->call([ListSeeder::class]);
    }
}
