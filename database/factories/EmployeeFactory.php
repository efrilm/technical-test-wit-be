<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nomor' => random_int(100000, 999999),
            'jabatan' => fake()->randomElement(['Auditor', 'Mobile Developer', 'Hrd']),
            'departmen' =>  fake()->randomElement(['Finance', 'Marketing', 'HR']),
            'tanggal_masuk' => fake()->date(),
            'foto' => fake()->imageUrl(),
            'status' => fake()->randomElement([StatusEnum::KONTRAK, StatusEnum::TETAP, StatusEnum::PROBATION]),
        ];
    }
}
