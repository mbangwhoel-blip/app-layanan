<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DownloadableForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_page_id',
        'name',
        'file_path',
        'version',
        'is_current',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
        ];
    }

    #[Scope]
    protected function current(Builder $query): Builder
    {
        return $query->where('is_current', true);
    }

    /**
     * @return BelongsTo<InformationPage, $this>
     */
    public function informationPage(): BelongsTo
    {
        return $this->belongsTo(InformationPage::class);
    }
}
