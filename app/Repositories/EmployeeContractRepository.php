<?php


namespace App\Repositories;


use App\Models\Contract;
use Illuminate\Support\Facades\DB;

class EmployeeContractRepository extends BaseRepository
{


    public function listContractsByEmployeeId($id) {
        return Contract::fromQuery('select * from `contracts` where `contracts`.`employee_id` = ? and `contracts`.`employee_id` is not null', [
            $id
        ]);
    }


    public function listActiveContractsByEmployeeId($id) {
        return Contract::fromQuery('select * from `contracts` where `employee_id` = ? and starts_at < now() and ends_at > now()', [
            $id
        ]);
    }

    public function updateContract($data, $id) {
        return $this->update('contracts', $data, "`id` = ?", [$id]);
    }

    public function findContractById($id) {
        return Contract::fromQuery('select * from `contracts` where `id` = ?', [
            $id
        ])->first();
    }


    public function createContract($data, $employeeId) {
        $this->insert('contracts', [
            'employee_id' => $employeeId
        ]);
        return $this->findContractById($this->lastId());
    }
}
