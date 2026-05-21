<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class StaffLevelModel extends Model
    {
        protected $table = 'staff_levels';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'name',
        ];
        
        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }
?>