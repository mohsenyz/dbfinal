<?php

namespace Database\Factories;

use App\Models\Earning;
use Illuminate\Database\Eloquent\Factories\Factory;

class EarningFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Earning::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->realText(10),
            'amount' => $this->faker->randomDigit,
            'reported_at' => $this->faker->dateTimeThisYear(),
            'reported_by' => \App\Models\Employee::factory()
        ];
    }
}
