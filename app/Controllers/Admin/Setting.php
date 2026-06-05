<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\LibrarySettingsModel;
use App\Models\RolePermissionsModel;
use App\Models\StaffLevelModel;
use App\Models\UserModel;

class Setting extends BaseController
{
    public function library_settings()
    {
        $library_settings_model = new LibrarySettingsModel();

        $settings = $library_settings_model->first();

        $settings_type = "library_settings";
        return view('admin/settings/library_settings', [
            'settings_type' => $settings_type,
            'settings' => $settings
        ]);
    }

    public function library_settings_update()
    {
        $library_settings_model = new LibrarySettingsModel();

        $borrow_days = $this->request->getPost('borrow_days');
        $max_borrow_books = $this->request->getPost('max_borrow_books');
        $max_reservation_books = $this->request->getPost('max_reservation_books');
        $reservation_expiry_days = $this->request->getPost('reservation_expiry_days');
        $daily_overdue_fine = $this->request->getPost('daily_overdue_fine');
        $max_fine_amount = $this->request->getPost('max_fine_amount');

        $data = [
            'borrow_days' => $borrow_days,
            'max_borrow_books' => $max_borrow_books,
            'max_reservation_books' => $max_reservation_books,
            'reservation_expiry_days' => $reservation_expiry_days,
            'daily_overdue_fine' => $daily_overdue_fine,
            'max_fine_amount' => $max_fine_amount,
        ];

        $library_settings_model->update('1', $data);

        return redirect()->to('/admin/library_settings');
    }

    public function category_management_settings()
    {
        $category_model = new CategoryModel();

        $search = $this->request->getGet('search') ?? "";
        $sort = $this->request->getGet('sort') ?? "";

        $perPage = 10;

        $categories_query = new CategoryModel();

        // SEARCH
        if (!empty($search)) {
            $categories_query->like('name', $search);
        }

        // SORT
        if ($sort == 'name_asc') {
            $categories_query->orderBy('name', 'ASC');
        }
        elseif ($sort == 'name_desc') {
            $categories_query->orderBy('name', 'DESC');
        }
        elseif ($sort == 'newest') {
            $categories_query->orderBy('created_at', 'DESC');
        }
        elseif ($sort == 'oldest') {
            $categories_query->orderBy('created_at', 'ASC');
        }

        // PAGINATION
        $categories = $categories_query->paginate($perPage);
        $pager = $categories_query->pager;

        $categories_count = count($category_model->findAll());

        $settings_type = "category_management_settings";
        return view('admin/settings/category_management_settings', [
            'settings_type' => $settings_type,
            'categories' => $categories,
            'categories_count' => $categories_count,
            'pager' => $pager,
            'search' => $search,
            'sort' => $sort
        ]);
    }

    public function role_permissions_settings()
    {
        $role_perm_model = new RolePermissionsModel();
        $staff_level_model = new StaffLevelModel();

        $settings_type = "role_permissions_settings";

        /*
        |--------------------------------------------------------------------------
        | GET ALL ROLE PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $roles_permissions = $role_perm_model->findAll();

        foreach ($roles_permissions as $key => $perm) {

            if ($perm['role_id'] == 1) {
                $roles_permissions[$key]['label'] = 'Admin';
            } else {
                $staff = $staff_level_model->find($perm['staff_level_id']);
                $roles_permissions[$key]['label'] = $staff['name'] ?? 'Unknown';
            }
        }

        return view('admin/settings/role_permissions_settings', [
            'settings_type' => $settings_type,
            'permissions' => $roles_permissions
        ]);
    }

    public function update_permission()
    {
        $model = new RolePermissionsModel();

        $id = $this->request->getPost('id');
        $key = $this->request->getPost('key');
        $value = $this->request->getPost('value');

        $allowedKeys = [
            'role_id',
            'staff_level_id',
            'can_manage_users',
            'can_manage_books',
            'can_manage_borrowed_books',
            'can_manage_borrow_requests',
            'can_manage_returns',
            'can_manage_fines',
            'can_manage_settings',
            'can_manage_categories',
            'can_manage_roles_permissions',
        ];

        if (!in_array($key, $allowedKeys)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid permission key'
            ]);
        }

        // validate record exists
        $record = $model->find($id);

        if (!$record) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Permission row not found'
            ]);
        }

        $updated = $model->update($id, [
            $key => $value ? 1 : 0
        ]);

        if (!$updated) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'DB update failed'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function borrowing_rules_settings()
    {
        $settings_type = "borrowing_rules_settings";
        return view('admin/settings/borrowing_rules_settings', [
            'settings_type' => $settings_type
        ]);
    }

    public function add_category()
    {
        $category_model = new CategoryModel();

        $name = trim($this->request->getPost('name'));

        $data = [
            'name' => $name,
        ];

        $category_model->insert($data);

        return redirect()->back()->with('success', 'Category added successfully');
    }

    public function update_category()
    {
        $model = new CategoryModel();

        $id = trim($this->request->getPost('id'));
        $name = trim($this->request->getPost('name'));

        $model->update($id, [
            'name' => $name
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function delete_category($id)
    {
        $category_model = new CategoryModel();
        $book_model = new BookModel();

        // CHECK IF CATEGORY IS USED
        $book_exists = $book_model
            ->where('category_id', $id)
            ->first();

        if ($book_exists) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete category because books are using it.');
        }

        $category_model->delete($id);

        return redirect()
            ->back()
            ->with('success', 'Category deleted successfully');
    }
}