<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            DcpGoalsSeeder::class,
            EvaluationTypesAndCriteriaSeeder::class,
            FunctionaryRolesSeeder::class,
        ]);

$this->call([
            FunctionaryRolesSeeder::class,
            EvaluationTypesAndCriteriaSeeder::class,
            DcpGoalsSeeder::class,
        ]);
    }
}
