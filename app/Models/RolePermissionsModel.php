<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class RolePermissionsModel extends Model
    {
        protected $table = 'role_permissions';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
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
        
        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }
?>