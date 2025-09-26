<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            'name' => 'Готівка',
            'amount' => mt_rand(100, 1000)
        ]);
        DB::table('accounts')->insert([
            'name' => 'Картка',
            'amount' => mt_rand(100, 1000)
        ]);
        DB::table('accounts')->insert([
            'name' => 'Депозит',
            'amount' => mt_rand(100, 1000)
        ]);
    }
}
