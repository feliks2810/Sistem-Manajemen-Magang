<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\Rubric;

class EvaluationScoreService
{
    public function recalculateTotal(Evaluation $evaluation): void
    {
        $evaluation->load('rubricScores');
        $sumBobot = (float) Rubric::query()->sum('bobot_maks');
        if ($sumBobot <= 0) {
            return;
        }

        $weighted = 0.0;
        foreach ($evaluation->rubricScores as $score) {
            $score->loadMissing('rubric');
            $b = max((float) $score->rubric->bobot_maks, 0.0001);
            $n = (float) $score->nilai; // Value is 0-100
            
            // weighted = sum of (score_out_of_100 * (weight / total_weight))
            $weighted += $n * ($b / $sumBobot);
        }

        $evaluation->update(['total_nilai' => round($weighted, 2)]);
    }
}
