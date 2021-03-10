<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeductionCollection;
use App\Http\Resources\DeductionResource;
use App\Models\Deduction;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Repositories\EmployeeDeductionRepository;

class EmployeeDeductionController extends Controller
{

    protected $employeeDeductionRepository = null;


    public function __construct(EmployeeDeductionRepository $employeeDeductionRepository) {
        $this->employeeDeductionRepository = $employeeDeductionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Employee $employee)
    {
        return DeductionResource::collection(
            $this->employeeDeductionRepository->listDeductionsByEmployeeId(
                $employee->id
            )
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

        $deduction = $this->employeeDeductionRepository->createDeduction(
            array_merge(
                $validatedData,
                ['reported_by' => auth()->id()]
            ),
            $employee->id
        );

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

        $this->employeeDeductionRepository->updateDeduction(
            array_filter($validatedData),
            $deduction->id
        );

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
        $this->employeeDeductionRepository->deleteDeduction(
            $deduction->id
        );
        return $this->respondSuccess();
    }

    public function sumOfAllDeductionsAmountByEmployeeId() {
        return json_encode($this->employeeDeductionRepository
            ->sumOfAllDeductionsAmountByEmployeeId($this->currentEmployee()->company_id)[0]
        );
    }
}
