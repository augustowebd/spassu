<?php

namespace Database\Factories;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Livro>
 */
class LivroFactory extends Factory
{
    protected $model = Livro::class;

    public function definition(): array
    {
        return [
            'titulo' => substr($this->faker->sentence(3), 0, 40),
            'editora' => substr($this->faker->company, 0, 40),
            'edicao' => $this->faker->numberBetween(1, 10),
            'anoPublicacao' => $this->faker->year,
            'preco' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
