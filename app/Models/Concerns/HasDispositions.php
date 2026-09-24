<?php

namespace App\Models\Concerns;

use App\Models\Disposition;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasDispositions
{
    /**
     * Get all dispositions for this model.
     *
     * @return MorphMany<Disposition, $this>
     */
    public function dispositions(): MorphMany
    {
        return $this->morphMany(Disposition::class, 'dispositionable')->orderByDesc('disposed_at');
    }
}
