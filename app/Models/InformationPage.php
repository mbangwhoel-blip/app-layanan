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
     * @return HasMany<DownloadableForm, $this>
     */
    public function forms(): HasMany
    {
        return $this->downloadableForms();
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

    public function getIconAttribute(): string
    {
        $slug = $this->slug ?? '';
        if (str_contains($slug, 'dtsen')) {
            return 'fact_check';
        }
        if (str_contains($slug, 'pbi') || str_contains($slug, 'kis')) {
            return 'health_and_safety';
        }
        if (str_contains($slug, 'disabilitas')) {
            return 'accessible';
        }
        if (str_contains($slug, 'lansia')) {
            return 'elderly';
        }
        if (str_contains($slug, 'rehabilitasi') || str_contains($slug, 'rehsos')) {
            return 'healing';
        }
        if (str_contains($slug, 'pengaduan')) {
            return 'campaign';
        }

        return match ($this->category) {
            InformationCategory::Program => 'volunteer_activism',
            InformationCategory::Rehabilitation => 'healing',
            InformationCategory::Disability => 'accessible',
            InformationCategory::Elderly => 'elderly',
            InformationCategory::Complaint => 'campaign',
            default => 'menu_book',
        };
    }

    public function getIconBoxClassesAttribute(): string
    {
        $slug = $this->slug ?? '';
        if (str_contains($slug, 'dtsen')) {
            return 'bg-emerald-50 text-emerald-700 border border-emerald-200/60';
        }
        if (str_contains($slug, 'pbi') || str_contains($slug, 'kis')) {
            return 'bg-teal-50 text-teal-700 border border-teal-200/60';
        }
        if (str_contains($slug, 'disabilitas')) {
            return 'bg-sky-50 text-sky-700 border border-sky-200/60';
        }
        if (str_contains($slug, 'lansia')) {
            return 'bg-purple-50 text-purple-700 border border-purple-200/60';
        }
        if (str_contains($slug, 'rehabilitasi') || str_contains($slug, 'rehsos')) {
            return 'bg-amber-50 text-amber-700 border border-amber-200/60';
        }
        if (str_contains($slug, 'pengaduan')) {
            return 'bg-rose-50 text-rose-700 border border-rose-200/60';
        }

        return 'bg-brand-teal-light text-primary-container border border-teal-200/60';
    }

    public function getCategoryBadgeClassesAttribute(): string
    {
        $slug = $this->slug ?? '';
        if (str_contains($slug, 'dtsen')) {
            return 'bg-emerald-50 text-emerald-800 border-emerald-200';
        }
        if (str_contains($slug, 'pbi') || str_contains($slug, 'kis')) {
            return 'bg-teal-50 text-teal-800 border-teal-200';
        }
        if (str_contains($slug, 'disabilitas')) {
            return 'bg-sky-50 text-sky-800 border-sky-200';
        }
        if (str_contains($slug, 'lansia')) {
            return 'bg-purple-50 text-purple-800 border-purple-200';
        }
        if (str_contains($slug, 'rehabilitasi') || str_contains($slug, 'rehsos')) {
            return 'bg-amber-50 text-amber-800 border-amber-200';
        }
        if (str_contains($slug, 'pengaduan')) {
            return 'bg-rose-50 text-rose-800 border-rose-200';
        }

        return 'bg-teal-50 text-teal-800 border-teal-200';
    }

    public function getCategoryLabelAttribute(): string
    {
        $slug = $this->slug ?? '';
        if (str_contains($slug, 'dtsen')) {
            return 'DTSEN & Bansos';
        }
        if (str_contains($slug, 'pbi') || str_contains($slug, 'kis')) {
            return 'Jaminan Kesehatan';
        }
        if (str_contains($slug, 'disabilitas')) {
            return 'Penyandang Disabilitas';
        }
        if (str_contains($slug, 'lansia')) {
            return 'Lanjut Usia (Lansia)';
        }
        if (str_contains($slug, 'rehabilitasi') || str_contains($slug, 'rehsos')) {
            return 'Rehabilitasi Sosial';
        }
        if (str_contains($slug, 'pengaduan')) {
            return 'Pengaduan Masyarakat';
        }

        return $this->category instanceof InformationCategory ? $this->category->label() : ($this->category ?? 'Panduan Layanan');
    }
}
