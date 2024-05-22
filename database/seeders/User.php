<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsUser::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin')
        ]);
    }
}
