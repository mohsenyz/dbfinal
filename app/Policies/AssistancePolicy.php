<?php

namespace App\Policies;

use App\Models\Assistance;
use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssistancePolicy
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
     * @param  \App\Models\Assistance  $assistance
     * @return mixed
     */
    public function view(Employee $employee, Assistance $assistance)
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
     * @param  \App\Models\Assistance  $assistance
     * @return mixed
     */
    public function update(Employee $employee, Assistance $assistance)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Assistance  $assistance
     * @return mixed
     */
    public function delete(Employee $employee, Assistance $assistance)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Assistance  $assistance
     * @return mixed
     */
    public function restore(Employee $employee, Assistance $assistance)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Assistance  $assistance
     * @return mixed
     */
    public function forceDelete(Employee $employee, Assistance $assistance)
    {
        //
    }
}
