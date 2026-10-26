<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Ping;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Ping::factory()->count(3)->create();
    }
}
