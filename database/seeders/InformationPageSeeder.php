<?php

namespace Database\Seeders;

use App\Enums\InformationCategory;
use App\Enums\PublishStatus;
use App\Models\DownloadableForm;
use App\Models\Faq;
use App\Models\InformationPage;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Seeder;

class InformationPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds public portal information pages, downloadable forms, and FAQs.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@dinsos.blitarkab.go.id')->first();
        $dtsenService = ServiceType::where('code', 'DTSEN')->first();
        $pbiService = ServiceType::where('code', 'PBI')->first();
        $rehsosService = ServiceType::where('code', 'REHSOS_REQ')->first();

        $pages = [
            [
                'title' => 'Syarat dan Prosedur Penerbitan Surat Keterangan DTSEN Kab. Blitar',
                'slug' => 'syarat-prosedur-sk-dtsen',
                'category' => InformationCategory::Program,
                'service_type_id' => $dtsenService?->id,
                'description' => 'Panduan resmi permohonan Surat Keterangan Data Tunggal Sosial Ekonomi Nasional (DTSEN) bagi warga Kabupaten Blitar yang membutuhkan bukti desil ekonomi untuk persyaratan SPMB afirmasi, beasiswa PIP, KIP Kuliah, dan bantuan sosial.',
                'requirements' => "1. Scan / Foto KTP asli pemohon (atau orang tua/wali jika untuk anak)\n2. Scan / Foto Kartu Keluarga (KK) asli yang masih berlaku\n3. Surat pengantar atau bukti keperluan (dari sekolah/kampus/instansi peminta, opsional)",
                'procedure' => "1. Masuk ke menu Pengajuan Layanan di portal SAPA SOSIAL.\n2. Pilih jenis layanan Surat Keterangan DTSEN dan tentukan tujuan penggunaan.\n3. Lengkapi formulir identitas pemohon dan data orang yang diterangkan.\n4. Unggah dokumen KTP dan KK.\n5. Sistem menerbitkan nomor tiket pengajuan untuk pelacakan berkala.\n6. Petugas memverifikasi kelengkapan dan memeriksa status desil di SIKS-NG.\n7. Pejabat berwenang menyetujui dan menandatangani draf surat.\n8. Surat diterbitkan dengan QR Code verifikasi resmi dan dapat langsung diunduh pemohon.",
                'service_hours' => 'Senin – Kamis: 08.00 – 15.00 WIB | Jumat: 08.00 – 14.30 WIB',
                'location' => 'Kantor Dinas Sosial Kabupaten Blitar, Jl. Kusuma Bangsa No. 1, Kanigoro, Blitar',
                'contact' => 'WhatsApp Pelayanan: 0812-3456-7890 | Email: dtsen@dinsos.blitarkab.go.id',
                'publish_status' => PublishStatus::Published,
                'published_at' => now()->subDays(30),
                'manager_id' => $adminUser?->id,
                'forms' => [
                    [
                        'name' => 'Formulir Permohonan Surat Keterangan DTSEN Blitar.pdf',
                        'file_path' => 'forms/formulir_sk_dtsen_blitar_v2026.pdf',
                        'version' => '2026.1',
                        'is_current' => true,
                    ],
                    [
                        'name' => 'Format Surat Pernyataan Tanggung Jawab Mutlak (SPTJM).docx',
                        'file_path' => 'forms/format_sptjm_dtsen_blitar.docx',
                        'version' => '2026.1',
                        'is_current' => true,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Berapa lama proses penerbitan Surat Keterangan DTSEN?',
                        'answer' => 'Proses penerbitan memerlukan waktu maksimal 2 (dua) hari kerja sejak dokumen dinyatakan lengkap dan lolos pengecekan pada aplikasi SIKS-NG.',
                        'sort_order' => 1,
                    ],
                    [
                        'question' => 'Bagaimana jika nama saya tidak terdaftar di DTSEN atau desil melebihi batas ketentuan?',
                        'answer' => 'Apabila belum terdaftar atau desil melebihi batas ketentuan tujuan penggunaan (misal SPMB/PIP maksimal Desil 5), permohonan akan ditolak disertai alasan tertulis. Pemohon disarankan berkoordinasi dengan pihak desa/kelurahan untuk pengusulan dan pemutakhiran data DTSEN melalui Musyawarah Desa (Musdes).',
                        'sort_order' => 2,
                    ],
                    [
                        'question' => 'Apakah penerbitan SK DTSEN dipungut biaya?',
                        'answer' => 'Seluruh layanan di Dinas Sosial Kabupaten Blitar termasuk penerbitan SK DTSEN adalah GRATIS (bebas biaya). Laporkan jika ada oknum yang meminta pungutan!',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'title' => 'Tata Cara dan Alur Pengajuan Reaktivasi KIS / PBI-JK Nonaktif',
                'slug' => 'tata-cara-reaktivasi-kis-pbi-jk',
                'category' => InformationCategory::Program,
                'service_type_id' => $pbiService?->id,
                'description' => 'Fasilitasi penerbitan rekomendasi dan pengusulan reaktivasi kembali kepesertaan BPJS Kesehatan Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) yang dinonaktifkan oleh Kementerian Sosial.',
                'requirements' => "1. Scan / Foto KTP Peserta\n2. Scan / Foto Kartu Keluarga (KK)\n3. Scan / Foto Kartu BPJS Kesehatan / KIS yang nonaktif\n4. Surat keterangan rawat inap / rawat jalan dari faskes / rumah sakit (wajib bagi alasan medis darurat atau penyakit kronis/katastropik)",
                'procedure' => "1. Pemohon mengajukan permohonan reaktivasi di SAPA SOSIAL dengan mengunggah KTP, KK, Kartu KIS, dan surat keterangan medis.\n2. Petugas memverifikasi kelayakan berdasarkan data DTSEN dan riwayat nonaktif.\n3. Dinas Sosial menerbitkan Surat Rekomendasi Reaktivasi resmi bertanda tangan elektronik.\n4. Petugas menginput usulan reaktivasi ke Kementerian Sosial melalui SIKS-NG.\n5. Petugas memantau persetujuan Kemensos dan aktivasi kepesertaan di BPJS Kesehatan hingga kartu dapat digunakan kembali.",
                'service_hours' => 'Senin – Kamis: 08.00 – 15.00 WIB | Jumat: 08.00 – 14.30 WIB (Pengajuan Darurat Medis diprioritaskan)',
                'location' => 'Bidang Perlindungan dan Jaminan Sosial, Dinsos Kab. Blitar (Kanigoro)',
                'contact' => 'Layanan Siaga KIS: 0812-3456-7891',
                'publish_status' => PublishStatus::Published,
                'published_at' => now()->subDays(25),
                'manager_id' => $adminUser?->id,
                'forms' => [
                    [
                        'name' => 'Formulir Pengajuan Reaktivasi Peserta PBI-JK.pdf',
                        'file_path' => 'forms/formulir_reaktivasi_pbi_jk.pdf',
                        'version' => '2026.1',
                        'is_current' => true,
                    ],
                    [
                        'name' => 'Format Surat Keterangan Medis Faskes untuk Reaktivasi PBI.pdf',
                        'file_path' => 'forms/format_surat_medis_faskes_pbi.pdf',
                        'version' => '2026.1',
                        'is_current' => true,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Kategori apa saja yang dapat direaktivasi kepesertaan PBI-JK nya?',
                        'answer' => 'Peserta yang dinonaktifkan dalam kurun waktu ketentuan Kemensos, dengan prioritas bagi penderita penyakit kronis, katastropik (seperti hemodialisa/cuci darah, kanker, jantung), kondisi darurat medis rawat inap, serta bayi baru lahir dari ibu peserta PBI-JK.',
                        'sort_order' => 1,
                    ],
                    [
                        'question' => 'Berapa lama proses reaktivasi hingga kartu aktif kembali?',
                        'answer' => 'Penerbitan rekomendasi Dinsos berlangsung 1–2 hari kerja. Waktu persetujuan dari Kementerian Sosial dan pengaktifan oleh BPJS Kesehatan berkisar antara 3 sampai 7 hari kerja tergantung jadwal sinkronisasi data nasional.',
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'title' => 'Alur Penanganan dan Pelayanan Rehabilitasi Sosial Dinsos Blitar',
                'slug' => 'alur-pelayanan-rehabilitasi-sosial',
                'category' => InformationCategory::Rehabilitation,
                'service_type_id' => $rehsosService?->id,
                'description' => 'Informasi komprehensif mengenai penanganan kasus Pemerlu Pelayanan Kesejahteraan Sosial (PPKS) meliputi lansia terlantar, penyandang disabilitas, ODGJ terlantar, dan anak memerlukan perlindungan khusus.',
                'requirements' => "1. Identitas klien / pemohon (KTP / KK jika ada)\n2. Surat pengantar dari pemerintah desa / kelurahan setempat\n3. Foto dokumentasi kondisi klien dan lingkungan tempat tinggal",
                'procedure' => "1. Laporan atau permohonan diterima oleh Bidang Rehabilitasi Sosial.\n2. Pekerja Sosial (Peksos) melakukan assessment komprehensif ke lapangan.\n3. Perumusan rencana intervensi: bantuan langsung (alat bantu/sembako/perawatan keluarga) atau rujukan ke panti/balai/RS.\n4. Pelaksanaan intervensi dan monitoring berkala hingga kondisi klien mandiri atau tertangani dengan layak.",
                'service_hours' => 'Pelayanan Kantor: Jam Kerja | Tim Reaksi Cepat (TRC) Evakuasi Darurat: 24 Jam Siaga',
                'location' => 'Bidang Rehabilitasi Sosial, Dinas Sosial Kab. Blitar',
                'contact' => 'Hotline TRC Dinsos: 0811-2345-6789',
                'publish_status' => PublishStatus::Published,
                'published_at' => now()->subDays(20),
                'manager_id' => $adminUser?->id,
                'forms' => [
                    [
                        'name' => 'Format Laporan Kasus PPKS Lapangan Desa.pdf',
                        'file_path' => 'forms/format_laporan_ppks_desa.pdf',
                        'version' => '2026.1',
                        'is_current' => true,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Lembaga rujukan mana saja yang bermitra dengan Dinsos Kabupaten Blitar?',
                        'answer' => 'Dinsos Blitar bekerjasama dengan UPT PSTW Blitar (Panti Lansia), RSUD Ngudi Waluyo Wlingi, RSUD Srengat, RSJ Lawang, Sentra Terpadu Prof. Dr. Soeharso Surakarta, serta LKS disabilitas lokal.',
                        'sort_order' => 1,
                    ],
                ],
            ],
            [
                'title' => 'Layanan Pendampingan, Alat Bantu, dan Fasilitasi Penyandang Disabilitas',
                'slug' => 'layanan-fasilitasi-penyandang-disabilitas',
                'category' => InformationCategory::Disability,
                'service_type_id' => null,
                'description' => 'Program bantuan pemenuhan hak-hak penyandang disabilitas di Kabupaten Blitar, meliputi alat bantu (kursi roda, alat bantu dengar, kruk), pelatihan kemandirian usaha, dan pendampingan advokasi sosial.',
                'requirements' => "1. KTP dan KK pemohon berdomisili Kabupaten Blitar\n2. Surat Keterangan Disabilitas / Medis dari Puskesmas / RS\n3. Surat Keterangan Kurang Mampu (SKTM) dari Desa\n4. Foto seluruh badan yang memperlihatkan kondisi kedisabilitasan",
                'procedure' => "1. Permohonan diajukan melalui portal SAPA SOSIAL atau melalui perangkat desa / Puskesos.\n2. Verifikasi dan assessment kebutuhan oleh Pekerja Sosial.\n3. Penyerahan alat bantu disesuaikan dengan ketersediaan alokasi bantuan tahun anggaran berjalan.",
                'service_hours' => 'Senin – Jumat pada jam kerja dinas',
                'location' => 'Kantor Dinas Sosial Kabupaten Blitar (Kanigoro)',
                'contact' => 'Seksi Disabilitas: 0812-9988-7766',
                'publish_status' => PublishStatus::Published,
                'published_at' => now()->subDays(15),
                'manager_id' => $adminUser?->id,
                'forms' => [],
                'faqs' => [
                    [
                        'question' => 'Alat bantu apa saja yang dapat diajukan bantuan?',
                        'answer' => 'Alat bantu yang dapat difasilitasi antara lain kursi roda standar, kursi roda cerebral palsy (CP), alat bantu dengar, tongkat netra / kruk ketiak, dan kaki / tangan palsu.',
                        'sort_order' => 1,
                    ],
                ],
            ],
            [
                'title' => 'Perlindungan Lanjut Usia Terlantar & Layanan Siaga TRC Dinsos',
                'slug' => 'perlindungan-lansia-terlantar-hotline-trc',
                'category' => InformationCategory::Elderly,
                'service_type_id' => null,
                'description' => 'Layanan perlindungan, perawatan, permakanan, dan evakuasi lansia sebatang kara, terlantar, atau mengalami kekerasan di wilayah Kabupaten Blitar.',
                'requirements' => "1. Keterangan domisili atau titik lokasi ditemukannya lansia\n2. Data identitas pendukung jika ada (KTP/KK)",
                'procedure' => "1. Laporan masuk dari masyarakat atau aparat desa.\n2. Tim Reaksi Cepat (TRC) bergerak ke lokasi untuk penjangkauan awal.\n3. Pemeriksaan kesehatan darurat di Puskesmas / RSUD terdekat.\n4. Penelusuran keluarga (family tracing) atau rujukan ke panti sosial tresna werdha bila sebatang kara.",
                'service_hours' => 'Layanan Reaksi Cepat 24 Jam Nonstop',
                'location' => 'Pos Siaga TRC Dinas Sosial Kab. Blitar',
                'contact' => 'Hotline TRC Lansia: 0811-2345-6789 (Telepon & WhatsApp)',
                'publish_status' => PublishStatus::Published,
                'published_at' => now()->subDays(10),
                'manager_id' => $adminUser?->id,
                'forms' => [],
                'faqs' => [],
            ],
            [
                'title' => 'Kanal Pengaduan Resmi Masyarakat Satu Pintu SAPA SOSIAL',
                'slug' => 'kanal-pengaduan-resmi-sapa-sosial',
                'category' => InformationCategory::Complaint,
                'service_type_id' => null,
                'description' => 'Masyarakat dapat melaporkan segala bentuk permasalahan sosial, penyelewengan bantuan, PPKS terlantar, maupun kendala pelayanan publik bidang sosial secara transparan dan terpantau.',
                'requirements' => "1. Nama dan nomor telepon aktif pelapor (untuk verifikasi dan klarifikasi)\n2. Lokasi kejadian minimal desa/kelurahan dan kecamatan di Kabupaten Blitar\n3. Uraian ringkas dan jelas permasalahan yang dilaporkan\n4. Foto / bukti pendukung (opsional namun sangat disarankan)",
                'procedure' => "1. Buka menu Pengaduan Sosial di portal SAPA SOSIAL.\n2. Isi kategori, lokasi, penjelasan, dan unggah foto bukti.\n3. Dapatkan nomor tiket pengaduan (contoh: ADU-202609-00001).\n4. Petugas menelaah, memverifikasi, dan mendisposisikan ke unit penanganan teknis.\n5. Pelapor dapat memantau setiap langkah penanganan hingga laporan berstatus selesai.",
                'service_hours' => 'Penerimaan Laporan Online: 24 Jam Setiap Hari',
                'location' => 'Seksi Pengaduan & Informasi Publik Dinsos Kab. Blitar',
                'contact' => 'Helpdesk Pengaduan: 0812-0000-0005',
                'publish_status' => PublishStatus::Published,
                'published_at' => now()->subDays(5),
                'manager_id' => $adminUser?->id,
                'forms' => [],
                'faqs' => [
                    [
                        'question' => 'Apakah identitas pelapor dirahasiakan?',
                        'answer' => 'Ya, identitas pelapor dilindungi kerahasiaannya dan hanya digunakan oleh petugas untuk keperluan konfirmasi dan klarifikasi data di lapangan.',
                        'sort_order' => 1,
                    ],
                ],
            ],
        ];

        foreach ($pages as $pageData) {
            $forms = $pageData['forms'];
            $faqs = $pageData['faqs'];
            unset($pageData['forms'], $pageData['faqs']);

            $page = InformationPage::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );

            foreach ($forms as $formData) {
                DownloadableForm::updateOrCreate(
                    [
                        'information_page_id' => $page->id,
                        'name' => $formData['name'],
                    ],
                    [
                        'file_path' => $formData['file_path'],
                        'version' => $formData['version'],
                        'is_current' => $formData['is_current'],
                    ]
                );
            }

            foreach ($faqs as $faqData) {
                Faq::updateOrCreate(
                    [
                        'information_page_id' => $page->id,
                        'question' => $faqData['question'],
                    ],
                    [
                        'answer' => $faqData['answer'],
                        'sort_order' => $faqData['sort_order'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
