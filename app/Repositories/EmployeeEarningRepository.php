<?php


namespace App\Repositories;


use App\Models\Earning;
use Illuminate\Support\Facades\DB;

class EmployeeEarningRepository extends BaseRepository
{

    public function listEarningsByEmployeeId($id) {
        return Earning::fromQuery('select * from `earnings` where `reported_to` = ?', [
            $id
        ]);
    }

    public function updateEarning($data, $id) {
        return $this->update('earnings', $data, "`id` = ?", [$id]);
    }


    public function findEarningById($id) {
        return Earning::fromQuery('select * from `earnings` where `id` = ?', [
            $id
        ])->first();
    }


    public function createEarning($data, $employeeId) {
        $this->insert('earnings', array_merge($data, [
            'reported_to' => $employeeId
        ]));
        return $this->findEarningById($this->lastId());
    }


    public function deleteEarning($id) {
        return DB::delete('delete from `earnings` where `id` = ?', [$id]);
    }
}
