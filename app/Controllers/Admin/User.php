<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class User extends BaseController
{
    public function list()
    {
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
        $user_query = new UserModel();

        // =========================
        // TYPE FILTER (NEW)
        // =========================
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

        // =========================
        // SEARCH
        // =========================
        if (!empty($data['search'])) {
            $user_query->like('full_name', $data['search']);
        }

        // =========================
        // ROLE FILTER (optional extra filter)
        // =========================
        if (!empty($data['role'])) {
            $user_query->where('role_id', $data['role']);
        }

        // =========================
        // SORT
        // =========================
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
        }

        return view('admin/users', $data);
    }
}
