<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Ping;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Shape defined in shopwise-contracts/openapi/ping.yaml (components.schemas.Ping).
 *
 * @mixin Ping
 */
final class PingResource extends JsonResource
{
    /**
     * @return array{id: string, message: string, requestedAt: string, consumedAt: string|null}
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'requestedAt' => $this->requested_at->toIso8601ZuluString(),
            'consumedAt' => $this->consumed_at?->toIso8601ZuluString(),
        ];
    }
}
