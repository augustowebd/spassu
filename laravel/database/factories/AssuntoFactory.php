<?php

namespace Database\Factories;

use App\Models\Assunto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assunto>
 */
class AssuntoFactory extends Factory
{
    protected $model = Assunto::class;

    public function definition(): array
    {
        return [
            'descricao' => substr($this->faker->word, 0, 20),
        ];
    }
}
