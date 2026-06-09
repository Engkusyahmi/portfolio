<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }
    public function dashboard()
{
    $userModel = new \App\Models\ModelPengguna();
    $bookingModel = new \App\Models\ModelBooking();

    // Count users by role
    $totalDriver = $userModel->where('userlevel', 'driver')->countAllResults();
    $totalAdmin = $userModel->where('userlevel', 'admin')->countAllResults();
    $totalStudent = $userModel->where('userlevel', 'student')->countAllResults();

    // Booking stats
    $totalBookings = $bookingModel->countAllResults();
    $approvedBookings = $bookingModel->where('status', 'approved')->countAllResults();
    $pendingBookings = $bookingModel->where('status', 'pending')->countAllResults();

    // Recent activity
    $recentActivity = $bookingModel->orderBy('created_at', 'DESC')->findAll(5);

    // Monthly stats
    $monthlyData = $bookingModel->select("MONTHNAME(created_at) as month, COUNT(*) as total, 
                                          SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved")
                                ->groupBy("MONTH(created_at)")
                                ->orderBy("MIN(created_at)", "ASC")
                                ->findAll();

    $monthlyStats = [
        'labels' => [],
        'bookings' => [],
        'approved' => [],
    ];
    foreach ($monthlyData as $row) {
        $monthlyStats['labels'][] = $row['month'];
        $monthlyStats['bookings'][] = $row['total'];
        $monthlyStats['approved'][] = $row['approved'];
    }

    return view('dashboard', [
        'totalDriver' => $totalDriver,
        'totalAdmin' => $totalAdmin,
        'totalStudent' => $totalStudent,
        'totalBookings' => $totalBookings,
        'approvedBookings' => $approvedBookings,
        'pendingBookings' => $pendingBookings,
        'recentActivity' => $recentActivity,
        'monthlyStats' => $monthlyStats,
    ]);
}
}
