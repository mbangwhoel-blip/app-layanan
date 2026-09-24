<?php

namespace Database\Seeders;

use App\Models\DtsenPurpose;
use Illuminate\Database\Seeder;

class DtsenPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds purposes for DTSEN certificate issuing with max decile thresholds and validity days.
     */
    public function run(): void
    {
        $purposes = [
            [
                'code' => 'spmb',
                'name' => 'SPMB Jalur Afirmasi (SD / SMP / SMA / SMK)',
                'max_decile' => 5,
                'validity_days' => 90,
                'is_active' => true,
            ],
            [
                'code' => 'pip',
                'name' => 'Program Indonesia Pintar (PIP)',
                'max_decile' => 4,
                'validity_days' => 180,
                'is_active' => true,
            ],
            [
                'code' => 'kip_kuliah',
                'name' => 'KIP Kuliah / Perguruan Tinggi',
                'max_decile' => 4,
                'validity_days' => 180,
                'is_active' => true,
            ],
            [
                'code' => 'bansos',
                'name' => 'Pengusulan / Verifikasi Bantuan Sosial',
                'max_decile' => 4,
                'validity_days' => 90,
                'is_active' => true,
            ],
            [
                'code' => 'kesehatan',
                'name' => 'Jaminan Pelayanan Kesehatan / Keringanan Biaya RS',
                'max_decile' => 5,
                'validity_days' => 30,
                'is_active' => true,
            ],
            [
                'code' => 'lainnya',
                'name' => 'Keperluan Administrasi Lainnya',
                'max_decile' => 4,
                'validity_days' => 60,
                'is_active' => true,
            ],
        ];

        foreach ($purposes as $purpose) {
            DtsenPurpose::updateOrCreate(
                ['code' => $purpose['code']],
                $purpose
            );
        }
    }
}
