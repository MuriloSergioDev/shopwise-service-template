<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Ping;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ping>
 */
final class PingFactory extends Factory
{
    protected $model = Ping::class;

    public function definition(): array
    {
        return [
            'message' => fake()->sentence(3),
            'requested_at' => now(),
            'consumed_at' => null,
        ];
    }

    public function consumed(): self
    {
        return $this->state(['consumed_at' => now()]);
    }
}
