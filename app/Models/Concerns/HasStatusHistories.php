<?php

namespace App\Models\Concerns;

use App\Models\StatusHistory;
use App\Models\User;
use BackedEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

trait HasStatusHistories
{
    /**
     * Get all status change histories for this model.
     *
     * @return MorphMany<StatusHistory, $this>
     */
    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable')->orderByDesc('created_at');
    }

    /**
     * Record a new status transition in history.
     */
    public function recordStatusHistory(string|BackedEnum $toStatus, ?string $notes = null, ?User $user = null): StatusHistory
    {
        $toStatusValue = $toStatus instanceof BackedEnum ? $toStatus->value : $toStatus;
        $currentStatus = $this->status ?? null;
        $fromStatusValue = $currentStatus instanceof BackedEnum ? $currentStatus->value : $currentStatus;

        return $this->statusHistories()->create([
            'from_status' => $fromStatusValue,
            'to_status' => $toStatusValue,
            'notes' => $notes,
            'user_id' => $user?->id ?? Auth::id(),
            'created_at' => now(),
        ]);
    }
}
