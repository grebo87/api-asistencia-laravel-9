<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Personal;

class PersonalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Personal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'identification_number' => $this->faker->unique()->numerify('########'),
            'code' => $this->faker->unique()->numerify('#####'),
            'date_of_birth' => $this->faker->date(),
            'email' => $this->faker->safeEmail,
            'charge' => $this->faker->word,
            'status' => $this->faker->word,
        ];
    }
}
