<?php

declare(strict_types=1);

use App\Models\Ping;
use Shopwise\Kit\Messaging\OutboxMessage;

it('accepts a ping and records platform.pinged in the outbox', function (): void {
    $response = $this->postJson('/api/pings', ['message' => 'hello']);

    $response->assertAccepted()
        ->assertJsonPath('data.message', 'hello')
        ->assertJsonPath('data.consumedAt', null);

    $ping = Ping::query()->sole();
    $outbox = OutboxMessage::query()->sole();

    expect($response->json('data.id'))->toBe($ping->id)
        ->and($outbox->type)->toBe('platform.pinged')
        ->and($outbox->subject)->toBe($ping->id)
        ->and($outbox->envelope['data'])->toBe([
            'pingId' => $ping->id,
            'message' => 'hello',
            'requestedAt' => $ping->requested_at->toIso8601ZuluString(),
        ]);
});

it('rejects invalid messages without publishing anything', function (array $body): void {
    $this->postJson('/api/pings', $body)->assertUnprocessable()->assertJsonValidationErrors('message');

    expect(OutboxMessage::query()->count())->toBe(0);
})->with([
    'missing' => [[]],
    'too long' => [['message' => str_repeat('a', 201)]],
    'not a string' => [['message' => ['nested']]],
]);
