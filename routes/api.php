<?php

declare(strict_types=1);

use App\Http\Controllers\CreatePingController;
use App\Http\Controllers\ShowPingController;
use Illuminate\Support\Facades\Route;

// Example endpoints proving HTTP → outbox → Kafka → consumer. Public: no JWT needed.
// Real services wrap their routes in Route::middleware('auth.jwt').
Route::post('/pings', CreatePingController::class)->name('pings.store');
Route::get('/pings/{ping}', ShowPingController::class)->name('pings.show');
