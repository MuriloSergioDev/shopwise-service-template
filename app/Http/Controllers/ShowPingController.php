<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PingResource;
use App\Models\Ping;

final class ShowPingController
{
    public function __invoke(Ping $ping): PingResource
    {
        return PingResource::make($ping);
    }
}
