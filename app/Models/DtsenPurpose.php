<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DtsenPurpose extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'max_decile',
        'validity_days',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'max_decile' => 'integer',
            'validity_days' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return HasMany<DtsenCertificate, $this>
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(DtsenCertificate::class);
    }
}
