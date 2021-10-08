<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'folder' => $this->faker->randomElement(['/', '/notes', '/notes/poem', '/indeed']),
            'title' => $this->faker->sentence(40),
            'note' => $this->faker->paragraph(),
            'extension' => $this->faker->randomElement(['txt', 'php', 'js']),
            'user_id' => User::factory()
        ];
    }
}
