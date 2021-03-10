<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbsenceCollection;
use App\Http\Resources\AbsenceResource;
use App\Models\Absence;
use App\Models\Employee;
use App\Repositories\EmployeeAbsenceRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeAbsenceController extends Controller
{

    protected $employeeAbsenceRepository;

    public function __construct(EmployeeAbsenceRepository $employeeAbsenceRepository) {
        $this->employeeAbsenceRepository = $employeeAbsenceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        return new AbsenceResource(
            $this->employeeAbsenceRepository->listAbsenceByEmployeeId(
                $employee->id
            )
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
        $validated = $request->validate([
            'started_at' => 'date|required',
            'ended_at' => 'date|after:started_at|required',
            'description' => 'string|nullable',
            'type' => 'string|nullable',
        ]);

        $this->employeeAbsenceRepository->createAbsence(
            $validated,
            $employee->id
        );

        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Absence $absence)
    {
        return new AbsenceResource($absence);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee, Absence $absence)
    {
        $validated = $request->validate([
            'started_at' => 'date|required',
            'ended_at' => 'date|after:started_at|required',
            'description' => 'string|nullable',
            'type' => 'string|nullable',
        ]);

        $this->employeeAbsenceRepository
            ->updateAbsence($validated, $absence->id);

        return $this->respondSuccess();
    }


    public function accept(Request $request, Employee $employee, Absence $absence) {
        if ($absence->accepted_at != null || $absence->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $absence->accept();

        return $this->respondSuccess();
    }


    public function reject(Request $request, Employee $employee, Absence $absence) {
        if ($absence->accepted_at != null || $absence->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $absence->reject();

        return $this->respondSuccess();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, Absence $absence)
    {
        $this->employeeAbsenceRepository
            ->deleteAbsence($absence->id);

        return $this->respondSuccess();
    }
}
