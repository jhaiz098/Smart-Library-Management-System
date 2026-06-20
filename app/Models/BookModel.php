<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class BookModel extends Model
    {
        protected $table = 'books';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'category_id',
            'title',
            'author',
            'description',
            'published_year',
            'publisher',
            'status',
            'availability',
        ];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }

?>