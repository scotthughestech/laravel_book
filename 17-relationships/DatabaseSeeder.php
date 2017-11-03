<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create five users
        factory(App\User::class, 10)->create();
        
        // Then create 1000 purchases
        factory(App\Purchase::class, 1000)->create();
    }
}
