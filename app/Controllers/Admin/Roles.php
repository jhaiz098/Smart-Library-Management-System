<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\LibrarySettingsModel;
use App\Models\RolePermissionsModel;
use App\Models\StaffLevelModel;
use App\Models\UserModel;

class Roles extends BaseController
{
    public function add_role()
    {
        $staffLevelModel = new StaffLevelModel();
        $rolePermissionsModel = new RolePermissionsModel();

        $name = trim($this->request->getPost('name'));

        if (empty($name)) {
            return redirect()->back()
                ->with('error', 'Role name is required.');
        }

        // Check duplicate
        $exists = $staffLevelModel
            ->where('name', $name)
            ->first();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Role already exists.');
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE STAFF LEVEL
        |--------------------------------------------------------------------------
        */

        $staffLevelModel->insert([
            'name' => $name
        ]);

        $staffLevelId = $staffLevelModel->getInsertID();

        /*
        |--------------------------------------------------------------------------
        | CREATE EMPTY PERMISSION ROW
        |--------------------------------------------------------------------------
        */

        $rolePermissionsModel->insert([
            'role_id' => 2, // Staff
            'staff_level_id' => $staffLevelId,

            'can_manage_users' => 0,
            'can_manage_books' => 0,
            'can_manage_borrowed_books' => 0,
            'can_manage_borrow_requests' => 0,
            'can_manage_returns' => 0,
            'can_manage_fines' => 0,
            'can_manage_settings' => 0,
            'can_manage_categories' => 0,
            'can_manage_roles_permissions' => 0
        ]);

        return redirect()->back()
            ->with('success', 'Role created successfully.');
    }

    public function edit_role()
    {
        $staff_level_model = new StaffLevelModel();

        $id = $this->request->getPost('id');
        $name = trim($this->request->getPost('name'));

        $role = $staff_level_model->find($id);

        if (!$role) {
            return redirect()->back()
                ->with('error', 'Role not found.');
        }

        if (empty($name)) {
            return redirect()->back()
                ->with('error', 'Role name is required.');
        }

        $existing = $staff_level_model
            ->where('id !=', $id)
            ->where('LOWER(name)', strtolower($name))
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Role name already exists.');
        }

        $staff_level_model->update($id, [
            'name' => $name
        ]);

        return redirect()->back()
            ->with('success', 'Role updated successfully.');
    }

    public function delete_role()
    {
        $staff_level_model = new StaffLevelModel();
        $user_model = new UserModel();

        $id = $this->request->getPost('id');

        $role = $staff_level_model->find($id);

        if (!$role) {
            return redirect()->back()
                ->with('error', 'Role not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK IF ROLE IS ASSIGNED
        |--------------------------------------------------------------------------
        */

        $hasUsers = $user_model
            ->where('staff_level_id', $id)
            ->countAllResults();

        if ($hasUsers > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete role because it is assigned to users.');
        }

        $staff_level_model->delete($id);

        return redirect()->back()
            ->with('success', 'Role deleted successfully.');
    }
}