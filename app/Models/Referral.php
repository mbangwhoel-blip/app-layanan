<?php

namespace App\Models;

use App\Enums\ReferralStatus;
use App\Models\Concerns\HasStatusHistories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use HasFactory, HasStatusHistories, SoftDeletes;

    protected $fillable = [
        'referral_number',
        'rehabilitation_case_id',
        'assessment_id',
        'referral_institution_id',
        'officer_id',
        'referral_date',
        'status',
        'service_result',
        'completed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'referral_date' => 'date',
            'status' => ReferralStatus::class,
            'completed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<RehabilitationCase, $this>
     */
    public function rehabilitationCase(): BelongsTo
    {
        return $this->belongsTo(RehabilitationCase::class);
    }

    /**
     * @return BelongsTo<Assessment, $this>
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * @return BelongsTo<ReferralInstitution, $this>
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(ReferralInstitution::class, 'referral_institution_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    /**
     * @return HasMany<MonitoringRecord, $this>
     */
    public function monitoringRecords(): HasMany
    {
        return $this->hasMany(MonitoringRecord::class);
    }
}
