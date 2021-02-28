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
     * @param \Illuminate\Http\Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'type' => 'string|required',
            'amount' => 'numeric|required',
            'reported_at' => 'date|required',
            'description' => 'string|nullable'
        ]);

        $deduction = $employee->deductions()
            ->make($validatedData);
        $deduction->reportedBy()->associate(auth()->user());
        $deduction->save();

        return $this->respondSuccessWithModel($deduction);
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @param Deduction $deduction
     * @return DeductionResource
     */
    public function show(Employee $employee, Deduction $deduction)
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
        $validatedData = $request->validate([
            'type' => 'string|nullable',
            'amount' => 'numeric|nullable',
            'reported_at' => 'date|nullable',
            'description' => 'string|nullable'
        ]);

        $deduction->update(array_filter($validatedData));

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
