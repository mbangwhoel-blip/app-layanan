<?php

namespace App\Models;

use App\Models\Concerns\HasApprovals;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DtsenCertificate extends Model
{
    use HasApprovals, HasFactory, SoftDeletes;

    protected $fillable = [
        'service_request_id',
        'dtsen_purpose_id',
        'purpose_description',
        'subject_name',
        'subject_nik',
        'relationship_to_applicant',
        'is_registered',
        'decile',
        'checked_at',
        'checker_id',
        'certificate_number',
        'issued_at',
        'valid_until',
        'signer_id',
        'file_path',
        'verification_code',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_registered' => 'boolean',
            'decile' => 'integer',
            'checked_at' => 'datetime',
            'issued_at' => 'datetime',
            'valid_until' => 'date',
        ];
    }

    /**
     * Check if certificate is still valid.
     */
    public function isValid(): bool
    {
        if (! $this->issued_at) {
            return false;
        }

        if ($this->valid_until && $this->valid_until->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * @return BelongsTo<ServiceRequest, $this>
     */
    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * @return BelongsTo<DtsenPurpose, $this>
     */
    public function dtsenPurpose(): BelongsTo
    {
        return $this->belongsTo(DtsenPurpose::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checker_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function signer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signer_id');
    }
}
