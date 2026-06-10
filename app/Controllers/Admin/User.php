<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\StaffLevelModel;
use App\Models\RolePermissionsModel;

class User extends BaseController
{
    public function list()
    {
        if (!session()->get('can_manage_users') == 1) {
            return redirect()->back()
                ->with('error', 'Access denied.');
        }

        $user_model = new UserModel();
        $role_model = new RoleModel();

        $data['roles'] = $role_model->findAll();

        // GET FILTERS
        $data['search'] = $this->request->getGet('search') ?? "";
        $data['sort']   = $this->request->getGet('sort') ?? "";
        $data['role']   = $this->request->getGet('role') ?? "";
        $data['type']   = $this->request->getGet('type') ?? "all";

        $perPage = 10;

        // BASE QUERY
        $user_query = $user_model
            ->select('users.*, staff_levels.name as staff_level_name')
            ->join('staff_levels', 'staff_levels.id = users.staff_level_id', 'left');

        
        // TYPE FILTER
        if ($data['type'] == 'user') {
            $user_query->where('role_id', 3);
        }
        elseif ($data['type'] == 'staff') {
            $user_query->where('role_id', 2);
            
        }
        elseif ($data['type'] == 'admin') {
            $user_query->where('role_id', 1);
        }
        // "all" = no filter

        // SEARCH
        if (!empty($data['search'])) {
            $user_query->groupStart()
                ->like('full_name', $data['search'])
                ->orLike('library_id', $data['search'])
                ->orLike('email', $data['search'])
            ->groupEnd();
        }

        // ROLE FILTER
        if (!empty($data['role'])) {
            $user_query->where('role_id', $data['role']);
        }

        // SORT
        if ($data['sort'] == 'name_asc') {
            $user_query->orderBy('full_name', 'ASC');
        }
        elseif ($data['sort'] == 'name_desc') {
            $user_query->orderBy('full_name', 'DESC');
        }
        elseif ($data['sort'] == 'newest') {
            $user_query->orderBy('created_at', 'DESC');
        }
        elseif ($data['sort'] == 'oldest') {
            $user_query->orderBy('created_at', 'ASC');
        }

        // PAGINATION
        $data['users'] = $user_query->paginate($perPage);
        $data['pager'] = $user_query->pager;

        // ADD ROLE NAME
        foreach ($data['users'] as &$user) {

            $role_data = $role_model->find($user['role_id']);

            $user['role_name'] = $role_data['name'] ?? '';

            // fallback
            $user['staff_level_name'] = $user['staff_level_name'] ?? '-';
        }

        return view('admin/users', $data);
    }

    public function view($id)
    {
        $user_model = new UserModel();
        $role_model = new RoleModel();
        $staff_level_model = new StaffLevelModel();

        $user = $user_model->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user['role_name'] = $role_model
            ->find($user['role_id'])['name'] ?? '-';

        if (!empty($user['staff_level_id'])) {
            $user['staff_position'] = $staff_level_model
                ->find($user['staff_level_id'])['name'] ?? '-';
        } else {
            $user['staff_position'] = '-';
        }

        $data['user'] = $user;

        return view('admin/users/view', $data);
    }

    public function edit($id)
    {
        $user_model = new UserModel();
        $role_model = new RoleModel();
        $staff_level_model = new StaffLevelModel();

        $user = $user_model->find($id);

        if (!$user) {
            return redirect()
                ->to('/admin/users')
                ->with('error', 'User not found.');
        }

        $data = [
            'user' => $user,
            'roles' => $role_model->findAll(),
            'staff_levels' => $staff_level_model->findAll()
        ];

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $rules = [
            'full_name' => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'contact_number' => 'permit_empty|max_length[20]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'This email address is already being used by another user.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {

            $role_id = trim($this->request->getPost('role_id'));

            $staff_level_id = ($role_id == 3)
                ? null
                : trim($this->request->getPost('staff_level_id'));

            $updated = $userModel->update($id, [
                'full_name'      => trim($this->request->getPost('full_name')),
                'email'          => trim($this->request->getPost('email')),
                'contact_number' => trim($this->request->getPost('contact_number')),
                'role_id' => $role_id,
                'staff_level_id' => $staff_level_id,
            ]);

            if (!$updated) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to update user.');
            }

            return redirect()->to('/admin/users/edit/' . $id)
                ->with('success', 'User updated successfully.');

        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the user.');
        }
    }

    public function toggle_status($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'User not found.');
        }

        $newStatus = ($user['status'] === 'activated')
            ? 'deactivated'
            : 'activated';

        $updated = $userModel->update($id, [
            'status' => $newStatus
        ]);

        if (!$updated) {
            return redirect()->back()
                ->with('error', 'Failed to update user status.');
        }

        return redirect()->back()
            ->with(
                'success',
                $newStatus === 'activated'
                    ? 'User activated successfully.'
                    : 'User deactivated successfully.'
            );
    }

    public function delete($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'User not found.');
        }

        if ($user['role_id'] == 1) {
            return redirect()->back()
                ->with('error', 'Administrator accounts cannot be removed.');
        }

        try {

            if (!$userModel->delete($id)) {
                return redirect()->back()
                    ->with('error', 'Failed to remove user.');
            }

            return redirect()->back()
                ->with('success', 'User removed successfully.');

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function reset_password($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'User not found.');
        }

        if ($user['role_id'] == 1) {
            return redirect()->back()
                ->with('error', 'Administrator password cannot be reset.');
        }

        try {

            $tempPassword = 'TEMP-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

            // update user password + force change flag
            $updated = $userModel->update($id, [
                'password' => password_hash($tempPassword, PASSWORD_DEFAULT),
                'must_change_password' => 1
            ]);

            if (!$updated) {
                return redirect()->back()
                    ->with('error', 'Failed to reset password.');
            }

            return redirect()->back()
                ->with('success', 'Password reset successfully.')
                ->with('temp_password', $tempPassword);

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Something went wrong while resetting password.');
        }
    }

    public function add_user()
    {
        $roleModel = new RoleModel();
        $staffLevelModel = new StaffLevelModel();

        $data['roles'] = $roleModel->whereIn('name', ['user', 'staff'])->findAll();
        $data['staff_levels'] = $staffLevelModel->findAll();

        return view('admin/users/add_user', $data);
    }

    public function add()
    {
        $userModel = new UserModel();

        $rules = [
            'full_name'      => 'required|min_length[3]',
            'email'          => 'required|valid_email|is_unique[users.email]',
            'contact_number' => 'permit_empty|max_length[20]',
            'role_id'        => 'required',
        ];

        // Staff must have a staff level
        if ($this->request->getPost('role_id') == 2) {
            $rules['staff_level_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {

            // Generate Temporary Password
            $tempPassword = 'TEMP-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

            // Insert first WITHOUT library_id
            $data = [
                'full_name'            => trim($this->request->getPost('full_name')),
                'email'                => trim($this->request->getPost('email')),
                'contact_number'       => trim($this->request->getPost('contact_number')),
                'role_id'              => $this->request->getPost('role_id'),
                'staff_level_id'       => $this->request->getPost('staff_level_id') ?: null,
                'password'             => password_hash($tempPassword, PASSWORD_DEFAULT),
                'must_change_password' => 1,
                'status'               => 'activated'
            ];

            $id = $userModel->insert($data, true); // returns inserted ID

            if (!$id) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to create user.');
            }

            // Generate Library ID based on user ID
            $year = date('Y');
            $number = str_pad($id, 4, '0', STR_PAD_LEFT);

            // Example: LIB-2026-0001
            $libraryId = 'LIB-' . $year . '-' . $number;

            // Update user with generated library_id
            $userModel->update($id, [
                'library_id' => $libraryId
            ]);

            return redirect()->to('/admin/users')
                ->with('success', 'User created successfully.')
                ->with('temp_password', $tempPassword)
                ->with('created_user', $data['full_name'])
                ->with('library_id', $libraryId);

        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the user.');
        }
    }
}
