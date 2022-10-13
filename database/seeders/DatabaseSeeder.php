<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Flag;
use App\Models\Team;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Flag::create([
            'name' => 'Kurus',
            'key'  => 'kursus'
        ]);
        Flag::create([
            'name' => 'Prakerin S3',
            'key'  => 'prakerin_s3'
        ]);

        User::create([
            'name'            => 'si paling',
            'email'           => 'administrator@gmail.com',
            'password'        => bcrypt("password"),
            'project_name'    => 'DEWA',
            'current_team_id' => 1,
            'flag_id'         => 1,
            'level'           => 1,
        ]);

        Team::create([
            'user_id'       => 1,
            'name'          => "Si's Team",
            'personal_team' => 1
        ]);
    }
}
