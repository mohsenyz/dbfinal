<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository) {
        $this->companyRepository = $companyRepository;
    }


    public function updateCurrent(Request $request, Company $company) {
        $request->validate([
            'name' => 'string|required',
            'address' => 'string|nullable',
            'phone_number' => 'string|nullable'
        ]);

        $this->companyRepository->updateCompany(
            $request->validated(),
            $company->id
        );

        $this->respondSuccess();
    }


    public function listCompaniesWithEmployeesCount() {
        return $this->companyRepository->listCompaniesWithEmployeesCount();
    }


    public function totalWorkingHoursOfCompaniesEmployeesOnFridays() {
        return $this->companyRepository->totalWorkingHoursOfCompaniesEmployeesOnFridays();
    }

}
