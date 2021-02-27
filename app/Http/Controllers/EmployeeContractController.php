<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractCollection;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ContractCollection
     */
    public function currentEmployeeList()
    {
        return new ContractCollection(
            $this->currentEmployee()
                ->contracts()
                ->paginate()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return ContractCollection
     */
    public function index(Employee $employee)
    {
        return new ContractCollection(
            $employee->contracts()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Employee $employee)
    {
        if ($employee->activeContract()->exists()) {
            return $this->respondBadRequest([
                'msg' => 'employee already has active request',
            ]);
        }

        $request->validate([
            'description' => 'string|nullable',
            'starts_at' => 'date|required',
            'ends_at' => 'date|required',
            'pay_check_period' => [
                'required',
                Rule::in([Contract::PERIOD_MONTHLY, Contract::PERIOD_YEARLY])
            ],
            'required_working_hours' => 'numeric|required',
            'allowed_absence_hours' => 'numeric|required',

            'medical_allowance' => 'numeric|nullable',
            'incentive' => 'numeric|nullable',
            'base' => 'numeric|required'
        ]);

        $contract = $employee->contracts()->create(
            $request->only([
                'description', 'starts_at', 'ends_at',
                'pay_check_period', 'required_working_hours',
                'allowed_absence_hours'
            ])
        );

        $contract->salary()->create(
            $request->only([
                'medical_allowance',
                'incentive',
                'base'
            ])
        );

        return $this->respondSuccess();
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'description' => 'string|nullable',
            'starts_at' => 'date|nullable',
            'ends_at' => 'date|nullable',
            'pay_check_period' => [
                'nullable',
                Rule::in([Contract::PERIOD_MONTHLY, Contract::PERIOD_YEARLY])
            ],
            'required_working_hours' => 'numeric|nullable',
            'allowed_absence_hours' => 'numeric|nullable',

            'medical_allowance' => 'numeric|nullable',
            'incentive' => 'numeric|nullable',
            'base' => 'numeric|nullable'
        ]);

        $contract->update(
            $request->only([
                'description', 'starts_at', 'ends_at',
                'pay_check_period', 'required_working_hours',
                'allowed_absence_hours'
            ])
        );

        $contract->salary()->update(
            $request->only([
                'medical_allowance',
                'incentive',
                'base'
            ])
        );

        return $this->respondSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Contract
     */
    public function show(Contract $contract)
    {
        return new ContractResource($contract);
    }


    public function currentEmployeeActive() {
        if (!$this->currentEmployee()->activeContract()->exists()) {
            return $this->respondNotFound([
                'msg' => 'employee has not any active contract',
            ]);
        }
        return new ContractResource(
            $this->currentEmployee()
                ->activeContract
        );
    }


    public function active(Employee $employee) {
        if (!$employee->activeContract()->exists()) {
            return $this->respondNotFound([
                'msg' => 'employee has not any active contract',
            ]);
        }
        return new ContractResource(
            $employee->activeContract
        );
    }
}
