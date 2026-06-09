<?php namespace App\Models;

use CodeIgniter\Model;

class ModelSchedule extends Model
{
    protected $table = 'schedules'; // Ensure this matches your actual table name
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $allowedFields = [
        'bus_id',
        'route_name',
        'departure_time',
        'arrival_time',
        'driver_id',
        'status' // e.g., 'on_time', 'delayed', 'cancelled', 'completed'
    ];  

    // Method to get schedules with driver details
   public function getSchedulesWithDriver()
{
    return $this->db->table('schedules')
        ->select('schedules.*, buses.bus_name AS bus_id') // ✅ Fix this line
        ->join('buses', 'buses.id = schedules.bus_id')
        ->orderBy('schedules.departure_time', 'ASC')
        ->get()
        ->getResultArray();
}


    // Method to update schedule status
    public function updateStatus($scheduleId, $status)
    {
        return $this->update($scheduleId, ['status' => $status]);
    }

    // Method to get a single schedule by ID
    public function getScheduleById($id)
    {
        return $this->find($id);
    }

    // --- THIS IS THE MISSING METHOD THAT NEEDS TO BE HERE ---
    public function getNextScheduleForDriver($driverId)
    {
        return $this->where('driver_id', $driverId)
                    ->where('departure_time >', date('Y-m-d H:i:s')) // Get only future schedules
                    ->orderBy('departure_time', 'ASC') // Order by earliest first
                    ->first(); // Get only the very next one
    }
    // --- END OF MISSING METHOD ---
}
