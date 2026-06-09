<?php namespace App\Models;

use CodeIgniter\Model;

class StudentRatingModel extends Model
{
    protected $table      = 'ratings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';

    protected $allowedFields = ['driver_id', 'student_id', 'rating', 'comment'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    protected $validationRules = [
        'driver_id'  => 'required|integer',
        'student_id' => 'required|integer',
        'rating'     => 'required|integer|greater_than[0]|less_than_equal_to[5]',
        'comment'    => 'permit_empty|max_length[500]',
    ];
}
