<?php

namespace App\Services;

use App\Models\Department;
use App\Models\UserDetail;

class DepartmentService
{
    public function getAllDepartments()
    {
        return Department::all();
    }

    public function createDepartment(array $data): Department
    {
        return Department::create($data);
    }

    public function updateDepartment(int $id, array $data): Department
    {
        $department = Department::findOrFail($id);
        $department->update($data);

        return $department;
    }

    public function deleteDepartment(int $id): void
    {
        $department = Department::findOrFail($id);
        $department->delete();
    }
}
