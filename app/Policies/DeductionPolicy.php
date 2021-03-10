<?php

namespace App\Policies;

use App\Models\Deduction;
use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeductionPolicy
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
     * @param  \App\Models\Deduction  $deduction
     * @return mixed
     */
    public function view(Employee $employee, Deduction $deduction)
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
     * @param  \App\Models\Deduction  $deduction
     * @return mixed
     */
    public function update(Employee $employee, Deduction $deduction)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Deduction  $deduction
     * @return mixed
     */
    public function delete(Employee $employee, Deduction $deduction)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Deduction  $deduction
     * @return mixed
     */
    public function restore(Employee $employee, Deduction $deduction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Deduction  $deduction
     * @return mixed
     */
    public function forceDelete(Employee $employee, Deduction $deduction)
    {
        //
    }
}
