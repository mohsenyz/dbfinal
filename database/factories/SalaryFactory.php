<?php

namespace Database\Factories;

use App\Models\Salary;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Salary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'medical_allowance' => $this->faker->randomNumber(),
            'incentive' => $this->faker->randomNumber(),
            'base' => $this->faker->randomNumber(),
        ];
    }
}
