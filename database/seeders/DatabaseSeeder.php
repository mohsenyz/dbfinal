<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Deduction;
use App\Models\Earning;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::factory()->create();
        Employee::factory()->systemUser()->for($company)->create();
        Employee::factory(20)->for($company)->create();
        Employee::factory(1)
            ->for($company)
            ->has(
                Contract::factory()
                    ->has(
                        Salary::factory()
                            ->count(1)
                    )
                    ->count(10)
            )
            ->has(Deduction::factory()->count(10), 'deductions')
            ->has(Earning::factory()->count(10), 'earnings')
            ->create([
                'username' => 'test'
            ]);

        Employee::factory(1)
            ->admin()
            ->for($company)
            ->has(
                Contract::factory()
                    ->has(
                        Salary::factory()
                            ->count(1)
                    )
                    ->count(20)
            )
            ->has(Deduction::factory()->count(10), 'deductions')
            ->has(Earning::factory()->count(10), 'earnings')
            ->create([
                'username' => 'admin-test'
            ]);


        Company::factory()->count(20)->create();
    }

}
