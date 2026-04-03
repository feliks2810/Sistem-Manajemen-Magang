<?php

namespace Database\Seeders;

use App\Models\Rubric;
use Illuminate\Database\Seeder;

class RubricSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nama' => 'Disiplin & kehadiran', 'urutan' => 1, 'bobot_maks' => 25],
            ['nama' => 'Keterampilan teknis', 'urutan' => 2, 'bobot_maks' => 25],
            ['nama' => 'Komunikasi & kerja tim', 'urutan' => 3, 'bobot_maks' => 25],
            ['nama' => 'Inisiatif & tanggung jawab', 'urutan' => 4, 'bobot_maks' => 25],
        ];

        foreach ($rows as $r) {
            Rubric::query()->updateOrCreate(
                ['nama' => $r['nama']],
                $r
            );
        }
    }
}
