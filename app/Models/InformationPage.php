<?php

namespace App\Models;

use App\Enums\InformationCategory;
use App\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationPage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'service_type_id',
        'description',
        'requirements',
        'procedure',
        'service_hours',
        'location',
        'contact',
        'publish_status',
        'published_at',
        'manager_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => InformationCategory::class,
            'publish_status' => PublishStatus::class,
            'published_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('publish_status', PublishStatus::Published->value);
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
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * @return HasMany<DownloadableForm, $this>
     */
    public function downloadableForms(): HasMany
    {
        return $this->hasMany(DownloadableForm::class);
    }

    /**
     * @return HasMany<Faq, $this>
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<PageVisit, $this>
     */
    public function pageVisits(): HasMany
    {
        return $this->hasMany(PageVisit::class);
    }
}
