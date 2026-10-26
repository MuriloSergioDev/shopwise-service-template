<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreatePing;
use App\Http\Requests\CreatePingRequest;
use App\Http\Resources\PingResource;
use Illuminate\Http\JsonResponse;

final class CreatePingController
{
    public function __invoke(CreatePingRequest $request, CreatePing $createPing): JsonResponse
    {
        $ping = $createPing->handle($request->toData());

        return PingResource::make($ping)->response()->setStatusCode(202);
    }
}
