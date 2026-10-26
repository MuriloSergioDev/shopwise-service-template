<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $message
 * @property Carbon $requested_at
 * @property Carbon|null $consumed_at
 */
#[Fillable(['message', 'requested_at', 'consumed_at'])]
#[WithoutTimestamps]
final class Ping extends Model
{
    /** @use HasFactory<PingFactory> */
    use HasFactory;

    use HasUlids;

    protected function casts(): array
    {
        return [
            'requested_at' => 'immutable_datetime',
            'consumed_at' => 'immutable_datetime',
        ];
    }
}
