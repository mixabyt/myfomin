<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Спорт',
            'type' => 'spend',
        ]);
        DB::table('categories')->insert([
            'name' => 'Догляд за собою',
            'type' => 'spend',
        ]);
        DB::table('categories')->insert([
            'name' => 'Супермаркети',
            'type' => 'spend',
        ]);
        // \\
        DB::table('categories')->insert([
            'name' => 'Зарплата',
            'type' => 'deposit',
        ]);
        DB::table('categories')->insert([
            'name' => 'Подарунки',
            'type' => 'deposit',
        ]);
        DB::table('categories')->insert([
            'name' => 'Стипендія',
            'type' => 'deposit',
        ]);
    }
}
