<?php

namespace App\Models;

use App\Enums\DocumentVerificationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequestDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_request_id',
        'service_requirement_id',
        'file_path',
        'original_name',
        'verification_status',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'verification_status' => DocumentVerificationStatus::class,
        ];
    }

    /**
     * @return BelongsTo<ServiceRequest, $this>
     */
    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * @return BelongsTo<ServiceRequirement, $this>
     */
    public function serviceRequirement(): BelongsTo
    {
        return $this->belongsTo(ServiceRequirement::class);
    }
}
