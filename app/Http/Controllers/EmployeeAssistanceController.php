<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssistanceCollection;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeAssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        return new AssistanceCollection(
            $employee->assistances()
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
            'amount' => 'numeric|required',
        ]);

        $assistance = $employee->assistances()
            ->create($request->validated());

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
    public function update(Request $request, Assistance $assistance)
    {
        $request->validate([
            'amount' => 'numeric|nullable',
            'paid_at' => 'datetime|nullable',
        ]);

        $assistance->update($request->validated());

        return $this->respondSuccess();
    }


    public function accept(Request $request, Assistance $assistance) {
        if ($assistance->accepted_at != null || $assistance->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $assistance->accept();
        $assistance->save();

        return $this->respondSuccess();
    }


    public function reject(Request $request, Assistance $assistance) {
        if ($assistance->accepted_at != null || $assistance->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $assistance->reject();
        $assistance->save();

        return $this->respondSuccess();
    }


    public function pay(Request $request, Assistance $assistance) {
        if ($assistance->paid_at != null) {
            throw ValidationException::withMessages(['model' => 'Already paid']);
        }

        if ($assistance->accepted_at == null) {
            throw ValidationException::withMessages(['model' => 'Not accepted yet']);
        }

        $assistance->pay();
        $assistance->save();

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
        $assistance->delete();

        return $this->respondSuccess();
    }
}
