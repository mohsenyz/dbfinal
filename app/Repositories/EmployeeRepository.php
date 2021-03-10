<?php


namespace App\Repositories;


use App\Models\Company;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends BaseRepository
{

    public function findEmployeeByUsername($username) {
        return Employee::fromQuery('select * from `employees` where `username` = ?', [
            $username
        ])->first();
    }


    public function employeesWithoutDeductions($companyId) {
        return Employee::fromQuery(<<<'TAG'
select * from `employees` where `company_id` = ? and id not in (select distinct(reported_to) from deductions)
TAG
, [$companyId]);
    }


    public function employeesWhoWorkedOnFridays($companyId) {
        return Employee::fromQuery(<<<'TAG'
select *,
       (select sum(timestampdiff(HOUR, started_at, ended_at)) from timesheet_details where timesheet_id in (
           select id from timesheets where dayofweek(day_date) = 7  and employee_id = employees.id
       )) as working_hours_on_friday
from employees where exists(select * from timesheets where dayofweek(day_date) = 7 and employee_id = employees.id) and company_id = ?
TAG
            , [$companyId]);
    }


    public function employeesWithTotalAbsencesHours($companyId) {
        return Employee::fromQuery(<<<'TAG'
select *,
       COALESCE
       ((
           select sum(timestampdiff(HOUR, started_at, ended_at)) as total_absences
           from absences where absences.requested_by = employees.id
        ), 0) as total_absences_hours
from employees where company_id = ?
TAG
            , [$companyId]);
    }


    public function employeesWithoutDeductionsSince($companyId, Carbon $since) {
        return Employee::fromQuery(<<<'TAG'
select * from `employees` where `company_id` = ? and id not in (
    select distinct(reported_to) from deductions where reported_at >= ?
    )
TAG
            , [$companyId, $since]);
    }

    public function employeesSortByAmountOfEarnings($companyId) {
        return DB::select(<<<'TAG'
select id, first_name, last_name, COALESCE((select sum(amount) from earnings where reported_to = employees.id), 0) as earnings from `employees` where `company_id` = ? order by earnings;
TAG
            , [$companyId]);
    }


    public function employeesSortByAmountOfEarningsSince($companyId, Carbon $since) {
        return DB::select(<<<'TAG'
select id, first_name, last_name, COALESCE((select sum(amount) from earnings where reported_to = employees.id), 0) as total_amount from `employees` where `company_id` = ?
and reported_to >= ?
TAG
            , [$companyId, $since]);
    }
}
