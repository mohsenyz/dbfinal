<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssistanceCollection;
use App\Http\Resources\AssistanceResource;
use App\Models\Employee;
use App\Repositories\EmployeeAssistanceRepository;
use Illuminate\Http\Request;
use App\Models\Assistance;
use Illuminate\Validation\ValidationException;

class EmployeeAssistanceController extends Controller
{

    protected $employeeAssistanceRepository;

    public function __construct(EmployeeAssistanceRepository $employeeAssistanceRepository)
    {
        $this->employeeAssistanceRepository = $employeeAssistanceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        return AssistanceResource::collection(
            $this->employeeAssistanceRepository->listAssistanceByEmployeeId(
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
            'amount' => 'numeric|required',
        ]);

        $this->employeeAssistanceRepository
            ->createAssistance($validated, $employee->id);

        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Assistance $assistance)
    {
        return new AssistanceResource($assistance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee, Assistance $assistance)
    {
        $validated = $request->validate([
            'amount' => 'numeric|nullable',
            'paid_at' => 'datetime|nullable',
        ]);

        $this->employeeAssistanceRepository
            ->updateAssistance($validated, $employee->id);

        return $this->respondSuccess();
    }


    public function accept(Request $request, Employee $employee, Assistance $assistance) {
        if ($assistance->accepted_at != null || $assistance->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $assistance->accept();

        return $this->respondSuccess();
    }


    public function reject(Request $request, Employee $employee, Assistance $assistance) {
        if ($assistance->accepted_at != null || $assistance->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $assistance->reject();

        return $this->respondSuccess();
    }


    public function pay(Request $request, Employee $employee, Assistance $assistance) {
        if ($assistance->paid_at != null) {
            throw ValidationException::withMessages(['model' => 'Already paid']);
        }

        if ($assistance->accepted_at == null) {
            throw ValidationException::withMessages(['model' => 'Not accepted yet']);
        }

        $assistance->pay();

        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assistance $assistance)
    {
        $this->employeeAssistanceRepository
            ->deleteAssistance($assistance->id);

        return $this->respondSuccess();
    }
}
