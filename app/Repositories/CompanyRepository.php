<?php


namespace App\Repositories;


use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseRepository
{


    public function listCompanies() {
        return Company::fromQuery('select * from `companies`');
    }

    public function updateCompany($data, $id)
    {
        return $this->update('companies', $data, "`id` = ?", [$id]);
    }


    public function listCompaniesWithEmployeesCount() {
        return DB::select(<<<'TAG'
select *, count_employees from companies join
    (select count(*) as count_employees, company_id from employees group by company_id) as result
    on result.company_id = companies.id
TAG
);
    }


    public function totalWorkingHoursOfCompaniesEmployeesOnFridays() {
        return DB::select(<<<'TAG'
        select *,
           (
               COALESCE((
                   select sum(timestampdiff(HOUR, started_at, ended_at)) from timesheet_details where timesheet_id in (
                       select timesheets.id from timesheets join employees on employees.company_id = companies.id
                   )
               ), 0)
           )
           as total_working_hours from companies
TAG
        );
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
