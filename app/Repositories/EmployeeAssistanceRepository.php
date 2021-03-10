<?php


namespace App\Repositories;


use App\Models\Assistance;
use Illuminate\Support\Facades\DB;

class EmployeeAssistanceRepository extends BaseRepository
{


    public function listAssistanceByEmployeeId($id) {
        return Assistance::fromQuery('select * from `assistances` where `requested_by` = ?', [
            $id
        ]);
    }

    public function updateAssistance($data, $id) {
        return $this->update('assistances', $data, "`id` = ?", [$id]);
    }


    public function findAssistanceById($id) {
        return Assistance::fromQuery('select * from `assistances` where `id` = ?', [
            $id
        ])->first();
    }


    public function createAssistance($data, $employeeId) {
        $this->insert('assistances', array_merge($data, [
            'requested_by' => $employeeId
        ]));
        return $this->findAssistanceById($this->lastId());
    }


    public function deleteAssistance($id) {
        return DB::delete('delete from `assistances` where `id` = ?', [$id]);
    }
}
