<?php

declare(strict_types=1);

use App\Models\Ping;
use Shopwise\Kit\Messaging\DispatchResult;
use Shopwise\Kit\Messaging\MessageDispatcher;

it('marks the ping consumed exactly once when the event is redelivered', function (): void {
    $ping = Ping::factory()->create();
    $envelope = contractExample('platform.pinged.v1', ['pingId' => $ping->id]);
    $dispatcher = app(MessageDispatcher::class);

    expect($dispatcher->dispatch($envelope, 'platform.pinged'))->toBe(DispatchResult::Handled);
    $firstConsumedAt = $ping->refresh()->consumed_at;
    $this->travel(5)->minutes();

    expect($dispatcher->dispatch($envelope, 'platform.pinged'))->toBe(DispatchResult::Duplicate)
        ->and($firstConsumedAt)->not->toBeNull()
        ->and($ping->refresh()->consumed_at?->equalTo($firstConsumedAt))->toBeTrue();
});

it('ignores events for pings it does not know', function (): void {
    $envelope = contractExample('platform.pinged.v1');

    expect(app(MessageDispatcher::class)->dispatch($envelope, 'platform.pinged'))->toBe(DispatchResult::Handled)
        ->and(Ping::query()->count())->toBe(0);
});
