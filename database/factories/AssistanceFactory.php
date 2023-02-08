<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Assistance;
use App\Models\Personal;

class AssistanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assistance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'start_time' => $this->faker->dateTime(),
            'time_of' => $this->faker->dateTime(),
            'personal_id' => Personal::factory(),
        ];
    }
}
