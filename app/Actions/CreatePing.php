<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\PingData;
use App\Models\Ping;
use Illuminate\Support\Facades\DB;
use Shopwise\Contracts\Events\Platform\PingedV1;
use Shopwise\Kit\Messaging\Outbox;

final readonly class CreatePing
{
    public function handle(PingData $data): Ping
    {
        return DB::transaction(function () use ($data): Ping {
            $ping = Ping::query()->create([
                'message' => $data->message,
                'requested_at' => now(),
            ]);

            $event = new PingedV1(
                pingId: $ping->id,
                message: $ping->message,
                requestedAt: $ping->requested_at->toIso8601ZuluString(),
            );
            Outbox::record(PingedV1::TYPE, $ping->id, $event->toArray(), PingedV1::SCHEMA);

            return $ping;
        });
    }
}
