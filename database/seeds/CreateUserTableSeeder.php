<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class CreateUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('users')->insert([
        	[
                'id' => 1,
                'user_id' => '5e00ca3aa8a19',
	            'first_name' => 'John Joshua',
                'middle_name' => 'Alforte',
                'last_name' => 'Jamora',
                'username' => 'jjamora0021',
                'email' => 'jjamora0021@gmail.com',
	            'password' => bcrypt('password'),
	            'remember_token' => str_random(40) . time(),
	            'user_role' => 'superadmin',
                'status' => 'ACTIVE',
	            'created_at' => $now,
	            'updated_at' => $now
        	],
            [
                'id' => 2,
                'user_id' => '5e02213adbba6',
                'first_name' => 'Maria Theressa',
                'middle_name' => 'Maniquiz',
                'last_name' => 'Maneclang',
                'username' => 'tetay',
                'email' => 'maneclangmariatheressa@yahoo.com',
                'password' => bcrypt('password'),
                'remember_token' => str_random(40) . time(),
                'user_role' => 'manager',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'user_id' => '5e01113adbba6',
                'first_name' => 'Joyce',
                'middle_name' => 'De Guzman',
                'last_name' => 'Siatan',
                'username' => 'joycesiatan',
                'email' => 'joycesiatan@yahoo.com',
                'password' => bcrypt('password'),
                'remember_token' => str_random(40) . time(),
                'user_role' => 'staff',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'user_id' => '5e22213adbba6',
                'first_name' => 'Jorai',
                'middle_name' => 'Wala',
                'last_name' => 'Nogot',
                'username' => 'jorainogot',
                'email' => 'jorainogot@yahoo.com',
                'password' => bcrypt('password'),
                'remember_token' => str_random(40) . time(),
                'user_role' => 'staff',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now
            ],
	    ]);
    }
}
