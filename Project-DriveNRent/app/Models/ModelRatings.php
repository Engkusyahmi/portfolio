<?php namespace App\Models;

use CodeIgniter\Model;

class ModelRatings extends Model
{
    protected $table = 'ratings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['driver_id', 'student_id', 'rating', 'comment'];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    public function getRatingsForDriver($driverId)
    {
        return $this->select('ratings.*, pengguna.fullname AS student_name')
                    ->join('pengguna', 'pengguna.id = ratings.student_id')
                    ->where('ratings.driver_id', $driverId)
                    ->orderBy('ratings.created_at', 'DESC')
                    ->findAll();
    }

    public function getAverageRatingForDriver($driverId)
    {
        $result = $this->selectAvg('rating', 'average_rating')
                       ->where('driver_id', $driverId)
                       ->get()->getRow();

        return $result ? (float)$result->average_rating : 0.0;
    }
}
