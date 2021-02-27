<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeductionCollection;
use App\Http\Resources\DeductionResource;
use App\Models\Deduction;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeDeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DeductionCollection
     */
    public function index(Employee $employee)
    {
        return new DeductionCollection(
            $employee->deductions()
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'type' => 'string|required',
            'amount' => 'numeric|required',
            'reported_at' => 'datetime|required',
            'description' => 'string|nullable'
        ]);

        $employee->deductions()
            ->create($request->validated());

        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return DeductionResource
     */
    public function show(Deduction $deduction)
    {
        return new DeductionResource($deduction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deduction $deduction)
    {
        $request->validate([
            'type' => 'string|nullable',
            'amount' => 'numeric|nullable',
            'reported_at' => 'datetime|nullable',
            'description' => 'string|nullable'
        ]);

        $deduction->update($request->validated());

        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deduction $deduction)
    {
        $deduction->delete();

        return $this->respondSuccess();
    }
}
