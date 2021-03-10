<?php

namespace App\Http\Resources;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class EmployeeWithCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arrays = parent::toArray($request);
        $company = resolve(CompanyRepository::class)
            ->findCompanyById($arrays['company_id']);
        return array_merge(Arr::except($arrays, ['company_id']), compact('company'));
    }
}
