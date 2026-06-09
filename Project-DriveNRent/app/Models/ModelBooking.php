<?php namespace App\Models;

use CodeIgniter\Model;

class ModelBooking extends Model
{
    protected $table = 'bookings'; // Your actual bookings table name
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true; // Assuming you have 'created_at' and 'updated_at' fields
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fields that can be mass-assigned
    protected $allowedFields = [
        'user_id',
        'bus_id', // Assuming you link to a bus by ID (the whole bus is booked)
        'route_id', // Assuming you link to a route by ID (for the booked bus)
        'booking_date', // The date the bus is booked for
        'status', // 'pending', 'approved', 'rejected'
        'payment_status', // 'pending', 'paid', 'refunded'
        'notes'
    ];

    // Validation rules (optional but recommended)
    protected $validationRules = [
        'user_id'         => 'required|integer',
        'bus_id'          => 'required|integer',
        'route_id'        => 'required|integer',
        'booking_date'    => 'required|valid_date',
        'status'          => 'required|in_list[pending,approved,rejected]',
        'payment_status'  => 'required|in_list[pending,paid,refunded]',
    ];

    protected $validationMessages = [
        'status' => [
            'in_list' => 'Invalid booking status. Must be pending, approved, or rejected.',
        ],
        'payment_status' => [
            'in_list' => 'Invalid payment status. Must be pending, paid, or refunded.',
        ],
    ];

    // Method to get all bookings with associated user and bus/route names
    public function getAllBookingsWithDetails()
    {
        return $this->select('bookings.*, pengguna.fullname as user_fullname, buses.license_plate as bus_name, schedules.route_name as route_name')
                    ->join('pengguna', 'pengguna.id = bookings.user_id', 'left')
                    ->join('buses', 'buses.id = bookings.bus_id', 'left')
                    ->join('schedules', 'schedules.id = bookings.route_id', 'left') // Assuming route_id in bookings links to schedule_id
                    ->orderBy('bookings.created_at', 'DESC')
                    ->findAll();
    }

    // Method to update booking status
    public function updateBookingStatus($bookingId, $newStatus)
    {
        return $this->update($bookingId, ['status' => $newStatus]);
    }
    public function getBookingsWithDetails()
{
    return $this->select('bookings.*, pengguna.fullname, pengguna.username')
                ->join('pengguna', 'pengguna.id = bookings.user_id', 'left')
                ->orderBy('bookings.created_at', 'DESC')
                ->findAll();
}
}
