<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EvaluationTypesAndCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $types = [];
        $types[] = ['name' => 'Prepared Speech', 'description' => 'Evaluation for prepared speeches', 'created_at' => $now, 'updated_at' => $now];
        $types[] = ['name' => 'Table Topic', 'description' => 'Evaluation for impromptu speeches', 'created_at' => $now, 'updated_at' => $now];
        DB::table('evaluation_types')->insert($types);

        $typeMap = DB::table('evaluation_types')->pluck('id','name');
        $criteria = [];
        // Criteria for Prepared Speech
        $typeId = $typeMap['Prepared Speech'];
        $criteria = array_merge($criteria, [
            ['evaluation_type_id' => $typeId, 'name' => 'Content', 'description' => 'Structure, coherence, objectives met', 'created_at' => $now, 'updated_at' => $now],
            ['evaluation_type_id' => $typeId, 'name' => 'Delivery', 'description' => 'Voice, body language, engagement', 'created_at' => $now, 'updated_at' => $now],
            ['evaluation_type_id' => $typeId, 'name' => 'Language', 'description' => 'Vocabulary, grammar, clarity', 'created_at' => $now, 'updated_at' => $now],
            ['evaluation_type_id' => $typeId, 'name' => 'Time', 'description' => 'Within target time', 'created_at' => $now, 'updated_at' => $now],
        ]);
        // Criteria for Table Topic
        $typeId = $typeMap['Table Topic'];
        $criteria = array_merge($criteria, [
            ['evaluation_type_id' => $typeId, 'name' => 'Structure', 'description' => 'Opening, body, closing', 'created_at' => $now, 'updated_at' => $now],
            ['evaluation_type_id' => $typeId, 'name' => 'Clarity', 'description' => 'Message clarity', 'created_at' => $now, 'updated_at' => $now],
            ['evaluation_type_id' => $typeId, 'name' => 'Engagement', 'description' => 'Presence and confidence', 'created_at' => $now, 'updated_at' => $now],
            ['evaluation_type_id' => $typeId, 'name' => 'Time', 'description' => 'Within target time', 'created_at' => $now, 'updated_at' => $now],
        ]);
        DB::table('evaluation_criteria')->insert($criteria);
    }
}
