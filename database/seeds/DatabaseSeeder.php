<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => "admin",
            'lastname' => "admin",
            'email' => 'admin@gmail.com',
            'password' =>  Hash::make('123'),
        ]);
    }
}
?>