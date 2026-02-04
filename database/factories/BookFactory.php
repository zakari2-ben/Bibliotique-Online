<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'designation' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['Texte', 'Image', 'Audio', 'Video']),
            'langue' => $this->faker->randomElement(['Arabe', 'Francais', 'Anglais', 'Espagnol', 'Allemand']),
            'editeur' => $this->faker->company(),
            'categorie' => $this->faker->randomElement(['Classique', 'Science Fiction', 'Fantastique', 'Horreur', 'Romance', 'Mystere']),
            'prix' => $this->faker->randomFloat(2, 0, 900),
            'auteur' => $this->faker->name(),
            'annee' => $this->faker->numberBetween(1990, 2025),
            'cover' => 'default-book.png',
        ];
    }
}
