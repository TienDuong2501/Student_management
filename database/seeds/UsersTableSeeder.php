<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $teacher = [
        	'name' => 'admin',
        	'fullname' => 'Nguyen Thi A',
        	'email' => 'admin@gmail.com',
        	'password' => Hash::make('123456'),
        	'phone' => '09876543210',
        	'role' => User::TEACHER_ROLE,
        	'created_at' => now(),
        	'updated_at' => now(),
        ];
        $data = [];
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $data[$i]['name'] = $faker->firstNameFemale;
            $data[$i]['fullname'] = $faker->name;
            $data[$i]['phone'] = $faker->e164PhoneNumber;
            $data[$i]['email'] = $faker->email;
            $data[$i]['role'] = 0;
            $data[$i]['password'] = Hash::make('123456');
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        array_push($data, $teacher);
        DB::table('users')->insert($data);

        return true;
    }
}
