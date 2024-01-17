<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        foreach ($users as $user){
            $name = $faker->name();
            $surname = $faker->name();
            $lastname = $faker->name();

            $user->update([
                'first_name' => $name,
                'second_name' => $surname,
                'last_name' => $lastname,
            ]);
        }
    }
}
