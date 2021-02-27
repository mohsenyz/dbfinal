<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{


    public function updateCurrent(Request $request, Company $company) {
        $request->validate([
            'name' => 'string|required',
            'address' => 'string|nullable',
            'phone_number' => 'string|nullable'
        ]);

        $company->update($request->validated());

        $this->respondSuccess();
    }

}
