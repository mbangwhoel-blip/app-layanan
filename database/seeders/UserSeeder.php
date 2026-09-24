<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds users across all roles defined in PRD Section 1:
     * Administrator, Petugas Dinsos, Pejabat Penandatangan, Pimpinan,
     * Operator Kecamatan/Desa, and Masyarakat.
     */
    public function run(): void
    {
        $dayasosUnit = WorkUnit::where('name', 'like', '%Dayasos%')->first();
        $linjamsosUnit = WorkUnit::where('name', 'like', '%Linjamsos%')->first();
        $rehsosUnit = WorkUnit::where('name', 'like', '%Rehabilitasi%')->first();
        $sekretariatUnit = WorkUnit::where('name', 'like', '%Sekretariat%')->first();
        $layananUnit = WorkUnit::where('name', 'like', '%Pelayanan Terpadu%')->first();

        $kanigoroDistrict = District::where('code', '35.05.08')->first();
        $satreyanVillage = Village::where('code', '35.05.08.1002')->first();
        $kanigoroVillage = Village::where('code', '35.05.08.1001')->first();
        $srengatDistrict = District::where('code', '35.05.19')->first();
        $dandongVillage = Village::where('code', '35.05.19.1002')->first();

        $users = [
            // 1. Administrator
            [
                'email' => 'admin@dinsos.blitarkab.go.id',
                'name' => 'Administrator SAPA SOSIAL',
                'phone' => '081200000001',
                'nik' => '3505081001800001',
                'work_unit_id' => $sekretariatUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],

            // 2. Petugas Pelayanan Dinsos
            [
                'email' => 'petugas.dtsen@dinsos.blitarkab.go.id',
                'name' => 'Bambang Wijaya, S.Sos',
                'phone' => '081200000002',
                'nik' => '3505081504880002',
                'work_unit_id' => $dayasosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],
            [
                'email' => 'petugas.pbi@dinsos.blitarkab.go.id',
                'name' => 'Dewi Lestari, S.AP',
                'phone' => '081200000003',
                'nik' => '3505086208920003',
                'work_unit_id' => $linjamsosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],
            [
                'email' => 'peksos.rehsos@dinsos.blitarkab.go.id',
                'name' => 'Rahmat Hidayat, S.Tr.Sos',
                'phone' => '081200000004',
                'nik' => '3505082005870004',
                'work_unit_id' => $rehsosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],
            [
                'email' => 'petugas.pengaduan@dinsos.blitarkab.go.id',
                'name' => 'Nur Aini, S.Kom',
                'phone' => '081200000005',
                'nik' => '3505085409950005',
                'work_unit_id' => $layananUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],

            // 3. Pejabat Penandatangan / Pemeriksa (Paraf & TTD)
            [
                'email' => 'kabid.dayasos@dinsos.blitarkab.go.id',
                'name' => 'Drs. H. Mulyono, M.M.',
                'phone' => '081200000006',
                'nik' => '3505081206740006',
                'work_unit_id' => $dayasosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],
            [
                'email' => 'kabid.linjamsos@dinsos.blitarkab.go.id',
                'name' => 'Siti Rochani, S.Sos, M.Si',
                'phone' => '081200000007',
                'nik' => '3505084503780007',
                'work_unit_id' => $linjamsosUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],
            [
                'email' => 'kadis@dinsos.blitarkab.go.id',
                'name' => 'Dr. Bambang Setiawan, M.Si',
                'phone' => '081200000008',
                'nik' => '3505081809700008',
                'work_unit_id' => $sekretariatUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],

            // 4. Pimpinan (Monitoring & Dashboard View)
            [
                'email' => 'sekdin@dinsos.blitarkab.go.id',
                'name' => 'Ir. Hendro Prabowo, M.MT',
                'phone' => '081200000009',
                'nik' => '3505082512750009',
                'work_unit_id' => $sekretariatUnit?->id,
                'district_id' => null,
                'village_id' => null,
                'is_active' => true,
            ],

            // 5. Operator Kecamatan & Desa
            [
                'email' => 'operator.kanigoro@blitarkab.go.id',
                'name' => 'Ahmad Fauzi',
                'phone' => '081200000010',
                'nik' => '3505081102910010',
                'work_unit_id' => null,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => null,
                'is_active' => true,
            ],
            [
                'email' => 'operator.satreyan@blitarkab.go.id',
                'name' => 'Wahyu Utomo',
                'phone' => '081200000011',
                'nik' => '3505082207940011',
                'work_unit_id' => null,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $satreyanVillage?->id,
                'is_active' => true,
            ],
            [
                'email' => 'operator.srengat@blitarkab.go.id',
                'name' => 'Rudi Hartono',
                'phone' => '081200000012',
                'nik' => '3505191703890012',
                'work_unit_id' => null,
                'district_id' => $srengatDistrict?->id,
                'village_id' => null,
                'is_active' => true,
            ],

            // 6. Masyarakat (Warga Pemohon / Pelapor)
            [
                'email' => 'warga.budi@gmail.com',
                'name' => 'Budi Santoso',
                'phone' => '081333444555',
                'nik' => '3505081203850001',
                'work_unit_id' => null,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $satreyanVillage?->id,
                'is_active' => true,
            ],
            [
                'email' => 'warga.siti@gmail.com',
                'name' => 'Siti Aminah',
                'phone' => '081333444666',
                'nik' => '3505085507900002',
                'work_unit_id' => null,
                'district_id' => $kanigoroDistrict?->id,
                'village_id' => $kanigoroVillage?->id,
                'is_active' => true,
            ],
            [
                'email' => 'warga.joko@gmail.com',
                'name' => 'Joko Susilo',
                'phone' => '081333444777',
                'nik' => '3505191508820003',
                'work_unit_id' => null,
                'district_id' => $srengatDistrict?->id,
                'village_id' => $dandongVillage?->id,
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => 'password',
                    'email_verified_at' => now(),
                    'phone' => $userData['phone'],
                    'nik' => $userData['nik'],
                    'work_unit_id' => $userData['work_unit_id'],
                    'district_id' => $userData['district_id'],
                    'village_id' => $userData['village_id'],
                    'is_active' => $userData['is_active'],
                ]
            );
        }
    }
}
