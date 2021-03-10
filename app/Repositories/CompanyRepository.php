<?php


namespace App\Repositories;


use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseRepository
{


    public function listCompanies() {
        return Company::fromQuery('select * from `companies`');
    }

    public function updateCompany($data, $id) {
        return $this->update('companies', $data, "`id` = ?", [$id]);
    }


    public function findCompanyById($id) {
        return Company::fromQuery('select * from `companies` where `id` = ?', [
            $id
        ])->first();
    }


    public function createCompany($data, $employeeId) {
        $this->insert('companies', $data);
        return $this->findCompanyById($this->lastId());
    }


    public function deleteCompany($id) {
        return DB::delete('delete from `companies` where `id` = ?', [$id]);
    }
}
