<?php

namespace Database\Factories;

use App\Models\HolidayPlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<HolidayPlan>
 */
class HolidayPlanFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->text(),
            'date' => now(),
            'location' => fake()->city(),
        ];
    }
}
