<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class UserModel extends Model
    {
        protected $table = 'users';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'library_id',
            'staff_level_id',
            'full_name',
            'email',
            'contact_number',
            'password',
            'role_id',
            'status',
            'must_change_password'
        ];
        
        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }
?>