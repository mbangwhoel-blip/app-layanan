<?php

namespace Database\Seeders;

use App\Enums\ApprovalDecision;
use App\Enums\ComplaintStatus;
use App\Enums\Gender;
use App\Enums\HandlingType;
use App\Enums\MinistryDecision;
use App\Enums\PbiReactivationReason;
use App\Enums\ReferralStatus;
use App\Enums\RehabilitationCaseStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\Assessment;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\Disposition;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\InformationPage;
use App\Models\MonitoringRecord;
use App\Models\NumberSequence;
use App\Models\PageVisit;
use App\Models\PbiReactivation;
use App\Models\Referral;
use App\Models\ReferralInstitution;
use App\Models\RehabilitationCase;
use App\Models\SearchLog;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds realistic operational sample data across all services:
     * - DTSEN Service Requests with Certificates, Approvals, and Documents
     * - PBI-JK Service Requests with Reactivation Details and Ministry Workflow
     * - Rehabilitation Clients, Cases, Assessments, Referrals, and Monitoring
     * - Social Complaints, Attachments, and Dispositions
     * - Status Histories (Polymorphic)
     * - Page Visits and Search Logs
     * - Number Sequences
     */
    public function run(): void
    {
        $currentPeriod = now()->format('Ym');

        // Reference Users
        $officerDtsen = User::where('email', 'petugas.dtsen@dinsos.blitarkab.go.id')->first();
        $officerPbi = User::where('email', 'petugas.pbi@dinsos.blitarkab.go.id')->first();
        $officerRehsos = User::where('email', 'peksos.rehsos@dinsos.blitarkab.go.id')->first();
        $officerPengaduan = User::where('email', 'petugas.pengaduan@dinsos.blitarkab.go.id')->first();
        $kabidDayasos = User::where('email', 'kabid.dayasos@dinsos.blitarkab.go.id')->first();
        $kabidLinjamsos = User::where('email', 'kabid.linjamsos@dinsos.blitarkab.go.id')->first();
        $kadis = User::where('email', 'kadis@dinsos.blitarkab.go.id')->first();
        $wargaBudi = User::where('email', 'warga.budi@gmail.com')->first();
        $wargaSiti = User::where('email', 'warga.siti@gmail.com')->first();
        $wargaJoko = User::where('email', 'warga.joko@gmail.com')->first();

        // Reference Work Units
        $dayasosUnit = WorkUnit::where('name', 'like', '%Dayasos%')->first();
        $linjamsosUnit = WorkUnit::where('name', 'like', '%Linjamsos%')->first();
        $rehsosUnit = WorkUnit::where('name', 'like', '%Rehabilitasi%')->first();
        $layananUnit = WorkUnit::where('name', 'like', '%Pelayanan Terpadu%')->first();

        // Reference Service Types
        $dtsenService = ServiceType::where('code', 'DTSEN')->first();
        $pbiService = ServiceType::where('code', 'PBI')->first();

        // Reference Purposes
        $purposeSpmb = DtsenPurpose::where('code', 'spmb')->first();
        $purposePip = DtsenPurpose::where('code', 'pip')->first();
        $purposeKip = DtsenPurpose::where('code', 'kip_kuliah')->first();
        $purposeBansos = DtsenPurpose::where('code', 'bansos')->first();

        // Reference Villages
        $villageSatreyan = Village::where('code', '35.05.08.1002')->first();
        $villageKanigoro = Village::where('code', '35.05.08.1001')->first();
        $villageSawentar = Village::where('code', '35.05.08.2012')->first();
        $villageDandong = Village::where('code', '35.05.19.1002')->first();
        $villageBendo = Village::where('code', '35.05.15.1003')->first() ?? $villageSatreyan;
        $villageGarum = Village::where('code', '35.05.15.1001')->first() ?? $villageSatreyan;

        // Requirements
        $dtsenKtpReq = ServiceRequirement::where('service_type_id', $dtsenService?->id)->where('name', 'like', '%KTP%')->first();
        $dtsenKkReq = ServiceRequirement::where('service_type_id', $dtsenService?->id)->where('name', 'like', '%Keluarga%')->first();

        $pbiKtpReq = ServiceRequirement::where('service_type_id', $pbiService?->id)->where('name', 'like', '%KTP%')->first();
        $pbiKkReq = ServiceRequirement::where('service_type_id', $pbiService?->id)->where('name', 'like', '%Keluarga%')->first();
        $pbiBpjsReq = ServiceRequirement::where('service_type_id', $pbiService?->id)->where('name', 'like', '%BPJS%')->first();
        $pbiMedisReq = ServiceRequirement::where('service_type_id', $pbiService?->id)->where('name', 'like', '%Medis%')->first();

        // =========================================================================
        // 1. DTSEN Service Requests
        // =========================================================================

        // 1.1 Issued & Completed (Budi Santoso - SPMB Jalur Afirmasi)
        $req1Number = "DTSEN-{$currentPeriod}-00001";
        $req1 = ServiceRequest::updateOrCreate(
            ['request_number' => $req1Number],
            [
                'service_type_id' => $dtsenService->id,
                'submitter_id' => $wargaBudi?->id,
                'applicant_name' => 'Budi Santoso',
                'applicant_nik' => '3505081203850001',
                'family_card_number' => '3505080101050001',
                'address' => 'Jl. Kusuma Bangsa RT 02 RW 03, Kelurahan Satreyan',
                'village_id' => $villageSatreyan->id,
                'phone' => '081333444555',
                'submitted_at' => now()->subDays(4),
                'officer_id' => $officerDtsen?->id,
                'work_unit_id' => $dayasosUnit?->id,
                'status' => ServiceRequestStatus::Completed,
                'is_priority' => false,
                'verification_result' => 'Data terverifikasi aktif pada SIKS-NG Kabupaten Blitar peringkat Desil 2.',
                'officer_notes' => 'Berkas KTP dan KK valid sesuai data Dukcapil dan SIKS-NG.',
                'service_result' => 'Surat Keterangan DTSEN telah diterbitkan dan ditandatangani Kepala Dinas Sosial.',
                'completed_at' => now()->subDays(1),
            ]
        );

        if ($dtsenKtpReq && $dtsenKkReq) {
            ServiceRequestDocument::updateOrCreate(
                ['service_request_id' => $req1->id, 'service_requirement_id' => $dtsenKtpReq->id],
                ['file_path' => 'documents/dtsen_ktp_budi.pdf', 'original_name' => 'KTP_Budi_Santoso.pdf', 'verification_status' => 'valid']
            );
            ServiceRequestDocument::updateOrCreate(
                ['service_request_id' => $req1->id, 'service_requirement_id' => $dtsenKkReq->id],
                ['file_path' => 'documents/dtsen_kk_budi.pdf', 'original_name' => 'KK_Budi_Santoso.pdf', 'verification_status' => 'valid']
            );
        }

        $cert1 = DtsenCertificate::updateOrCreate(
            ['service_request_id' => $req1->id],
            [
                'dtsen_purpose_id' => $purposeSpmb->id,
                'purpose_description' => 'Persyaratan Pendaftaran SPMB Jalur Afirmasi SMAN 1 Talun',
                'subject_name' => 'Dimas Pratama',
                'subject_nik' => '3505081010120001',
                'relationship_to_applicant' => 'Anak Kandung',
                'is_registered' => true,
                'decile' => 2,
                'checked_at' => now()->subDays(3),
                'checker_id' => $officerDtsen?->id,
                'certificate_number' => '400.9/101/409.105/2026',
                'issued_at' => now()->subDays(1),
                'valid_until' => now()->addDays(90)->toDateString(),
                'signer_id' => $kadis?->id,
                'file_path' => 'certificates/SK_DTSEN_400_9_101_2026.pdf',
                'verification_code' => 'V-DTSEN-2026-0001',
            ]
        );

        // Approvals for Cert 1 (Step 1: Kabid, Step 2: Kadis)
        $cert1->approvals()->updateOrCreate(
            ['step' => 1],
            [
                'approver_id' => $kabidDayasos?->id,
                'decision' => ApprovalDecision::Approved,
                'notes' => 'Data SIKS-NG valid desil 2, draf disetujui untuk tanda tangan Kepala Dinas.',
                'decided_at' => now()->subDays(2),
            ]
        );
        $cert1->approvals()->updateOrCreate(
            ['step' => 2],
            [
                'approver_id' => $kadis?->id,
                'decision' => ApprovalDecision::Approved,
                'notes' => 'Disetujui dan ditandatangani secara elektronik.',
                'decided_at' => now()->subDays(1),
            ]
        );

        $this->recordStatusChain($req1, [
            ['from' => null, 'to' => ServiceRequestStatus::Submitted->value, 'notes' => 'Pengajuan diajukan oleh pemohon', 'time' => now()->subDays(4), 'user' => $wargaBudi],
            ['from' => ServiceRequestStatus::Submitted->value, 'to' => ServiceRequestStatus::DocumentCheck->value, 'notes' => 'Pemeriksaan berkas oleh petugas', 'time' => now()->subDays(3)->subHours(5), 'user' => $officerDtsen],
            ['from' => ServiceRequestStatus::DocumentCheck->value, 'to' => ServiceRequestStatus::DataVerification->value, 'notes' => 'Pengecekan data di SIKS-NG: Terdaftar Desil 2', 'time' => now()->subDays(3), 'user' => $officerDtsen],
            ['from' => ServiceRequestStatus::DataVerification->value, 'to' => ServiceRequestStatus::AwaitingApproval->value, 'notes' => 'Draf surat diteruskan ke Pejabat Penandatangan', 'time' => now()->subDays(2), 'user' => $officerDtsen],
            ['from' => ServiceRequestStatus::AwaitingApproval->value, 'to' => ServiceRequestStatus::Issued->value, 'notes' => 'Surat ditandatangani Kadis dan QR diterbitkan', 'time' => now()->subDays(1), 'user' => $kadis],
            ['from' => ServiceRequestStatus::Issued->value, 'to' => ServiceRequestStatus::Completed->value, 'notes' => 'Surat selesai diunduh oleh pemohon', 'time' => now()->subDays(1)->addHours(2), 'user' => $officerDtsen],
        ]);

        // 1.2 Awaiting Approval (Siti Aminah - KIP Kuliah)
        $req2Number = "DTSEN-{$currentPeriod}-00002";
        $req2 = ServiceRequest::updateOrCreate(
            ['request_number' => $req2Number],
            [
                'service_type_id' => $dtsenService->id,
                'submitter_id' => $wargaSiti?->id,
                'applicant_name' => 'Siti Aminah',
                'applicant_nik' => '3505085507900002',
                'family_card_number' => '3505080101050002',
                'address' => 'Jl. Diponegoro RT 01 RW 01, Kelurahan Kanigoro',
                'village_id' => $villageKanigoro->id,
                'phone' => '081333444666',
                'submitted_at' => now()->subDays(2),
                'officer_id' => $officerDtsen?->id,
                'work_unit_id' => $dayasosUnit?->id,
                'status' => ServiceRequestStatus::AwaitingApproval,
                'is_priority' => false,
                'verification_result' => 'Terdaftar pada DTSEN Desil 3.',
                'officer_notes' => 'Syarat KTP dan KK lengkap, memenuhi kriteria KIP Kuliah (maks. Desil 4).',
            ]
        );

        $cert2 = DtsenCertificate::updateOrCreate(
            ['service_request_id' => $req2->id],
            [
                'dtsen_purpose_id' => $purposeKip->id,
                'purpose_description' => 'Syarat Verifikasi Pendaftaran KIP Kuliah Universitas Brawijaya',
                'subject_name' => 'Siti Aminah',
                'subject_nik' => '3505085507900002',
                'relationship_to_applicant' => 'Diri Sendiri',
                'is_registered' => true,
                'decile' => 3,
                'checked_at' => now()->subDays(1),
                'checker_id' => $officerDtsen?->id,
            ]
        );

        $cert2->approvals()->updateOrCreate(
            ['step' => 1],
            [
                'approver_id' => $kabidDayasos?->id,
                'decision' => ApprovalDecision::Approved,
                'notes' => 'Paraf disetujui, menunggu tanda tangan Kepala Dinas.',
                'decided_at' => now()->subHours(6),
            ]
        );

        $this->recordStatusChain($req2, [
            ['from' => null, 'to' => ServiceRequestStatus::Submitted->value, 'notes' => 'Pengajuan diajukan oleh pemohon', 'time' => now()->subDays(2), 'user' => $wargaSiti],
            ['from' => ServiceRequestStatus::Submitted->value, 'to' => ServiceRequestStatus::DataVerification->value, 'notes' => 'Verifikasi berkas dan pengecekan SIKS-NG Desil 3', 'time' => now()->subDays(1), 'user' => $officerDtsen],
            ['from' => ServiceRequestStatus::DataVerification->value, 'to' => ServiceRequestStatus::AwaitingApproval->value, 'notes' => 'Menunggu persetujuan Kepala Dinas', 'time' => now()->subHours(6), 'user' => $kabidDayasos],
        ]);

        // 1.3 Data Verification (Joko Susilo - PIP)
        $req3Number = "DTSEN-{$currentPeriod}-00003";
        $req3 = ServiceRequest::updateOrCreate(
            ['request_number' => $req3Number],
            [
                'service_type_id' => $dtsenService->id,
                'submitter_id' => $wargaJoko?->id,
                'applicant_name' => 'Joko Susilo',
                'applicant_nik' => '3505191508820003',
                'family_card_number' => '3505190101050003',
                'address' => 'Desa Dandong RT 03 RW 02, Srengat',
                'village_id' => $villageDandong->id,
                'phone' => '081333444777',
                'submitted_at' => now()->subDay(),
                'officer_id' => $officerDtsen?->id,
                'work_unit_id' => $dayasosUnit?->id,
                'status' => ServiceRequestStatus::DataVerification,
                'is_priority' => false,
                'officer_notes' => 'Sedang dalam pengecekan desil pada SIKS-NG Kemensos.',
            ]
        );

        DtsenCertificate::updateOrCreate(
            ['service_request_id' => $req3->id],
            [
                'dtsen_purpose_id' => $purposePip->id,
                'purpose_description' => 'Verifikasi Bantuan PIP SDN 1 Dandong',
                'subject_name' => 'Fajar Susilo',
                'subject_nik' => '3505191112150001',
                'relationship_to_applicant' => 'Anak Kandung',
                'is_registered' => true,
                'decile' => 4,
                'checked_at' => now()->subHours(2),
                'checker_id' => $officerDtsen?->id,
            ]
        );

        // 1.4 Document Check (Baru Masuk)
        $req4Number = "DTSEN-{$currentPeriod}-00004";
        ServiceRequest::updateOrCreate(
            ['request_number' => $req4Number],
            [
                'service_type_id' => $dtsenService->id,
                'submitter_id' => null,
                'applicant_name' => 'Anisa Rahmawati',
                'applicant_nik' => '3505086504990004',
                'family_card_number' => '3505080101050004',
                'address' => 'Desa Sawentar RT 01 RW 04, Kanigoro',
                'village_id' => $villageSawentar->id,
                'phone' => '081234567888',
                'submitted_at' => now()->subHours(3),
                'status' => ServiceRequestStatus::DocumentCheck,
                'is_priority' => false,
            ]
        );

        // 1.5 Rejected (Anton Pratama - Desil 7 melebihi batas SPMB)
        $req5Number = "DTSEN-{$currentPeriod}-00005";
        $req5 = ServiceRequest::updateOrCreate(
            ['request_number' => $req5Number],
            [
                'service_type_id' => $dtsenService->id,
                'submitter_id' => null,
                'applicant_name' => 'Anton Pratama',
                'applicant_nik' => '3505081208800005',
                'family_card_number' => '3505080101050005',
                'address' => 'Kelurahan Kanigoro RT 03 RW 01',
                'village_id' => $villageKanigoro->id,
                'phone' => '081234567999',
                'submitted_at' => now()->subDays(5),
                'officer_id' => $officerDtsen?->id,
                'work_unit_id' => $dayasosUnit?->id,
                'status' => ServiceRequestStatus::Rejected,
                'is_priority' => false,
                'verification_result' => 'Hasil verifikasi data SIKS-NG menunjukkan posisi Desil 7.',
                'rejection_reason' => 'Peringkat desil hasil verifikasi SIKS-NG adalah Desil 7, melebihi ketentuan batas maksimal Desil 5 untuk tujuan SPMB Afirmasi. Disarankan berkoordinasi dengan Pemerintah Desa setempat untuk pemutakhiran data DTSEN melalui Musyawarah Desa.',
            ]
        );

        DtsenCertificate::updateOrCreate(
            ['service_request_id' => $req5->id],
            [
                'dtsen_purpose_id' => $purposeSpmb->id,
                'purpose_description' => 'SPMB Jalur Afirmasi',
                'subject_name' => 'Anton Pratama',
                'subject_nik' => '3505081208800005',
                'relationship_to_applicant' => 'Diri Sendiri',
                'is_registered' => true,
                'decile' => 7,
                'checked_at' => now()->subDays(4),
                'checker_id' => $officerDtsen?->id,
            ]
        );

        // =========================================================================
        // 2. PBI-JK Reaktivasi Service Requests
        // =========================================================================

        // 2.1 Reactivated & Completed (Marsono - Darurat Medis / Priority)
        $pbi1Number = "PBI-{$currentPeriod}-00001";
        $pbiReq1 = ServiceRequest::updateOrCreate(
            ['request_number' => $pbi1Number],
            [
                'service_type_id' => $pbiService->id,
                'submitter_id' => $wargaBudi?->id,
                'applicant_name' => 'Marsono',
                'applicant_nik' => '3505080506600001',
                'family_card_number' => '3505080101050006',
                'address' => 'Kelurahan Satreyan RT 01 RW 02, Kanigoro',
                'village_id' => $villageSatreyan->id,
                'phone' => '081333444555',
                'submitted_at' => now()->subDays(8),
                'officer_id' => $officerPbi?->id,
                'work_unit_id' => $linjamsosUnit?->id,
                'status' => ServiceRequestStatus::Completed,
                'is_priority' => true,
                'verification_result' => 'Pasien rawat darurat di RSUD Ngudi Waluyo Wlingi, desil 1.',
                'officer_notes' => 'Kategori darurat medis, rekomendasi diproses cepat.',
                'service_result' => 'Kepesertaan PBI-JK telah aktif kembali di BPJS Kesehatan per tanggal '.now()->subDays(1)->format('d/m/Y').'.',
                'completed_at' => now()->subDays(1),
            ]
        );

        PbiReactivation::updateOrCreate(
            ['service_request_id' => $pbiReq1->id],
            [
                'participant_name' => 'Marsono',
                'participant_nik' => '3505080506600001',
                'bpjs_card_number' => '0001567890123',
                'deactivated_date' => now()->subMonths(2)->toDateString(),
                'reason' => PbiReactivationReason::Emergency,
                'health_facility_name' => 'RSUD Ngudi Waluyo Wlingi',
                'health_letter_number' => '445/892/RSUD-NW/2026',
                'decile' => 1,
                'eligibility_notes' => 'Sangat layak, kondisi darurat medis rawat inap ICU.',
                'recommendation_number' => '400.9/201/409.105/2026',
                'recommendation_issued_at' => now()->subDays(6),
                'signer_id' => $kadis?->id,
                'proposed_to_ministry_at' => now()->subDays(5),
                'ministry_decision' => MinistryDecision::Approved,
                'ministry_decided_at' => now()->subDays(2),
                'reactivated_date' => now()->subDays(1)->toDateString(),
            ]
        );

        $this->recordStatusChain($pbiReq1, [
            ['from' => null, 'to' => ServiceRequestStatus::Submitted->value, 'notes' => 'Pengajuan reaktivasi darurat medis masuk', 'time' => now()->subDays(8), 'user' => $wargaBudi],
            ['from' => ServiceRequestStatus::Submitted->value, 'to' => ServiceRequestStatus::EligibilityVerification->value, 'notes' => 'Verifikasi berkas & kelayakan medis', 'time' => now()->subDays(7), 'user' => $officerPbi],
            ['from' => ServiceRequestStatus::EligibilityVerification->value, 'to' => ServiceRequestStatus::RecommendationIssued->value, 'notes' => 'Surat rekomendasi terbit disetujui Kadis', 'time' => now()->subDays(6), 'user' => $kadis],
            ['from' => ServiceRequestStatus::RecommendationIssued->value, 'to' => ServiceRequestStatus::ProposedToMinistry->value, 'notes' => 'Data diusulkan ke Kemensos melalui SIKS-NG', 'time' => now()->subDays(5), 'user' => $officerPbi],
            ['from' => ServiceRequestStatus::ProposedToMinistry->value, 'to' => ServiceRequestStatus::MinistryApproved->value, 'notes' => 'Kemensos menyetujui usulan reaktivasi', 'time' => now()->subDays(2), 'user' => $officerPbi],
            ['from' => ServiceRequestStatus::MinistryApproved->value, 'to' => ServiceRequestStatus::Reactivated->value, 'notes' => 'BPJS Kesehatan telah mengaktifkan kepesertaan', 'time' => now()->subDays(1), 'user' => $officerPbi],
            ['from' => ServiceRequestStatus::Reactivated->value, 'to' => ServiceRequestStatus::Completed->value, 'notes' => 'Pelayanan selesai, tiket ditutup', 'time' => now()->subDays(1)->addHours(3), 'user' => $officerPbi],
        ]);

        // 2.2 Proposed to Ministry (Sumiyati - Penyakit Kronis / Hemodialisa)
        $pbi2Number = "PBI-{$currentPeriod}-00002";
        $pbiReq2 = ServiceRequest::updateOrCreate(
            ['request_number' => $pbi2Number],
            [
                'service_type_id' => $pbiService->id,
                'submitter_id' => $wargaSiti?->id,
                'applicant_name' => 'Sumiyati',
                'applicant_nik' => '3505084102650002',
                'family_card_number' => '3505080101050007',
                'address' => 'Kelurahan Kanigoro RT 02 RW 02',
                'village_id' => $villageKanigoro->id,
                'phone' => '081333444666',
                'submitted_at' => now()->subDays(4),
                'officer_id' => $officerPbi?->id,
                'work_unit_id' => $linjamsosUnit?->id,
                'status' => ServiceRequestStatus::ProposedToMinistry,
                'is_priority' => true,
                'verification_result' => 'Pasien rutin cuci darah (hemodialisa) 2x seminggu di RSUD Srengat.',
                'officer_notes' => 'Usulan telah diinput ke SIKS-NG, menunggu approval berkala Kemensos.',
            ]
        );

        PbiReactivation::updateOrCreate(
            ['service_request_id' => $pbiReq2->id],
            [
                'participant_name' => 'Sumiyati',
                'participant_nik' => '3505084102650002',
                'bpjs_card_number' => '0001678901234',
                'deactivated_date' => now()->subMonths(1)->toDateString(),
                'reason' => PbiReactivationReason::Chronic,
                'health_facility_name' => 'RSUD Srengat Kabupaten Blitar',
                'health_letter_number' => '440/120/RSUD-SRG/2026',
                'decile' => 2,
                'eligibility_notes' => 'Rekomendasi disetujui untuk pembiayaan hemodialisa.',
                'recommendation_number' => '400.9/202/409.105/2026',
                'recommendation_issued_at' => now()->subDays(2),
                'signer_id' => $kadis?->id,
                'proposed_to_ministry_at' => now()->subDay(),
                'ministry_decision' => MinistryDecision::Pending,
            ]
        );

        // 2.3 Awaiting Approval (Kasidi - Penyakit Katastropik Jantung)
        $pbi3Number = "PBI-{$currentPeriod}-00003";
        $pbiReq3 = ServiceRequest::updateOrCreate(
            ['request_number' => $pbi3Number],
            [
                'service_type_id' => $pbiService->id,
                'submitter_id' => null,
                'applicant_name' => 'Kasidi',
                'applicant_nik' => '3505191104580001',
                'family_card_number' => '3505190101050008',
                'address' => 'Kelurahan Dandong RT 02 RW 01, Srengat',
                'village_id' => $villageDandong->id,
                'phone' => '085233112233',
                'submitted_at' => now()->subDays(2),
                'officer_id' => $officerPbi?->id,
                'work_unit_id' => $linjamsosUnit?->id,
                'status' => ServiceRequestStatus::AwaitingApproval,
                'is_priority' => false,
                'verification_result' => 'Terverifikasi desil 1, diagnosa penyakit jantung rujukan faskes.',
                'officer_notes' => 'Draf surat rekomendasi menunggu persetujuan Kepala Dinas.',
            ]
        );

        PbiReactivation::updateOrCreate(
            ['service_request_id' => $pbiReq3->id],
            [
                'participant_name' => 'Kasidi',
                'participant_nik' => '3505191104580001',
                'bpjs_card_number' => '0001789012345',
                'deactivated_date' => now()->subMonths(3)->toDateString(),
                'reason' => PbiReactivationReason::Catastrophic,
                'health_facility_name' => 'RSUD Ngudi Waluyo Wlingi',
                'health_letter_number' => '445/456/RSUD-NW/2026',
                'decile' => 1,
            ]
        );

        // 2.4 Eligibility Verification (Supardi - Bayi Baru Lahir)
        $pbi4Number = "PBI-{$currentPeriod}-00004";
        ServiceRequest::updateOrCreate(
            ['request_number' => $pbi4Number],
            [
                'service_type_id' => $pbiService->id,
                'submitter_id' => null,
                'applicant_name' => 'Supardi',
                'applicant_nik' => '3505081011830002',
                'family_card_number' => '3505080101050009',
                'address' => 'Desa Sawentar RT 02 RW 03, Kanigoro',
                'village_id' => $villageSawentar->id,
                'phone' => '085744556677',
                'submitted_at' => now()->subDay(),
                'officer_id' => $officerPbi?->id,
                'work_unit_id' => $linjamsosUnit?->id,
                'status' => ServiceRequestStatus::EligibilityVerification,
                'is_priority' => false,
                'officer_notes' => 'Pengecekan status kepesertaan ibu kandung pada SIKS-NG.',
            ]
        );

        // 2.5 Submitted (Warni - Baru Masuk)
        $pbi5Number = "PBI-{$currentPeriod}-00005";
        ServiceRequest::updateOrCreate(
            ['request_number' => $pbi5Number],
            [
                'service_type_id' => $pbiService->id,
                'submitter_id' => null,
                'applicant_name' => 'Warni',
                'applicant_nik' => '3505084903680003',
                'family_card_number' => '3505080101050010',
                'address' => 'Kelurahan Satreyan RT 03 RW 01',
                'village_id' => $villageSatreyan->id,
                'phone' => '081234998877',
                'submitted_at' => now()->subHours(4),
                'status' => ServiceRequestStatus::Submitted,
                'is_priority' => false,
            ]
        );

        // =========================================================================
        // 3. Rehabilitation Cases, Clients, Assessments & Referrals
        // =========================================================================

        $catLansia = ClientCategory::where('name', 'like', '%Lanjut Usia%')->first();
        $catOdgj = ClientCategory::where('name', 'like', '%ODGJ%')->first();
        $catDisabilitas = ClientCategory::where('name', 'like', '%Disabilitas%')->first();
        $catAnak = ClientCategory::where('name', 'like', '%Anak%')->first();

        $instPstw = ReferralInstitution::where('name', 'like', '%PSTW%')->first();
        $instRsudWlingi = ReferralInstitution::where('name', 'like', '%Ngudi Waluyo%')->first();
        $instLks = ReferralInstitution::where('name', 'like', '%Kasih Ibu%')->first();

        // 3.1 Case 1: Closed (Mbah Karto - Lansia Terlantar dirujuk ke PSTW Blitar)
        $client1 = Client::updateOrCreate(
            ['nik' => '3505080101520001'],
            [
                'name' => 'Mbah Karto',
                'client_category_id' => $catLansia->id,
                'birth_date' => '1952-01-01',
                'gender' => Gender::Male,
                'address' => 'Ditemukan di emperan pertokoan Pasar Kanigoro',
                'village_id' => $villageKanigoro->id,
                'phone' => null,
            ]
        );

        $case1Number = "RHS-{$currentPeriod}-00001";
        $case1 = RehabilitationCase::updateOrCreate(
            ['case_number' => $case1Number],
            [
                'client_id' => $client1->id,
                'officer_id' => $officerRehsos?->id,
                'handling_type' => HandlingType::Both,
                'status' => RehabilitationCaseStatus::Closed,
                'handling_result' => 'Klien telah diterima dan menempati UPT PSTW Blitar dengan kondisi fisik stabil, mendapatkan permakanan rutin, dan pendampingan psikososial yang layak.',
                'received_at' => now()->subDays(14),
                'closed_at' => now()->subDays(2),
            ]
        );

        $assessment1 = Assessment::updateOrCreate(
            ['rehabilitation_case_id' => $case1->id],
            [
                'officer_id' => $officerRehsos?->id,
                'assessment_date' => now()->subDays(12)->toDateString(),
                'result' => 'Lansia berusia 74 tahun, sebatang kara tanpa sanak keluarga di Blitar, kondisi fisik lemah namun mampu mobilisasi mandiri dengan bantuan tongkat.',
                'service_needs' => 'Pemenuhan kebutuhan dasar hidup, tempat tinggal layak, dan perawatan harian panti.',
                'recommendation' => 'Rujukan ke UPT PSTW Blitar dan pemberian pakaian serta bantuan nutrisi darurat.',
                'needs_referral' => true,
            ]
        );

        $ref1Number = "RJK-{$currentPeriod}-00001";
        $ref1 = Referral::updateOrCreate(
            ['referral_number' => $ref1Number],
            [
                'rehabilitation_case_id' => $case1->id,
                'assessment_id' => $assessment1->id,
                'referral_institution_id' => $instPstw->id,
                'officer_id' => $officerRehsos?->id,
                'referral_date' => now()->subDays(10)->toDateString(),
                'status' => ReferralStatus::Completed,
                'service_result' => 'Klien diterima dan terdaftar sebagai penerima manfaat tetap PSTW Blitar.',
                'completed_at' => now()->subDays(3),
            ]
        );

        MonitoringRecord::updateOrCreate(
            [
                'rehabilitation_case_id' => $case1->id,
                'referral_id' => $ref1->id,
                'monitoring_date' => now()->subDays(4)->toDateString(),
            ],
            [
                'officer_id' => $officerRehsos?->id,
                'progress' => 'Monitoring kunjungan panti: Mbah Karto telah beradaptasi baik dengan lingkungan panti dan sesama lansia.',
                'result_notes' => 'Kondisi kesehatan stabil, nafsu makan baik.',
            ]
        );

        // 3.2 Case 2: In Service / Referral (Slamet - ODGJ Terlantar)
        $client2 = Client::updateOrCreate(
            ['name' => 'Slamet (Mr. X)'],
            [
                'client_category_id' => $catOdgj->id,
                'nik' => null,
                'birth_date' => null,
                'gender' => Gender::Male,
                'address' => 'Area Pasar Garum',
                'village_id' => $villageGarum->id,
                'phone' => null,
            ]
        );

        $case2Number = "RHS-{$currentPeriod}-00002";
        $case2 = RehabilitationCase::updateOrCreate(
            ['case_number' => $case2Number],
            [
                'client_id' => $client2->id,
                'officer_id' => $officerRehsos?->id,
                'handling_type' => HandlingType::Referral,
                'status' => RehabilitationCaseStatus::InService,
                'received_at' => now()->subDays(6),
            ]
        );

        $assessment2 = Assessment::updateOrCreate(
            ['rehabilitation_case_id' => $case2->id],
            [
                'officer_id' => $officerRehsos?->id,
                'assessment_date' => now()->subDays(5)->toDateString(),
                'result' => 'ODGJ terlantar tanpa identitas, mengalami disorientasi waktu dan tempat, gelisah dan agresif.',
                'service_needs' => 'Penanganan stabilisasi medis psikiatri darurat dan penelusuran keluarga (biometrik Dukcapil).',
                'recommendation' => 'Evakuasi medis dan rawat inap ke RSUD Ngudi Waluyo Wlingi.',
                'needs_referral' => true,
            ]
        );

        $ref2Number = "RJK-{$currentPeriod}-00002";
        Referral::updateOrCreate(
            ['referral_number' => $ref2Number],
            [
                'rehabilitation_case_id' => $case2->id,
                'assessment_id' => $assessment2->id,
                'referral_institution_id' => $instRsudWlingi->id,
                'officer_id' => $officerRehsos?->id,
                'referral_date' => now()->subDays(4)->toDateString(),
                'status' => ReferralStatus::InService,
                'service_result' => 'Pasien sedang menjalani terapi medikasi dan observasi kejiwaan di bangsal Teratai.',
            ]
        );

        MonitoringRecord::updateOrCreate(
            [
                'rehabilitation_case_id' => $case2->id,
                'monitoring_date' => now()->subDay()->toDateString(),
            ],
            [
                'officer_id' => $officerRehsos?->id,
                'progress' => 'Koordinasi dengan tim medis RSUD: kondisi kegelisahan berkurang, mulai merespon komunikasi.',
                'result_notes' => 'Dukcapil dijadwalkan perekaman biometrik iris mata untuk identifikasi NIK.',
            ]
        );

        // 3.3 Case 3: Service Planning (Riko - Anak Berhadapan dengan Hukum / ABH)
        $client3 = Client::updateOrCreate(
            ['nik' => '3505081805120001'],
            [
                'name' => 'Riko (Inisial R)',
                'client_category_id' => $catAnak->id,
                'birth_date' => '2012-05-18',
                'gender' => Gender::Male,
                'address' => 'Desa Sawentar, Kanigoro',
                'village_id' => $villageSawentar->id,
                'phone' => '081234556677',
            ]
        );

        $case3Number = "RHS-{$currentPeriod}-00003";
        $case3 = RehabilitationCase::updateOrCreate(
            ['case_number' => $case3Number],
            [
                'client_id' => $client3->id,
                'officer_id' => $officerRehsos?->id,
                'handling_type' => HandlingType::Direct,
                'status' => RehabilitationCaseStatus::ServicePlanning,
                'received_at' => now()->subDays(3),
            ]
        );

        Assessment::updateOrCreate(
            ['rehabilitation_case_id' => $case3->id],
            [
                'officer_id' => $officerRehsos?->id,
                'assessment_date' => now()->subDays(2)->toDateString(),
                'result' => 'Anak usia 14 tahun membutuhkan pendampingan diversi sosial dan pengasuhan keluarga alternatif.',
                'service_needs' => 'Laporan Penelitian Kemasyarakatan (Litmas) Peksos dan bimbingan psikososial keluarga.',
                'recommendation' => 'Pendampingan diversi di tingkat kepolisian dan konseling keluarga berkala.',
                'needs_referral' => false,
            ]
        );

        // 3.4 Case 4: Assessment (Ibu Maryam - Disabilitas Fisik)
        $client4 = Client::updateOrCreate(
            ['nik' => '3505084807750002'],
            [
                'name' => 'Ibu Maryam',
                'client_category_id' => $catDisabilitas->id,
                'birth_date' => '1975-07-08',
                'gender' => Gender::Female,
                'address' => 'Kelurahan Satreyan RT 02 RW 02',
                'village_id' => $villageSatreyan->id,
                'phone' => '082133445566',
            ]
        );

        $case4Number = "RHS-{$currentPeriod}-00004";
        RehabilitationCase::updateOrCreate(
            ['case_number' => $case4Number],
            [
                'client_id' => $client4->id,
                'officer_id' => $officerRehsos?->id,
                'handling_type' => HandlingType::Direct,
                'status' => RehabilitationCaseStatus::Assessment,
                'received_at' => now()->subDay(),
            ]
        );

        // =========================================================================
        // 4. Complaints (Pengaduan & Laporan Sosial)
        // =========================================================================

        $compCatPpks = ComplaintCategory::where('name', 'like', '%PPKS%')->first();
        $compCatBansos = ComplaintCategory::where('name', 'like', '%Bantuan Sosial%')->first();
        $compCatOdgj = ComplaintCategory::where('name', 'like', '%ODGJ%')->first();
        $compCatLayanan = ComplaintCategory::where('name', 'like', '%Pelayanan%')->first();

        // 4.1 Resolved (Lansia Terlantar Sakit di Alun-Alun Kanigoro)
        $adu1Number = "ADU-{$currentPeriod}-00001";
        $complaint1 = Complaint::updateOrCreate(
            ['complaint_number' => $adu1Number],
            [
                'complaint_category_id' => $compCatPpks->id,
                'reporter_id' => $wargaBudi?->id,
                'reporter_name' => 'Budi Santoso',
                'reporter_phone' => '081333444555',
                'location_detail' => 'Emperan ruko barat Alun-alun Kanigoro',
                'village_id' => $villageKanigoro->id,
                'description' => 'Ada seorang kakek tua terlantar dalam kondisi batuk parah dan tidak bisa berdiri sendiri di dekat pintu barat alun-alun.',
                'reported_at' => now()->subDays(6),
                'officer_id' => $officerPengaduan?->id,
                'status' => ComplaintStatus::Resolved,
                'verification_result' => 'Laporan valid, lokasi sesuai, lansia dalam kondisi butuh perawatan darurat.',
                'action_taken' => 'Tim Reaksi Cepat (TRC) Dinsos bersama Satpol PP telah mengevakuasi lansia dan membawanya ke RSUD untuk penanganan medis darurat, kemudian didaftarkan ke kasus rehabilitasi sosial.',
                'resolved_at' => now()->subDays(4),
            ]
        );

        ComplaintAttachment::updateOrCreate(
            ['complaint_id' => $complaint1->id, 'file_path' => 'complaints/foto_lansia_alun_alun.jpg'],
            ['type' => 'photo', 'original_name' => 'foto_lansia_terlantar.jpg']
        );

        $this->recordStatusChain($complaint1, [
            ['from' => null, 'to' => ComplaintStatus::Received->value, 'notes' => 'Laporan masuk dari masyarakat', 'time' => now()->subDays(6), 'user' => $wargaBudi],
            ['from' => ComplaintStatus::Received->value, 'to' => ComplaintStatus::Verification->value, 'notes' => 'Verifikasi nomor pelapor dan lokasi kejadian', 'time' => now()->subDays(5)->subHours(10), 'user' => $officerPengaduan],
            ['from' => ComplaintStatus::Verification->value, 'to' => ComplaintStatus::Dispatched->value, 'notes' => 'Didisposisikan ke Tim Reaksi Cepat (TRC) Dinsos', 'time' => now()->subDays(5)->subHours(8), 'user' => $officerPengaduan],
            ['from' => ComplaintStatus::Dispatched->value, 'to' => ComplaintStatus::InHandling->value, 'notes' => 'Petugas TRC menuju lokasi dan melakukan evakuasi', 'time' => now()->subDays(5)->subHours(6), 'user' => $officerRehsos],
            ['from' => ComplaintStatus::InHandling->value, 'to' => ComplaintStatus::Resolved->value, 'notes' => 'Kasus tertangani, klien telah dirawat di RSUD', 'time' => now()->subDays(4), 'user' => $officerPengaduan],
        ]);

        // Disposisi Complaint 1
        Disposition::updateOrCreate(
            [
                'dispositionable_type' => Complaint::class,
                'dispositionable_id' => $complaint1->id,
            ],
            [
                'from_user_id' => $officerPengaduan?->id,
                'to_work_unit_id' => $layananUnit?->id,
                'to_user_id' => $officerRehsos?->id,
                'instructions' => 'Segera terjunkan TRC ke lokasi Alun-alun Kanigoro untuk evakuasi medis darurat.',
                'disposed_at' => now()->subDays(5)->subHours(8),
            ]
        );

        // 4.2 In Handling (Dugaan Pungli Bansos)
        $adu2Number = "ADU-{$currentPeriod}-00002";
        Complaint::updateOrCreate(
            ['complaint_number' => $adu2Number],
            [
                'complaint_category_id' => $compCatBansos->id,
                'reporter_id' => $wargaSiti?->id,
                'reporter_name' => 'Siti Aminah',
                'reporter_phone' => '081333444666',
                'location_detail' => 'Dusun Sawentar Selatan RT 02 RW 01',
                'village_id' => $villageSawentar->id,
                'description' => 'Ada oknum yang meminta potongan uang tunai Rp 50.000 dengan dalih biaya administrasi pencairan bansos sembako.',
                'reported_at' => now()->subDays(3),
                'officer_id' => $officerPengaduan?->id,
                'status' => ComplaintStatus::InHandling,
                'verification_result' => 'Informasi terkonfirmasi dari beberapa penerima manfaat di dusun setempat.',
                'action_taken' => 'Tim verifikasi Dayasos berkoordinasi dengan Camat dan Kepala Desa untuk klarifikasi lapangan.',
            ]
        );

        // 4.3 Dispatched (ODGJ Mengamuk di Pinggir Jalan Srengat)
        $adu3Number = "ADU-{$currentPeriod}-00003";
        $complaint3 = Complaint::updateOrCreate(
            ['complaint_number' => $adu3Number],
            [
                'complaint_category_id' => $compCatOdgj->id,
                'reporter_id' => $wargaJoko?->id,
                'reporter_name' => 'Joko Susilo',
                'reporter_phone' => '081333444777',
                'location_detail' => 'Depan SPBU Dandong, Jalan Raya Srengat',
                'village_id' => $villageDandong->id,
                'description' => 'Terdapat orang tidak dikenal diduga gangguan jiwa melempar batu ke arah kendaraan yang melintas.',
                'reported_at' => now()->subDays(1),
                'officer_id' => $officerPengaduan?->id,
                'status' => ComplaintStatus::Dispatched,
                'verification_result' => 'Video bukti terlampir dan sudah diverifikasi dengan perangkat desa Dandong.',
            ]
        );

        Disposition::updateOrCreate(
            [
                'dispositionable_type' => Complaint::class,
                'dispositionable_id' => $complaint3->id,
            ],
            [
                'from_user_id' => $officerPengaduan?->id,
                'to_work_unit_id' => $rehsosUnit?->id,
                'to_user_id' => $officerRehsos?->id,
                'instructions' => 'Koordinasi dengan Polsek Srengat dan Puskesmas untuk pengamanan dan penanganan medis.',
                'disposed_at' => now()->subHours(18),
            ]
        );

        // 4.4 Verification (Laporan Baru)
        $adu4Number = "ADU-{$currentPeriod}-00004";
        Complaint::updateOrCreate(
            ['complaint_number' => $adu4Number],
            [
                'complaint_category_id' => $compCatLayanan->id,
                'reporter_id' => null,
                'reporter_name' => 'Agus Hendra',
                'reporter_phone' => '081299887766',
                'location_detail' => 'Desa Bendo RT 03 RW 01',
                'village_id' => $villageBendo->id,
                'description' => 'Mohon konfirmasi mengenai syarat pendaftaran bansos anak yatim piatu di desa kami.',
                'reported_at' => now()->subHours(5),
                'status' => ComplaintStatus::Verification,
            ]
        );

        // =========================================================================
        // 5. Page Visits & Search Logs (Dashboard Analytics)
        // =========================================================================

        $pages = InformationPage::all();
        foreach ($pages as $page) {
            for ($daysAgo = 7; $daysAgo >= 0; $daysAgo--) {
                $date = now()->subDays($daysAgo)->toDateString();
                PageVisit::updateOrCreate(
                    [
                        'information_page_id' => $page->id,
                        'visit_date' => $date,
                    ],
                    [
                        'visit_count' => rand(15, 85),
                    ]
                );
            }
        }

        $keywords = [
            ['keyword' => 'surat keterangan dtsen', 'result_count' => 12, 'searched_at' => now()->subHours(2)],
            ['keyword' => 'syarat beasiswa spmb afirmasi', 'result_count' => 8, 'searched_at' => now()->subHours(4)],
            ['keyword' => 'reaktivasi kis mati', 'result_count' => 15, 'searched_at' => now()->subHours(5)],
            ['keyword' => 'desil siks ng', 'result_count' => 6, 'searched_at' => now()->subHours(7)],
            ['keyword' => 'bantuan kursi roda disabilitas', 'result_count' => 9, 'searched_at' => now()->subDay()],
            ['keyword' => 'hotline trc dinsos blitar', 'result_count' => 4, 'searched_at' => now()->subDays(2)],
            ['keyword' => 'panti jompo tresna werdha', 'result_count' => 5, 'searched_at' => now()->subDays(3)],
            ['keyword' => 'cara cek status tiket', 'result_count' => 22, 'searched_at' => now()->subDays(3)],
        ];

        foreach ($keywords as $kw) {
            SearchLog::create($kw);
        }

        // =========================================================================
        // 6. Number Sequences Synchronization
        // =========================================================================

        $sequences = [
            ['prefix' => 'DTSEN', 'period' => $currentPeriod, 'last_number' => 5],
            ['prefix' => 'PBI', 'period' => $currentPeriod, 'last_number' => 5],
            ['prefix' => 'RHS', 'period' => $currentPeriod, 'last_number' => 4],
            ['prefix' => 'RJK', 'period' => $currentPeriod, 'last_number' => 2],
            ['prefix' => 'ADU', 'period' => $currentPeriod, 'last_number' => 4],
        ];

        foreach ($sequences as $seq) {
            NumberSequence::updateOrCreate(
                ['prefix' => $seq['prefix'], 'period' => $seq['period']],
                ['last_number' => $seq['last_number']]
            );
        }
    }

    /**
     * Helper to insert a sequential chain of status histories.
     *
     * @param  array<int, array{from: ?string, to: string, notes: ?string, time: Carbon, user: ?User}>  $chain
     */
    private function recordStatusChain(object $model, array $chain): void
    {
        foreach ($chain as $item) {
            StatusHistory::create([
                'statusable_type' => get_class($model),
                'statusable_id' => $model->id,
                'from_status' => $item['from'],
                'to_status' => $item['to'],
                'notes' => $item['notes'],
                'user_id' => $item['user']?->id,
                'created_at' => $item['time'],
                'updated_at' => $item['time'],
            ]);
        }
    }
}
