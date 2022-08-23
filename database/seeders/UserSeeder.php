<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->count(5)->create();
        // for ($i = 0; $i < 10; $i++) {
        //     DB::table('users')->insert([
        //         'name' => Str::random(10),
        //         'email' => Str::random(10) . '@kost.com',
        //         'password' => Hash::make('anakkost'),
        //         'gender' => "Perempuan",
        //         'phone' => "08581099999",
        //     ]);
        // }
        DB::table('users')->insert([
            'name' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'phone' => '85810923499',
            'status' => 'active',
            'password' => Hash::make('admin'),
            'gender' => "Laki-laki",
        ]);
    }
}
