<?php

namespace App\Controllers;

use App\Models\ModelBooking;
use App\Models\ModelPengguna;
use App\Models\ModelBus;
use App\Models\ModelSchedule;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    protected $penggunaModel;
    protected $busModel;
    protected $scheduleModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->penggunaModel  = new ModelPengguna();
        $this->busModel       = new ModelBus();
        $this->scheduleModel  = new ModelSchedule();
        $this->bookingModel   = new ModelBooking();
    }

    public function index()
    {
        // Check admin access
        if (!session()->has("userlevel") || session()->get("userlevel") !== "admin") {
            return redirect()->to(base_url('login'))->with('error', 'Only for admin access');
        }

        // Dashboard statistics
        $totalCars        = $this->busModel->countAllResults();
        $totalBookings    = $this->bookingModel->countAllResults();
        $pendingBookings  = $this->bookingModel->where('status', 'pending')->countAllResults();
        $approvedBookings = $this->bookingModel->where('status', 'approved')->countAllResults();

        // Recent bookings
        $recentActivity = $this->bookingModel->orderBy('created_at', 'DESC')->findAll(5);

        // Prepare data for view
        $data = [
            'totalCars'        => $totalCars,
            'totalBookings'    => $totalBookings,
            'pendingBookings'  => $pendingBookings,
            'approvedBookings' => $approvedBookings,
            'recentActivity'   => $recentActivity
        ];

        return view('admin/dashboard', $data);
    }

    // ------------------------
    // Users Management
    // ------------------------
    public function manageUsers()
    {
        $usersData = $this->penggunaModel->findAll();
        return view('admin/manage_users', ['usersData' => $usersData]);
    }

    public function addUser()
    {
        // Your existing addUser code
    }

    public function editUser($id)
    {
        // Your existing editUser code
    }

    public function updateProfile($id)
    {
        // Your existing updateProfile code
    }

    public function deleteUser($id)
    {
        // Your existing deleteUser code
    }

    // ------------------------
    // Bus Management
    // ------------------------
    public function manageBuses()
    {
        $busesData = $this->busModel->findAll();
        return view('admin/manage_buses', ['busesData' => $busesData]);
    }

    public function addBus()
    {
        // Your existing addBus code
    }

    public function editBus($id)
    {
        // Your existing editBus code
    }

    public function deleteBus($id)
    {
        // Your existing deleteBus code
    }

    // ------------------------
    // Schedule Management
    // ------------------------
    public function manageSchedules()
    {
        $schedules = $this->scheduleModel->findAll();
        $buses     = $this->busModel->findAll();

        return view('admin/manage_schedules', [
            'schedules' => $schedules,
            'buses'     => $buses
        ]);
    }

    public function addSchedule()
    {
        // Your existing addSchedule code
    }

    public function editSchedule($id)
    {
        // Your existing editSchedule code
    }

    public function deleteSchedule($id)
    {
        // Your existing deleteSchedule code
    }

    // ------------------------
    // Bookings
    // ------------------------
    public function bookings()
    {
        $bookings = $this->bookingModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/bookings', ['bookings' => $bookings]);
    }

    public function updateBookingStatus($id, $status)
    {
        $booking = $this->bookingModel->find($id);
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        if (!in_array($status, ['approved', 'pending', 'rejected'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $this->bookingModel->update($id, ['status' => $status]);
        return redirect()->back()->with('success', "Booking status updated to $status.");
    }
}
