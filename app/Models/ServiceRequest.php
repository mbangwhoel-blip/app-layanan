<?php

namespace App\Models;

use App\Enums\ServiceRequestStatus;
use App\Models\Concerns\HasApprovals;
use App\Models\Concerns\HasDispositions;
use App\Models\Concerns\HasStatusHistories;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequest extends Model
{
    use HasApprovals, HasDispositions, HasFactory, HasStatusHistories, SoftDeletes;

    protected $fillable = [
        'request_number',
        'service_type_id',
        'submitter_id',
        'applicant_name',
        'applicant_nik',
        'family_card_number',
        'address',
        'village_id',
        'phone',
        'submitted_at',
        'officer_id',
        'work_unit_id',
        'status',
        'is_priority',
        'verification_result',
        'officer_notes',
        'assessment_notes',
        'service_result',
        'rejection_reason',
        'completed_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->request_number)) {
                $serviceTypeCode = $model->serviceType?->code ?? 'REQ';
                $model->request_number = NumberSequence::getNextNumber($serviceTypeCode);
            }
            if (blank($model->submitted_at)) {
                $model->submitted_at = now();
            }
            if (blank($model->status)) {
                $model->status = ServiceRequestStatus::Submitted;
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ServiceRequestStatus::class,
            'is_priority' => 'boolean',
            'submitted_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function priority(Builder $query): Builder
    {
        return $query->where('is_priority', true);
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            ServiceRequestStatus::Completed->value,
            ServiceRequestStatus::Rejected->value,
            ServiceRequestStatus::MinistryRejected->value,
        ]);
    }

    /**
     * @return BelongsTo<ServiceType, $this>
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitter_id');
    }

    /**
     * @return BelongsTo<Village, $this>
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    /**
     * @return BelongsTo<WorkUnit, $this>
     */
    public function workUnit(): BelongsTo
    {
        return $this->belongsTo(WorkUnit::class);
    }

    /**
     * @return HasMany<ServiceRequestDocument, $this>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ServiceRequestDocument::class);
    }

    /**
     * @return HasOne<DtsenCertificate, $this>
     */
    public function dtsenCertificate(): HasOne
    {
        return $this->hasOne(DtsenCertificate::class);
    }

    /**
     * @return HasOne<PbiReactivation, $this>
     */
    public function pbiReactivation(): HasOne
    {
        return $this->hasOne(PbiReactivation::class);
    }

    /**
     * @return HasOne<RehabilitationCase, $this>
     */
    public function rehabilitationCase(): HasOne
    {
        return $this->hasOne(RehabilitationCase::class);
    }
}
