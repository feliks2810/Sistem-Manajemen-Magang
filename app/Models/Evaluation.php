<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluation extends Model
{
    protected $fillable = [
        'peserta_profile_id',
        'pembimbing_profile_id',
        'total_nilai',
        'komentar_final',
        'finalized_at',
        'is_final',
    ];

    protected function casts(): array
    {
        return [
            'total_nilai' => 'decimal:2',
            'finalized_at' => 'datetime',
            'is_final' => 'boolean',
        ];
    }

    public function pesertaProfile(): BelongsTo
    {
        return $this->belongsTo(PesertaProfile::class);
    }

    public function pembimbingProfile(): BelongsTo
    {
        return $this->belongsTo(PembimbingProfile::class);
    }

    public function rubricScores(): HasMany
    {
        return $this->hasMany(EvaluationRubricScore::class);
    }

    public function getKategoriAttribute(): string
    {
        $nilai = $this->total_nilai;
        if ($nilai === null) {
            return '-';
        }
        
        if ($nilai >= 90) return 'Sangat Baik';
        if ($nilai >= 80) return 'Baik';
        if ($nilai >= 70) return 'Cukup';
        return 'Kurang';
    }
}
