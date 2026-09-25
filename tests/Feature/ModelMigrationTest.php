<?php

namespace Tests\Feature;

use App\Enums\ComplaintStatus;
use App\Enums\HandlingType;
use App\Enums\PbiReactivationReason;
use App\Enums\RehabilitationCaseStatus;
use App\Enums\ServiceRequestHandler;
use App\Enums\ServiceRequestStatus;
use App\Models\Assessment;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\NumberSequence;
use App\Models\PbiReactivation;
use App\Models\Referral;
use App\Models\ReferralInstitution;
use App\Models\RehabilitationCase;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ModelMigrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_all_models_and_relationships_can_be_persisted_and_queried(): void
    {
        // 1. Work unit, District, Village, User
        $workUnit = WorkUnit::create([
            'name' => 'Bidang Perlindungan dan Jaminan Sosial',
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('work_units', ['id' => $workUnit->id]);

        $district = District::create([
            'code' => '3505010',
            'name' => 'Kepanjenkidul',
        ]);
        $this->assertDatabaseHas('districts', ['id' => $district->id]);

        $village = Village::create([
            'district_id' => $district->id,
            'code' => '3505010001',
            'name' => 'Bendo',
        ]);
        $this->assertDatabaseHas('villages', ['id' => $village->id]);
        $this->assertEquals($district->id, $village->district->id);

        $user = User::factory()->create([
            'phone' => '081234567890',
            'nik' => '3505010101900001',
            'work_unit_id' => $workUnit->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
            'is_active' => true,
        ]);
        $this->assertEquals($workUnit->id, $user->workUnit->id);

        // 2. ServiceType & Requirement
        $serviceType = ServiceType::create([
            'code' => 'DTSEN_'.uniqid(),
            'name' => 'Surat Keterangan DTSEN',
            'handler' => ServiceRequestHandler::Dtsen,
            'is_active' => true,
        ]);
        $this->assertEquals(ServiceRequestHandler::Dtsen, $serviceType->handler);

        $requirement = ServiceRequirement::create([
            'service_type_id' => $serviceType->id,
            'name' => 'KTP Pemohon',
            'is_mandatory' => true,
            'sort_order' => 1,
        ]);
        $this->assertCount(1, $serviceType->requirements);

        // 3. NumberSequence helper
        $requestNumber = NumberSequence::getNextNumber('DTSEN');
        $this->assertStringStartsWith('DTSEN-', $requestNumber);

        // 4. ServiceRequest & Document
        $serviceRequest = ServiceRequest::create([
            'request_number' => $requestNumber,
            'service_type_id' => $serviceType->id,
            'submitter_id' => $user->id,
            'applicant_name' => 'Budi Santoso',
            'applicant_nik' => '3505010101900001',
            'family_card_number' => '3505010101900002',
            'address' => 'Jl. Merdeka No. 10',
            'village_id' => $village->id,
            'phone' => '081234567890',
            'submitted_at' => now(),
            'status' => ServiceRequestStatus::Submitted,
        ]);
        $this->assertEquals(ServiceRequestStatus::Submitted, $serviceRequest->status);

        $document = ServiceRequestDocument::create([
            'service_request_id' => $serviceRequest->id,
            'service_requirement_id' => $requirement->id,
            'file_path' => 'documents/ktp.pdf',
            'original_name' => 'ktp.pdf',
        ]);
        $this->assertCount(1, $serviceRequest->documents);

        // 5. DTSEN Certificate
        $purpose = DtsenPurpose::create([
            'code' => 'spmb_'.uniqid(),
            'name' => 'SPMB Jalur Afirmasi',
            'max_decile' => 5,
            'validity_days' => 30,
        ]);

        $certificate = DtsenCertificate::create([
            'service_request_id' => $serviceRequest->id,
            'dtsen_purpose_id' => $purpose->id,
            'subject_name' => 'Budi Santoso',
            'subject_nik' => '3505010101900001',
            'relationship_to_applicant' => 'Diri Sendiri',
            'is_registered' => true,
            'decile' => 2,
            'checked_at' => now(),
            'checker_id' => $user->id,
            'verification_code' => 'V-DTSEN-'.uniqid(),
        ]);
        $this->assertEquals($serviceRequest->id, $certificate->serviceRequest->id);

        // 6. Approval (Polymorphic)
        $approval = $certificate->approvals()->create([
            'step' => 1,
            'approver_id' => $user->id,
            'decision' => 'approved',
            'decided_at' => now(),
        ]);
        $this->assertCount(1, $certificate->approvals);

        // 7. Status History
        $serviceRequest->recordStatusHistory(ServiceRequestStatus::DocumentCheck, 'Berkas lengkap dicek petugas', $user);
        $this->assertCount(1, $serviceRequest->statusHistories);

        // 8. PBI Reactivation
        $pbiRequestNumber = NumberSequence::getNextNumber('PBI');
        $pbiRequest = ServiceRequest::create([
            'request_number' => $pbiRequestNumber,
            'service_type_id' => $serviceType->id,
            'applicant_name' => 'Siti Aminah',
            'applicant_nik' => '3505010101900003',
            'family_card_number' => '3505010101900002',
            'address' => 'Jl. Melati No. 5',
            'village_id' => $village->id,
            'phone' => '081234567891',
            'status' => ServiceRequestStatus::Submitted,
        ]);

        $pbi = PbiReactivation::create([
            'service_request_id' => $pbiRequest->id,
            'participant_name' => 'Siti Aminah',
            'participant_nik' => '3505010101900003',
            'bpjs_card_number' => '0001234567890',
            'reason' => PbiReactivationReason::Emergency,
            'decile' => 1,
        ]);
        $this->assertEquals(PbiReactivationReason::Emergency, $pbi->reason);

        // 9. Complaint & Attachment
        $complaintCat = ComplaintCategory::create(['name' => 'Bansos']);
        $complaintNumber = NumberSequence::getNextNumber('ADU');
        $complaint = Complaint::create([
            'complaint_number' => $complaintNumber,
            'complaint_category_id' => $complaintCat->id,
            'reporter_name' => 'Pelapor A',
            'reporter_phone' => '08111111111',
            'village_id' => $village->id,
            'description' => 'Ada warga kurang mampu belum terdaftar bantuan.',
            'status' => ComplaintStatus::Received,
        ]);
        $this->assertDatabaseHas('complaints', ['complaint_number' => $complaintNumber]);

        // 10. Rehabilitation Case, Client, Assessment, Referral
        $clientCat = ClientCategory::create(['name' => 'Lansia Terlantar']);
        $client = Client::create([
            'name' => 'Mbah Karto',
            'client_category_id' => $clientCat->id,
            'gender' => 'male',
            'village_id' => $village->id,
        ]);

        $caseNumber = NumberSequence::getNextNumber('RHS');
        $rehabCase = RehabilitationCase::create([
            'case_number' => $caseNumber,
            'client_id' => $client->id,
            'handling_type' => HandlingType::Both,
            'status' => RehabilitationCaseStatus::Received,
        ]);
        $this->assertEquals($client->id, $rehabCase->client->id);

        $assessment = Assessment::create([
            'rehabilitation_case_id' => $rehabCase->id,
            'officer_id' => $user->id,
            'assessment_date' => now()->toDateString(),
            'result' => 'Lansia sebatang kara butuh perawatan panti',
            'service_needs' => 'Perawatan harian dan tempat tinggal',
            'recommendation' => 'Rujuk ke Panti Werdha',
            'needs_referral' => true,
        ]);
        $this->assertTrue($assessment->needs_referral);

        $institution = ReferralInstitution::create([
            'name' => 'Panti Sosial Tresna Werdha',
            'type' => 'panti',
        ]);

        $referralNumber = NumberSequence::getNextNumber('RJK');
        $referral = Referral::create([
            'referral_number' => $referralNumber,
            'rehabilitation_case_id' => $rehabCase->id,
            'assessment_id' => $assessment->id,
            'referral_institution_id' => $institution->id,
            'officer_id' => $user->id,
            'referral_date' => now()->toDateString(),
        ]);
        $this->assertEquals($institution->id, $referral->institution->id);
    }
}
