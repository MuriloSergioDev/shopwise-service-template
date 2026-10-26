<?php

declare(strict_types=1);

use App\Models\Ping;

it('shows a ping in the contract shape', function (): void {
    $ping = Ping::factory()->consumed()->create(['message' => 'hi']);

    $this->getJson("/api/pings/{$ping->id}")
        ->assertOk()
        ->assertExactJson(['data' => [
            'id' => $ping->id,
            'message' => 'hi',
            'requestedAt' => $ping->requested_at->toIso8601ZuluString(),
            'consumedAt' => $ping->consumed_at?->toIso8601ZuluString(),
        ]]);
});

it('returns 404 as JSON for unknown pings', function (): void {
    $this->get('/api/pings/01JBUNKNOWN0000000000000000')->assertNotFound()->assertJsonStructure(['message']);
});
