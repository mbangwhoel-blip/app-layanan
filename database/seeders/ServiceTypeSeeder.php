<?php

namespace Database\Seeders;

use App\Enums\ServiceRequestHandler;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds standard social services and their document requirements.
     */
    public function run(): void
    {
        $services = [
            [
                'code' => 'DTSEN',
                'name' => 'Surat Keterangan DTSEN',
                'category' => 'Pemberdayaan Sosial',
                'description' => 'Penerbitan surat keterangan yang menerangkan status seseorang/keluarga dalam Data Tunggal Sosial Ekonomi Nasional (DTSEN), termasuk peringkat desil untuk syarat SPMB jalur afirmasi, PIP, KIP Kuliah, bansos, dan layanan kesehatan.',
                'handler' => ServiceRequestHandler::Dtsen,
                'needs_assessment' => false,
                'sla_days' => 2,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'Kartu Tanda Penduduk (KTP) Pemohon',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Pengantar Sekolah / Keterangan Kuliah / Bukti Keperluan',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'code' => 'PBI',
                'name' => 'Reaktivasi KIS / PBI-JK',
                'category' => 'Perlindungan dan Jaminan Sosial',
                'description' => 'Fasilitasi pengaktifan kembali kepesertaan JKN-KIS Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) yang dinonaktifkan dengan rekomendasi Dinas Sosial ke Kementerian Sosial.',
                'handler' => ServiceRequestHandler::Pbi,
                'needs_assessment' => false,
                'sla_days' => 7,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'Kartu Tanda Penduduk (KTP) Peserta',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Kartu BPJS Kesehatan / KIS Non-Aktif',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Surat Keterangan Rawat / Medis dari Fasilitas Kesehatan (RS/Puskesmas)',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
            [
                'code' => 'REHSOS_REQ',
                'name' => 'Permohonan Pelayanan Rehabilitasi Sosial',
                'category' => 'Rehabilitasi Sosial',
                'description' => 'Permohonan penanganan, pembinaan, rehabilitasi, atau rujukan panti bagi Pemerlu Pelayanan Kesejahteraan Sosial (lansia terlantar, disabilitas, ODGJ, anak terlantar).',
                'handler' => ServiceRequestHandler::Generic,
                'needs_assessment' => true,
                'sla_days' => 5,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'Identitas Klien / Pemohon (KTP / KK jika ada)',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Surat Pengantar / Keterangan dari Desa / Kelurahan',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Foto Dokumentasi Kondisi Klien dan Lingkungan',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'code' => 'BANSOS_REC',
                'name' => 'Surat Rekomendasi Bantuan Sosial Insidentil',
                'category' => 'Perlindungan dan Jaminan Sosial',
                'description' => 'Permohonan rekomendasi bantuan sosial untuk warga kurang mampu dalam kondisi kedaruratan sosial ekonomi atau terdampak bencana.',
                'handler' => ServiceRequestHandler::Generic,
                'needs_assessment' => true,
                'sla_days' => 3,
                'is_active' => true,
                'requirements' => [
                    [
                        'name' => 'Kartu Tanda Penduduk (KTP) Pemohon',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Kartu Keluarga (KK)',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Surat Keterangan Tidak Mampu (SKTM) dari Desa / Kelurahan',
                        'is_mandatory' => true,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Surat Keterangan / Bukti Kejadian Kedaruratan atau Bencana',
                        'is_mandatory' => false,
                        'allowed_mimes' => 'pdf,jpg,jpeg,png',
                        'sort_order' => 4,
                    ],
                ],
            ],
        ];

        foreach ($services as $serviceData) {
            $requirements = $serviceData['requirements'];
            unset($serviceData['requirements']);

            $serviceType = ServiceType::updateOrCreate(
                ['code' => $serviceData['code']],
                $serviceData
            );

            foreach ($requirements as $reqData) {
                ServiceRequirement::updateOrCreate(
                    [
                        'service_type_id' => $serviceType->id,
                        'name' => $reqData['name'],
                    ],
                    [
                        'is_mandatory' => $reqData['is_mandatory'],
                        'allowed_mimes' => $reqData['allowed_mimes'],
                        'sort_order' => $reqData['sort_order'],
                    ]
                );
            }
        }
    }
}
