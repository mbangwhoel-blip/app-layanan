<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type_id',
        'name',
        'is_mandatory',
        'allowed_mimes',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_mandatory' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<ServiceType, $this>
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * @return HasMany<ServiceRequestDocument, $this>
     */
    public function requestDocuments(): HasMany
    {
        return $this->hasMany(ServiceRequestDocument::class);
    }
}
