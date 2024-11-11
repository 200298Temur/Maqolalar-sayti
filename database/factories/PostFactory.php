<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(), 
            'subtitle' => $this->faker->sentence(3),
            'content' => implode(' ', $this->faker->words(10)),
            'author_id' => $this->faker->numberBetween(1, 2),
            'publish' => '1',
            'image' => 'test.jpeg',
            'lang' => $this->faker->boolean() ? 'uz' : 'eng', // Tasodifiy "uz" yoki "eng" tanlanadi
        ];
    }
}
