<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractCollection;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use App\Models\Employee;
use App\Repositories\EmployeeContractRepository;
use App\Repositories\EmployeeSalaryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeContractController extends Controller
{

    protected $employeeContractRepo;

    protected $employeeSalaryRepo;

    public function __construct(
        EmployeeContractRepository $ecRepo,
        EmployeeSalaryRepository $salaryRepo
    )
    {
        $this->employeeContractRepo = $ecRepo;
        $this->employeeSalaryRepo = $salaryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ContractCollection
     */
    public function currentEmployeeList()
    {
        return ContractResource::collection(
            $this->employeeContractRepo->listContractsByEmployeeId(
                $this->currentEmployee()->id
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return ContractCollection
     */
    public function index(Employee $employee)
    {
        return ContractResource::collection(
            $this->employeeContractRepo->listContractsByEmployeeId(
                $employee->id
            )
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
            'ends_at' => 'date|after:starts_at|required',
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

        $contract = $this->employeeContractRepo->createContract(
            $request->only([
                'description', 'starts_at', 'ends_at',
                'pay_check_period', 'required_working_hours',
                'allowed_absence_hours'
            ]),
            $employee->id
        );


        $this->employeeSalaryRepo->createSalary($request->only([
            'medical_allowance',
            'incentive',
            'base'
        ]), $contract->id);

        return $this->respondSuccess();
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Employee $employee, Contract $contract)
    {
        $request->validate([
            'description' => 'string|nullable',
            'starts_at' => 'date|required',
            'ends_at' => 'date|after:starts_at|required',
            'pay_check_period' => [
                'required',
                Rule::in([Contract::PERIOD_MONTHLY, Contract::PERIOD_YEARLY])
            ],
            'required_working_hours' => 'numeric|required',
            'allowed_absence_hours' => 'numeric|required',
            'medical_allowance' => 'numeric|required',
            'incentive' => 'numeric|required',
            'base' => 'numeric|required'
        ]);

        DB::transaction(function () use (&$request, &$contract) {
            $this->employeeContractRepo->updateContract($request->only([
                'description', 'starts_at', 'ends_at',
                'pay_check_period', 'required_working_hours',
                'allowed_absence_hours'
            ]), $contract->id);

            $this->employeeSalaryRepo->updateSalaryByContract(
                $request->only([
                    'medical_allowance',
                    'incentive',
                    'base'
                ]),
                $contract->id
            );
        });


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
        return $this->active($this->currentEmployee());
    }


    public function active(Employee $employee) {
        $activeContracts = $this->employeeContractRepo
            ->listActiveContractsByEmployeeId($employee->id);
        if (count($activeContracts) == 0) {
            return $this->respondNotFound([
                'msg' => 'employee has not any active contract',
            ]);
        }
        return new ContractResource(
            $activeContracts->first()
        );
    }
}
