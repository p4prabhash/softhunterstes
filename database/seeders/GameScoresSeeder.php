<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameScoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       
        $data = [
            ['display_name' => 'Adam K', 'score' => 120, 'completion_time' => 144],
            ['display_name' => 'Stephan F', 'score' => 109, 'completion_time' => 101],
            ['display_name' => 'Brian L', 'score' => 101, 'completion_time' => 121],
            ['display_name' => 'Ben S', 'score' => 113, 'completion_time' => 87],
            ['display_name' => 'Laura A', 'score' => 109, 'completion_time' => 119],
            ['display_name' => 'Roger M', 'score' => 109, 'completion_time' => 101],
            ['display_name' => 'Mike K', 'score' => 98, 'completion_time' => 198],
            ['display_name' => 'Lily Q', 'score' => 104, 'completion_time' => 107],
            ['display_name' => 'Shane W', 'score' => 104, 'completion_time' => 107],
            ['display_name' => 'Mark T', 'score' => 107, 'completion_time' => 97],
        ];

       
        DB::table('game_scores')->insert($data);

        
        $rankedData = DB::table('game_scores')
            ->orderBy('score', 'desc')
            ->orderBy('completion_time', 'asc')
            ->orderBy('display_name', 'asc')
            ->get();

        
        foreach ($rankedData as $rank) {
            echo "{$rank->display_name} - Score: {$rank->score}, Time: {$rank->completion_time}\n";
        }
    }
}
