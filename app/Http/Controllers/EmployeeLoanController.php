<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoanResource;
use App\Models\Employee;
use App\Models\Loan;
use App\Repositories\InstallmentRepository;
use App\Repositories\LoanRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeLoanController extends Controller
{

    protected $loanRepository = null;
    protected $installmentRepository = null;

    public function __construct(LoanRepository $loanRepository, InstallmentRepository $installmentRepository)
    {
        $this->loanRepository = $loanRepository;
        $this->installmentRepository = $installmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        return LoanResource::collection(
            $this->loanRepository->listLoanByEmployeeId(
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
            'description' => 'string|nullable',
            'installments' => 'required|array|min:1',
            'installments.*.amount' => 'required|numeric',
            'installments.*.due_date' => 'required|date|after:now',
        ]);

        $loan = $this->loanRepository->createLoan(
            $request->only(['description']),
            $employee->id
        );

        foreach($validated['installments'] as $installment) {
            $this->installmentRepository
                ->createInstallment($installment, $loan->id);
        }

        return $this->respondSuccessWithModel($loan);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee, Loan $loan)
    {
        return new LoanResource($loan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee, Loan $loan)
    {
        $validated = $request->validate([
            'description' => 'string|nullable',
            'requested_at' => 'required|date|nullable',
            'paid_at' => 'date|nullable',
        ]);

        $this->loanRepository->updateLoan(
            $validated,
            $loan->id
        );

        return $this->respondSuccess();
    }



    public function pay(Employee $employee, Loan $loan) {
        if ($loan->paid_at != null) {
            throw ValidationException::withMessages(['model' => 'Loan is already paid']);
        }

        $this->loanRepository->updateLoan([
            'paid_at' => now()
        ], $loan->id);

        return $this->respondSuccess();
    }



    public function payInstallment(Employee $employee, Loan $loan, Installment $installment) {
        if ($installment->given_back_at != null) {
            throw ValidationException::withMessages(['model' => 'Installment is already given back']);
        }

        $this->installmentRepository->updateInstallment([
            'given_back_at' => now()
        ], $installment->id);

        return $this->respondSuccess();
    }


    public function accept(Request $request, Employee $employee, Loan $loan) {
        if ($loan->accepted_at != null || $loan->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $loan->accept();

        return $this->respondSuccess();
    }


    public function reject(Request $request, Employee $employee, Loan $loan) {
        if ($loan->accepted_at != null || $loan->rejected_at != null) {
            throw ValidationException::withMessages(['model' => 'Model is already accepted/rejected']);
        }

        $loan->reject();

        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, Loan $loan)
    {
        abort(403);
    }
}
