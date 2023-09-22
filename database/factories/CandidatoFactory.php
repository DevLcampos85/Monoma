<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidato>
 */
class CandidatoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::get();
        
        return [
            'name' => fake()->name(),
            'source' => fake()->username(),
            'owner' => User::find(rand(1, $user->count()))->id,
            'created_by' => User::find(rand(1, $user->count()))->id,
        ];
    }
}