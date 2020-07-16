<?php

use App\bpm;
use App\family;
use App\User;
use App\user_doctors;
use App\user_temp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        user_temp::truncate();
        bpm::truncate();
        user_doctors::truncate();
        family::truncate();
        
        factory(User::class, 100)->create();
        factory(family::class, 250)->create();
        factory(user_doctors::class , 120)->create();
        factory(user_temp::class, 400)->create();
        factory(bpm::class, 400)->create();
        

    }
}
