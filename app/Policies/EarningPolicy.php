<?php

namespace App\Policies;

use App\Models\Earning;
use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class EarningPolicy
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
     * @param  \App\Models\Earning  $earning
     * @return mixed
     */
    public function view(Employee $employee, Earning $earning)
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
     * @param  \App\Models\Earning  $earning
     * @return mixed
     */
    public function update(Employee $employee, Earning $earning)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Earning  $earning
     * @return mixed
     */
    public function delete(Employee $employee, Earning $earning)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Earning  $earning
     * @return mixed
     */
    public function restore(Employee $employee, Earning $earning)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Earning  $earning
     * @return mixed
     */
    public function forceDelete(Employee $employee, Earning $earning)
    {
        //
    }
}
