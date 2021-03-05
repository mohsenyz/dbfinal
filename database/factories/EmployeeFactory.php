<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'phone_number' => $this->faker->phoneNumber,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName,
            'company_id' => Company::factory(),
            'password' => Hash::make('test'), // password
            'national_id' => $this->faker->optional()->numberBetween(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function systemUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'company_id' => null,
            ];
        });
    }



    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => Employee::ROLE_ADMIN,
            ];
        });
    }

}

