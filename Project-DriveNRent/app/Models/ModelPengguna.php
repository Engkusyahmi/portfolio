<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengguna extends Model
{
    // === BASIC CONFIGURATION ===
    protected $table      = 'pengguna';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // === TIMESTAMPS ===
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // === SOFT DELETES (not used) ===
    protected $useSoftDeletes = false;

    // === ALLOWED FIELDS FOR INSERT/UPDATE ===
    protected $allowedFields = [
        'fullname',
        'username',
        'password',
        'userlevel',
        'contact',
        'image',
        'remember_token',
        'reset_token',
        'reset_expires_at',
        'created_at',
        'updated_at',
    ];

    // === OPTIONAL: CUSTOM VALIDATION MESSAGES (used if validation is in controller) ===
    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Sorry, that username is already taken.',
        ],
        'password' => [
            'min_length' => 'Password must be at least 8 characters.',
        ],
        'contact' => [
            'min_length' => 'Contact must be at least 9 characters (e.g., 011-1234567).',
        ],
    ];

    // === HELPER METHODS ===

    public function getDrivers()
    {
        return $this->where('userlevel', 'driver')->findAll();
    }

    public function getStudents()
    {
        return $this->where('userlevel', 'student')->findAll();
    }

    public function getStudentProfile($userId)
    {
        return $this->where('id', $userId)->where('userlevel', 'student')->first();
    }

    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
