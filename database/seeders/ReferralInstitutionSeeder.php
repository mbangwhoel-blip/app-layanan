<?php

namespace Database\Seeders;

use App\Models\ReferralInstitution;
use Illuminate\Database\Seeder;

class ReferralInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds destination institutions for rehabilitation referrals (panti, balai, rumah sakit, LKS).
     */
    public function run(): void
    {
        $institutions = [
            [
                'name' => 'UPT Pelayanan Sosial Tresna Werdha (PSTW) Blitar',
                'type' => 'panti',
                'address' => 'Jl. Melati No. 12, Kepanjenkidul, Kota Blitar',
                'contact' => '(0342) 801234',
                'is_active' => true,
            ],
            [
                'name' => 'RSUD Ngudi Waluyo Wlingi',
                'type' => 'RS',
                'address' => 'Jl. Dr. Soetomo No. 1, Wlingi, Kabupaten Blitar',
                'contact' => '(0342) 691006',
                'is_active' => true,
            ],
            [
                'name' => 'RSUD Srengat Kabupaten Blitar',
                'type' => 'RS',
                'address' => 'Jl. Raya Dandong No. 101, Srengat, Kabupaten Blitar',
                'contact' => '(0342) 555666',
                'is_active' => true,
            ],
            [
                'name' => 'RSJ Dr. Radjiman Wediodiningrat Lawang',
                'type' => 'RS',
                'address' => 'Jl. Jenderal Ahmad Yani, Sumber Porong, Lawang, Malang',
                'contact' => '(0341) 426015',
                'is_active' => true,
            ],
            [
                'name' => 'Sentra Terpadu "Prof. Dr. Soeharso" Kemensos RI',
                'type' => 'balai',
                'address' => 'Jl. Tentara Pelajar No. 1, Jebres, Kota Surakarta, Jawa Tengah',
                'contact' => '(0271) 714458',
                'is_active' => true,
            ],
            [
                'name' => 'Lembaga Kesejahteraan Sosial (LKS) Disabilitas Kasih Ibu Kanigoro',
                'type' => 'LKS',
                'address' => 'Jl. Kusuma Bangsa, Kanigoro, Kabupaten Blitar',
                'contact' => '081234567890',
                'is_active' => true,
            ],
            [
                'name' => 'UPT Rehabilitasi Sosial Bina Netra / Daksa Dinas Sosial Prov. Jawa Timur',
                'type' => 'balai',
                'address' => 'Jl. Simpang Sulfat Utara No. 2, Malang, Jawa Timur',
                'contact' => '(0341) 491234',
                'is_active' => true,
            ],
        ];

        foreach ($institutions as $inst) {
            ReferralInstitution::updateOrCreate(
                ['name' => $inst['name']],
                $inst
            );
        }
    }
}
