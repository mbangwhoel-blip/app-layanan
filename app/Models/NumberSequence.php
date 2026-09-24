<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NumberSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'period',
        'last_number',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_number' => 'integer',
        ];
    }

    /**
     * Generate the next unique number sequence using pessimistic row locking.
     *
     * Example output: DTSEN-202609-00001 or ADU-202609-00005
     */
    public static function getNextNumber(string $prefix, ?string $period = null, int $digits = 5): string
    {
        $period ??= now()->format('Ym');

        return DB::transaction(function () use ($prefix, $period, $digits) {
            $sequence = static::where('prefix', $prefix)
                ->where('period', $period)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                $sequence = static::create([
                    'prefix' => $prefix,
                    'period' => $period,
                    'last_number' => 0,
                ]);
            }

            $sequence->increment('last_number');

            return sprintf('%s-%s-%0'.$digits.'d', $prefix, $period, $sequence->last_number);
        });
    }
}
