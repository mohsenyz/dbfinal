<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Deduction;
use App\Models\Earning;
use App\Models\Employee;
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
            ->has(Deduction::factory()->count(10), 'deductions')
            ->has(Earning::factory()->count(10), 'earnings')
            ->create([
                'username' => 'test'
            ]);


        Company::factory()->count(20)->create();
    }

}
