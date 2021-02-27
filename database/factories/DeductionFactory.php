<?php

namespace Database\Factories;

use App\Models\Deduction;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeductionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deduction::class;

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
            'description' => $this->faker->realText(100),
            'reported_by' => \App\Models\Employee::factory(),
        ];
    }
}
