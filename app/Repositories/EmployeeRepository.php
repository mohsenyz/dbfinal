<?php


namespace App\Repositories;


use App\Models\Company;
use App\Models\Employee;

class EmployeeRepository extends BaseRepository
{

    public function findEmployeeByUsername($username) {
        return Employee::fromQuery('select * from `employees` where `username` = ?', [
            $username
        ])->first();
    }


}
