<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text,
            'starts_at' => $this->faker->dateTime,
            'ends_at' => $this->faker->dateTime,
            'pay_check_period' => Contract::PERIOD_MONTHLY,
            'required_working_hours' => $this->faker->numberBetween(50, 100),
            'allowed_absence_hours' => $this->faker->numberBetween(50, 100),
        ];
    }
}
