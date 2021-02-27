<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeCollection;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{

    protected $validationForCreating = [
        'first_name' => 'string|required',
        'last_name' => 'string|required',
        'phone_number' => 'string|phone|required',
        'username' => [
            'unique:' . Employee::class,
            'required',
            'string'
        ],
        'password' => 'string|required|min:6',
        'national_id' => 'numeric|nullable'
    ];


    protected $validationForUpdating = [
        'first_name' => 'string|nullable',
        'last_name' => 'string|nullable',
        'phone_number' => 'string|phone|nullable',
        'username' => [
            'unique:' . Employee::class,
            'nullable',
            'string'
        ],
        'password' => 'string|nullable|min:6',
        'national_id' => 'numeric|nullable'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return EmployeeCollection
     */
    public function index()
    {
        return new EmployeeCollection(
            $this->currentEmployee()->company->employees
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate($this->validationForCreating);

        $employee =  $this->currentEmployee()
            ->company
            ->employees()
            ->create($request->validated());
        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return Employee
     */
    public function show(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormRequest $request
     * @param Employee $employee
     * @return JsonResponse
     */
    public function update(FormRequest $request, Employee $employee): JsonResponse
    {
        $request->validate($this->validationForUpdating);
        $validatedData = $request->validated();
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $employee->update(Arr::except($validatedData, ['username', 'id']));

        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();
        return $this->respondSuccess();
    }
}
