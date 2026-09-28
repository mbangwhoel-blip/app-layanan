<?php

namespace App\Models;

use App\Enums\ServiceRequestHandler;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'category',
        'description',
        'handler',
        'needs_assessment',
        'sla_days',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'handler' => ServiceRequestHandler::class,
            'needs_assessment' => 'boolean',
            'sla_days' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return HasMany<ServiceRequirement, $this>
     */
    public function requirements(): HasMany
    {
        return $this->hasMany(ServiceRequirement::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<ServiceRequirement, $this>
     */
    public function serviceRequirements(): HasMany
    {
        return $this->requirements();
    }

    /**
     * @return HasMany<ServiceRequest, $this>
     */
    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    /**
     * @return HasMany<InformationPage, $this>
     */
    public function informationPages(): HasMany
    {
        return $this->hasMany(InformationPage::class);
    }

    public function getIconAttribute(): string
    {
        return match ($this->code) {
            'DTSEN' => 'assignment',
            'PBI' => 'health_and_safety',
            'REHSOS_REQ' => 'healing',
            'BANSOS_REC' => 'volunteer_activism',
            default => 'apps',
        };
    }

    public function getIconBoxClassesAttribute(): string
    {
        return match ($this->code) {
            'DTSEN' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60',
            'PBI' => 'bg-teal-50 text-teal-700 border border-teal-200/60',
            'REHSOS_REQ' => 'bg-amber-50 text-amber-700 border border-amber-200/60',
            'BANSOS_REC' => 'bg-teal-50 text-primary-container border border-teal-200/60',
            default => 'bg-brand-teal-light text-primary-container border border-teal-200/60',
        };
    }

    public function getCategoryBadgeClassesAttribute(): string
    {
        return match ($this->code) {
            'DTSEN' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'PBI' => 'bg-teal-50 text-teal-800 border-teal-200',
            'REHSOS_REQ' => 'bg-amber-50 text-amber-800 border-amber-200',
            'BANSOS_REC' => 'bg-teal-50 text-teal-800 border-teal-200',
            default => 'bg-teal-50 text-teal-800 border-teal-200',
        };
    }
}
