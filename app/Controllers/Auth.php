<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StaffLevelModel;
use App\Models\RolePermissionsModel;

class Auth extends BaseController
{
    public function login()
    {
        $session = session();

        // if logged in AND not force logout → redirect dashboard
        if ($session->get('logged_in') && !$session->get('force_logout')) {

            if (in_array($session->get('role_id'), [1, 2])) {
                return redirect()->to('/admin/dashboard');
            }

            return redirect()->to('/user/dashboard');
        }

        $session->destroy();

        return view('login');
    }

    public function loginAuth()
    {
        $session = session();
        $model = new UserModel();
        $staff_level_model = new StaffLevelModel();

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // check email OR library_id
        $user = $model
            ->where('email', $login)
            ->orWhere('library_id', $login)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // check if deactivated
        if ($user['status'] !== 'activated') {
            return redirect()->back()->with(
                'error',
                'Your account has been deactivated. Please contact the administrator.'
            );
        }

        // check password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Wrong password');
        }

        // base session data
        $sessionData = [
            'user_id'    => $user['id'],
            'library_id' => $user['library_id'],
            'name'       => $user['full_name'],
            'role_id'    => $user['role_id'],
            'email'      => $user['email'],
            'logged_in'  => true
        ];

        // staff extra data
        if ($user['role_id'] == 2) {

            $staffLevelName = null;

            if (!empty($user['staff_level_id'])) {

                $staffLevel = $staff_level_model
                    ->where('id', $user['staff_level_id'])
                    ->first();

                if ($staffLevel) {
                    $staffLevelName = $staffLevel['name'];
                }
            }

            $sessionData['staff_level_id'] = $user['staff_level_id'] ?? null;
            $sessionData['staff_level_name'] = $staffLevelName;
        }

        $rolePermissionsModel = new RolePermissionsModel();
        
        if ($user['role_id'] == 1) {

            // Admin = everything
            $sessionData += [

                'can_manage_users' => 1,
                'can_manage_books' => 1,
                'can_manage_borrowed_books' => 1,
                'can_manage_borrow_requests' => 1,
                'can_manage_reservations' => 1,
                'can_manage_fines' => 1,
                'can_manage_settings' => 1,

            ];

        }
        elseif ($user['role_id'] == 2 && !empty($user['staff_level_id'])) {

            $permissions = $rolePermissionsModel
                ->where('staff_level_id', $user['staff_level_id'])
                ->first();

            $sessionData += [

                'can_manage_users' =>
                    $permissions['can_manage_users'] ?? 0,

                'can_manage_books' =>
                    $permissions['can_manage_books'] ?? 0,

                'can_manage_borrowed_books' =>
                    $permissions['can_manage_borrowed_books'] ?? 0,

                'can_manage_borrow_requests' =>
                    $permissions['can_manage_borrow_requests'] ?? 0,

                'can_manage_returns' =>
                    $permissions['can_manage_reservations'] ?? 0,

                'can_manage_fines' =>
                    $permissions['can_manage_fines'] ?? 0,

                'can_manage_settings' =>
                    $permissions['can_manage_settings'] ?? 0,
            ];
        }

        $session->set($sessionData);

        if (!empty($user['must_change_password']) && $user['must_change_password'] == 1) {
            return redirect()->to('/auth/change_password');
        }

        // redirect based on role
        if ($user['role_id'] == 1 || $user['role_id'] == 2) {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('/user/dashboard');
        }
    }

    public function register()
    {
        if (session()->get('logged_in')) {

            if (in_array(session()->get('role_id'), [1, 2])) {
                return redirect()->to('/admin/dashboard');
            }

            return redirect()->to('/user/dashboard');
        }

        return view('register');
    }

    public function registerAuth()
    {
        $model = new \App\Models\UserModel();

        // get form data
        $full_name = $this->request->getPost('full_name');
        $email = $this->request->getPost('email');
        $contact_number = $this->request->getPost('contact_number');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        // validation
        if ($password !== $confirm_password) {
            return redirect()->back()->with('error', 'Passwords do not match');
        }

        // check duplicate email
        if ($model->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email already exists');
        }

        // hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // insert FIRST (no library_id yet)
        $data = [
            'full_name' => $full_name,
            'email' => $email,
            'contact_number' => $contact_number,
            'password' => $hashedPassword,
            'role_id' => 3,
            'status' => 1,
        ];

        $id = $model->insert($data, true); // get auto ID

        // generate library_id AFTER insert
        $year = date('Y');
        $number = str_pad($id, 4, '0', STR_PAD_LEFT);
        $library_id = 'LIB-' . $year . '-' . $number;

        // update the user with library_id
        $model->update($id, ['library_id' => $library_id]);

        return redirect()->to('/register')->with('success', 'Registration successful');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function must_change_pass()
    {
        return view('must_change_password');
    }

    public function must_update_pass()
    {
        $session = session();
        $userModel = new UserModel();

        $userId = $session->get('user_id');

        // if not logged in
        if (!$userId) {
            return redirect()->to('/login');
        }

        // get post data
        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // get user
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'User not found.');
        }

        // check current password (temporary password)
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect.');
        }

        // check match
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()
                ->with('error', 'Passwords do not match.');
        }

        try {

            // update password + remove must_change_password flag
            $updated = $userModel->update($userId, [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
                'must_change_password' => 0
            ]);

            if (!$updated) {
                return redirect()->back()
                    ->with('error', 'Failed to update password.');
            }

            $session->setFlashdata('success', 'Password updated successfully. Please login again.');

            // mark forced logout
            $session->set('force_logout', true);

            return redirect()->to('/login');

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Something went wrong while updating password.');
        }
    }
}