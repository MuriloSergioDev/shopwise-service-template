<?php

declare(strict_types=1);

namespace App\Messaging\Handlers;

use App\Models\Ping;
use Shopwise\Contracts\Events\Platform\PingedV1;
use Shopwise\Kit\Messaging\Envelope;
use Shopwise\Kit\Messaging\MessageHandler;

/**
 * Marks the ping as consumed. Runs in the kit's dedup transaction; the `whereNull`
 * keeps it safe even if the same ping arrives under a different message id.
 */
final readonly class PingedHandler implements MessageHandler
{
    public function handle(Envelope $envelope): void
    {
        $event = PingedV1::fromArray($envelope->data);

        Ping::query()
            ->whereKey($event->pingId)
            ->whereNull('consumed_at')
            ->update(['consumed_at' => now()]);
    }
}
