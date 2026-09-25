<?php

namespace App\Models;

use App\Enums\ComplaintStatus;
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

class Complaint extends Model
{
    use HasDispositions, HasFactory, HasStatusHistories, SoftDeletes;

    protected $fillable = [
        'complaint_number',
        'complaint_category_id',
        'reporter_id',
        'reporter_name',
        'reporter_phone',
        'location_detail',
        'village_id',
        'description',
        'reported_at',
        'officer_id',
        'status',
        'verification_result',
        'action_taken',
        'duplicate_of_id',
        'resolved_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->complaint_number)) {
                $model->complaint_number = NumberSequence::getNextNumber('ADU');
            }
            if (blank($model->reported_at)) {
                $model->reported_at = now();
            }
            if (blank($model->status)) {
                $model->status = ComplaintStatus::Received;
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ComplaintStatus::class,
            'reported_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            ComplaintStatus::Resolved->value,
            ComplaintStatus::Duplicate->value,
            ComplaintStatus::Invalid->value,
        ]);
    }

    /**
     * @return BelongsTo<ComplaintCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ComplaintCategory::class, 'complaint_category_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
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
     * @return BelongsTo<Complaint, $this>
     */
    public function duplicateOf(): BelongsTo
    {
        return $this->belongsTo(Complaint::class, 'duplicate_of_id');
    }

    /**
     * @return HasMany<Complaint, $this>
     */
    public function duplicates(): HasMany
    {
        return $this->hasMany(Complaint::class, 'duplicate_of_id');
    }

    /**
     * @return HasMany<ComplaintAttachment, $this>
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(ComplaintAttachment::class);
    }

    /**
     * @return HasOne<RehabilitationCase, $this>
     */
    public function rehabilitationCase(): HasOne
    {
        return $this->hasOne(RehabilitationCase::class);
    }
}
