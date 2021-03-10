<?php


namespace App\Repositories;


use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class EmployeeAbsenceRepository extends BaseRepository
{


    public function listAbsenceByEmployeeId($id) {
        return Absence::fromQuery('select * from `absences` where `requested_by` = ?', [
            $id
        ]);
    }

    public function updateAbsence($data, $id) {
        return $this->update('absences', $data, "`id` = ?", [$id]);
    }


    public function findAbsenceById($id) {
        return Absence::fromQuery('select * from `absences` where `id` = ?', [
            $id
        ])->first();
    }


    public function createAbsence($data, $employeeId) {
        $this->insert('absences', array_merge($data, [
            'requested_by' => $employeeId
        ]));
        return $this->findAbsenceById($this->lastId());
    }


    public function deleteAbsence($id) {
        return DB::delete('delete from `absences` where `id` = ?', [$id]);
    }
}
