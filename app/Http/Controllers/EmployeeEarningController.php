<?php

namespace App\Http\Controllers;

use App\Http\Resources\EarningCollection;
use App\Http\Resources\EarningResource;
use App\Models\Earning;
use App\Models\Employee;
use App\Repositories\EmployeeEarningRepository;
use Illuminate\Http\Request;

class EmployeeEarningController extends Controller
{

    protected $employeeEarningRepository = null;

    public function __construct(EmployeeEarningRepository $employeeEarningRepository) {
        $this->employeeEarningRepository = $employeeEarningRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        return Earning::collection(
            $this->employeeEarningRepository->listEarningsByEmployeeId(
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
            'reported_at' => 'datetime|required_at',
        ]);

        $this->employeeEarningRepository->createEarning(
            array_merge(
                $validatedData,
                ['reported_by' => auth()->id()]
            ),
            $employee->id
        );

        return $this->respondSuccessWithModel($earning);
    }

    /**
     * Display the specified resource.
     *
     * @param Earning $earning
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee, Earning $earning)
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
        $validatedData = $request->validate([
            'type' => 'string|nullable',
            'amount' => 'numeric|nullable',
            'reported_at' => 'datetime|nullable',
        ]);

        $this->employeeEarningRepository->updateEarning(
            array_filter($validatedData),
            $earning->id
        );

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
        $this->employeeEarningRepository->deleteEarning(
            $earning->id
        );

        return $this->respondSuccess();
    }
}
