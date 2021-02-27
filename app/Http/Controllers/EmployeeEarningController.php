<?php

namespace App\Http\Controllers;

use App\Http\Resources\EarningCollection;
use App\Http\Resources\EarningResource;
use App\Models\Earning;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeEarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        return new EarningCollection(
            $employee->earnings()
            ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'type' => 'string|required',
            'amount' => 'numeric|required',
            'reported_at' => 'datetime|required_at',
        ]);

        $employee->earnings()
            ->create($request->validated());

        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param Earning $earning
     * @return \Illuminate\Http\Response
     */
    public function show(Earning $earning)
    {
        return new EarningResource($earning);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Earning $earning)
    {
        $request->validate([
            'type' => 'string|nullable',
            'amount' => 'numeric|nullable',
            'reported_at' => 'datetime|nullable',
        ]);

        $earning->update($request->validated());

        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earning $earning)
    {
        $earning->delete();

        return $this->respondSuccess();
    }
}
