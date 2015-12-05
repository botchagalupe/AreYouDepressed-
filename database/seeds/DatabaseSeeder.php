<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call('UserTableSeeder');


        Setting::create([
            'name' => 'password', 
            'setting' => Hash::make(env('ADMIN_PASSWORD'))
        ]);

        Setting::create([
            'name' => 'name', 
            'setting' => env('NAME')
        ]);

        Setting::create([
            'name' => 'email', 
            'setting' => env('ADMIN_EMAIL')
        ]);

        Setting::create([
            'name' => 'email_period_lower_bound', 
            'setting' => 22
        ]);

        Setting::create([
            'name' => 'email_period_upper_bound', 
            'setting' => 8
        ]);

        Setting::create([
            'name' => 'last_email', 
            'setting' => 0
        ]);

        Model::reguard();
    }
}
