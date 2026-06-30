<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // already logged in
        if (session()->get('logged_in')) {

            // admin or staff
            if (in_array(session()->get('role_id'), [1, 2])) {
                return redirect()->to('/admin/dashboard');
            }

            // normal user
            return redirect()->to('/user/dashboard');
        }

        return view('login');
    }

    public function loginAuth()
    {
        $session = session();
        $model = new UserModel();

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

        // check password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Wrong password');
        }

        // set session
        $sessionData = [
            'user_id' => $user['id'],
            'library_id' => $user['library_id'],
            'name' => $user['full_name'],
            'role_id' => $user['role_id'],
            'email' => $user['email'],
            'logged_in' => true
        ];

        // include staff level if exists
        if ($user['staff_level_id']) {
            $sessionData['staff_level_id'] = $user['staff_level_id'];
        }

        $session->set($sessionData);

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
}