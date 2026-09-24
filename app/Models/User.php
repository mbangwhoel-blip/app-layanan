<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'nik', 'work_unit_id', 'district_id', 'village_id', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return BelongsTo<WorkUnit, $this>
     */
    public function workUnit(): BelongsTo
    {
        return $this->belongsTo(WorkUnit::class);
    }

    /**
     * @return BelongsTo<District, $this>
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * @return BelongsTo<Village, $this>
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * @return HasMany<ServiceRequest, $this>
     */
    public function handledServiceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'officer_id');
    }

    /**
     * @return HasMany<ServiceRequest, $this>
     */
    public function submittedServiceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'submitter_id');
    }

    /**
     * @return HasMany<Complaint, $this>
     */
    public function handledComplaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'officer_id');
    }

    /**
     * @return HasMany<Complaint, $this>
     */
    public function reportedComplaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'reporter_id');
    }

    /**
     * @return HasMany<RehabilitationCase, $this>
     */
    public function rehabilitationCases(): HasMany
    {
        return $this->hasMany(RehabilitationCase::class, 'officer_id');
    }

    /**
     * @return HasMany<Approval, $this>
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'approver_id');
    }

    /**
     * @return HasMany<Disposition, $this>
     */
    public function dispositionsReceived(): HasMany
    {
        return $this->hasMany(Disposition::class, 'to_user_id');
    }

    /**
     * @return HasMany<Disposition, $this>
     */
    public function dispositionsGiven(): HasMany
    {
        return $this->hasMany(Disposition::class, 'from_user_id');
    }

    /**
     * @return HasMany<InformationPage, $this>
     */
    public function informationPages(): HasMany
    {
        return $this->hasMany(InformationPage::class, 'manager_id');
    }
}
