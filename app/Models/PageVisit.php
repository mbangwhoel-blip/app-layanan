<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_page_id',
        'visit_date',
        'visit_count',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'visit_count' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<InformationPage, $this>
     */
    public function informationPage(): BelongsTo
    {
        return $this->belongsTo(InformationPage::class);
    }
}
