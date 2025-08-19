<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FunctionaryRolesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $data = [];
        $data[] = ['name' => 'Toastmaster of the Day', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'General Evaluator', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'Grammarian', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'Ah-Counter', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'Timer', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'Table Topics Master', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'Speaker', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'Evaluator', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'Vote Counter', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        $data[] = ['name' => 'SAA', 'description' => null, 'created_at' => $now, 'updated_at' => $now];
        DB::table('functionary_roles')->insert($data);
    }
}
