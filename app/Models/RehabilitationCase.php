<?php

namespace App\Models;

use App\Enums\HandlingType;
use App\Enums\RehabilitationCaseStatus;
use App\Models\Concerns\HasDispositions;
use App\Models\Concerns\HasStatusHistories;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RehabilitationCase extends Model
{
    use HasDispositions, HasFactory, HasStatusHistories, SoftDeletes;

    protected $fillable = [
        'case_number',
        'client_id',
        'service_request_id',
        'complaint_id',
        'officer_id',
        'handling_type',
        'status',
        'handling_result',
        'received_at',
        'closed_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->case_number)) {
                $model->case_number = NumberSequence::getNextNumber('REH');
            }
            if (blank($model->received_at)) {
                $model->received_at = now();
            }
            if (blank($model->status)) {
                $model->status = RehabilitationCaseStatus::Received;
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'handling_type' => HandlingType::class,
            'status' => RehabilitationCaseStatus::class,
            'received_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', '!=', RehabilitationCaseStatus::Closed->value);
    }

    /**
     * @return BelongsTo<Client, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo<ServiceRequest, $this>
     */
    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * @return BelongsTo<Complaint, $this>
     */
    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    /**
     * @return HasMany<Assessment, $this>
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class)->orderByDesc('assessment_date');
    }

    /**
     * @return HasMany<Referral, $this>
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class)->orderByDesc('referral_date');
    }

    /**
     * @return HasMany<MonitoringRecord, $this>
     */
    public function monitoringRecords(): HasMany
    {
        return $this->hasMany(MonitoringRecord::class)->orderByDesc('monitoring_date');
    }
}
