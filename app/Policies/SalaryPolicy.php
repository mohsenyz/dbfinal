<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Employee  $employee
     * @return mixed
     */
    public function viewAny(Employee $employee)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return mixed
     */
    public function view(Employee $employee, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Employee  $employee
     * @return mixed
     */
    public function create(Employee $employee)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return mixed
     */
    public function update(Employee $employee, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return mixed
     */
    public function delete(Employee $employee, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return mixed
     */
    public function restore(Employee $employee, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return mixed
     */
    public function forceDelete(Employee $employee, Salary $salary)
    {
        //
    }
}
