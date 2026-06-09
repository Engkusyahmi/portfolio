<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'Home::dashboard'); // This might be a generic dashboard, ensure it's not conflicting

// ===================
// 🔐 AUTH ROUTES
// ===================
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');

$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::sendResetLink');
$routes->get('reset-password', 'Auth::resetPassword');
$routes->post('reset-password', 'Auth::updatePassword');

// ===================
// 👤 REGISTER ROUTES
// ===================
$routes->get('register/store', 'RegisterController::index');           // Show registration form
$routes->post('register/store', 'RegisterController::store');    // Handle form submission
$routes->get('register', 'RegisterController::index');

// ===================
// 📩 CHAT ROUTES (Shared API Endpoints handled by ChatController)
// These routes are used by both student and driver dashboards for chat functionality.
// The 'auth' filter ensures only logged-in users can access them.
// ===================
// === Chat Routes ===
$routes->group('chat', ['filter' => 'auth'], function($routes) {
    $routes->post('send', 'ChatController::send'); // Changed from 'chat/send'
    $routes->get('messages-by-user/(:num)', 'ChatController::getChatMessagesByUser/$1'); // Changed from 'chat/messages-by-user'
    $routes->post('mark-read/(:num)', 'ChatController::markAsRead/$1'); // Changed from 'chat/mark-read' (also note the method name in your controller is `markAsRead`, not `markRead`)
    $routes->get('new-messages', 'ChatController::getNewMessages'); // Changed from 'chat/new-messages' (also note the method name in your controller is `getNewMessages`, not `newMessages`)
    $routes->get('unread-count-api', 'ChatController::unreadCountApi'); // Changed from 'chat/unread-count-api'
});


$routes->group('chat', ['filter' => 'auth'], function($routes) {
    $routes->post('send', 'ChatController::send');
    $routes->get('messages-by-user/(:num)', 'ChatController::messagesByUser/$1');
    $routes->post('mark-read/(:num)', 'ChatController::markRead/$1');
    $routes->get('new-messages', 'ChatController::getNewMessages');
    $routes->get('unread-count-api', 'ChatController::unreadCountApi');
});

// ===================
// 🎓 STUDENT ROUTES
// ===================
$routes->group('student', ['filter' => 'StudentAuthFilter'], function ($routes) {
    $routes->get('/', 'StudentController::index');
    $routes->get('dashboard', 'StudentController::index'); // Keep one or remove if '/' is sufficient
$routes->get('driver/get_schedules', 'DriverController::getSchedules');
    // AJAX Endpoints and specific views for Student Dashboard
    // THIS IS THE PRIMARY FIX FOR DRIVERS DROPDOWN:
    $routes->get('chat/drivers', 'StudentController::getDriversForChat'); // Corrected path, matches JS fetch

    $routes->get('ratings/drivers', 'StudentController::getDriversForRating'); // Keep this, assuming getDriversForRating exists
    $routes->post('ratings/submit', 'StudentController::submitRating');
  
    $routes->get('get_schedules', 'StudentController::getSchedules');
    $routes->post('updateProfile', 'StudentController::updateProfile'); // For student's own profile update
    $routes->get('profile_details', 'StudentController::getProfileDetails');

    // Chat specific routes for views or direct actions from student
    // Ensure these match your actual implementation in ChatController/StudentController
    $routes->get('chat', 'ChatController::index'); // Student's chat list view
    $routes->get('chat/(:num)', 'ChatController::chatWith/$1'); // Student's chat conversation with a specific user
    $routes->post('student/ratings/submit', 'StudentController::submitRating');
    // Review and consider removing these if they are redundant with 'chat/drivers' or 'chat/send'
    // $routes->get('student/chat/(:num)', 'StudentController::chatWithDriver/$1'); // Redundant if 'chat/(:num)' above is used for views
    // $routes->post('student/send-message', 'StudentController::sendMessageToDriver'); // Redundant with `chat/send` (handled by ChatController)
    // $routes->get('getChatDrivers', 'StudentController::getChatDrivers'); // REDUNDANT: Replaced by 'chat/drivers' above which points to getDriversForChat
    // $routes->get('getRatingDrivers', 'StudentController::getRatingDrivers'); // REDUNDANT: Replaced by 'ratings/drivers' above which points to getDriversForRating
});

$routes->get('driver/get_schedules', 'DriverController::getSchedules');

// ===================
// 🚐 DRIVER ROUTES
// ===================
$routes->group('driver', ['filter' => 'DriverAuthFilter'], function ($routes) {
    $routes->get('/', 'DriverController::index');
    $routes->get('dashboard', 'DriverController::index'); 
    // Keep one or remove if '/' is sufficient

$routes->get('driver/get_ratings', 'DriverController::get_ratings');
    // AJAX Endpoints for Driver Dashboard
    
$routes->get('chat/getMessages/(:num)', 'ChatController::getMessagesByUser/$1');
$routes->post('chat/send', 'ChatController::sendMessage');
$routes->get('chat/getDrivers', 'ChatController::getDrivers');
$routes->get('chat/viewChat/(:num)', 'ChatController::viewChat/$1');    

    $routes->post('update-schedule-status', 'DriverController::updateScheduleStatus');
    $routes->get('chat/students', 'DriverController::getChatStudents'); // Get students for driver chat
    $routes->get('get-student-ratings', 'DriverController::getStudentRatings'); // Get ratings for driver
    $routes->get('profile_details', 'DriverController::getProfileDetails'); // Get driver profile details
    
    
    
$routes->group('chat', ['filter' => 'auth'], function($routes) {
    $routes->post('send', 'ChatController::send'); // POST: send message
    $routes->get('messages/(:num)', 'ChatController::getChatMessagesByUser/$1'); // GET: messages with a specific user
    $routes->get('new', 'ChatController::getNewMessages'); // GET: new messages (polling)
    $routes->get('mark-read/(:num)', 'ChatController::markAsRead/$1'); // GET: mark messages as read
    $routes->get('unread-count-api', 'ChatController::unreadCountApi'); // GET: unread count
});
$routes->get('driver/get_schedules', 'DriverController::getSchedules');
$routes->get('driver/chat-list', 'DriverController::chatList');
$routes->get('driver/chat/(:num)', 'DriverController::chat/$1'); // For viewing conversation
$routes->get('driver/chat-section', 'DriverController::chatSection');
$routes->get('driver/chat/(:num)', 'DriverController::viewChat/$1');
$routes->post('driver/chat/send', 'DriverController::send');
$routes->get('driver/get_schedules', 'DriverController::getSchedules');

    // Driver-specific chat views (if needed, otherwise handled by general chat routes)
    $routes->get('chat-conversations', 'DriverController::getConversations');
$routes->get('get_ratings', 'DriverController::getStudentRatings'); // Add this line
});

// ===================
// 🛠 ADMIN ROUTES
// ===================
$routes->group('admin', ['filter' => 'AdminAuthFilter'], function ($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->get('main', 'AdminController::index'); // <--- CHANGED THIS LINE: Points to index()
    $routes->get('dashboard', 'AdminController::index'); // Duplicate, can remove if '/' is dashboard
    $routes->get('edit_user', 'AdminController::editUser');

    // === User Management ===
    $routes->get('users', 'AdminController::manageUsers'); // If you have a separate view for this
    $routes->post('addUser', 'AdminController::addUser');
    $routes->post('deleteUser/(:num)', 'AdminController::deleteUser/$1');
    $routes->get('editUser/(:num)', 'AdminController::editUser/$1');
    $routes->post('update-user/(:num)', 'AdminController::updateProfile/$1');
    $routes->post('updateProfile/(:num)', 'AdminController::updateProfile/$1'); // Redundant if update-user is used
    $routes->post('admin/updateProfile/(:num)', 'AdminController::updateProfile/$1'); // Redundant if update-user is used

    // Review this: If this `student/update-profile` is for an admin managing a student's profile,
    // the path should reflect that (e.g., `admin/student/update-profile`).
    // If it's a mistake, remove it from the admin group.
    $routes->post('student/update-profile', 'StudentController::updateProfile');


    // === Bus Management ===
    
    $routes->get('editBus/(:num)', 'AdminController::editBus/$1');
    $routes->post('deleteBus/(:num)', 'AdminController::deleteBus/$1');
   

    $routes->get('buses', 'AdminController::manageBuses'); // If you have a separate view for this
    $routes->post('add-bus', 'AdminController::addBus');
    $routes->match(['get', 'post'], 'edit-bus/(:num)', 'AdminController::editBus/$1');
    $routes->get('delete-bus/(:num)', 'AdminController::deleteBus/$1');

    // === Schedule Management ===
    $routes->get('schedules', 'AdminController::manageSchedules'); // If you have a separate view for this
    $routes->post('add-schedule', 'AdminController::addSchedule');
    $routes->match(['get', 'post'], 'edit-schedule/(:num)', 'AdminController::editSchedule/$1');
    $routes->get('delete-schedule/(:num)', 'AdminController::deleteSchedule/$1');

    // === Image Handling ===
    $routes->post('upload-image/(:num)', 'AdminController::uploadImage/$1');
    $routes->get('delete-image/(:num)', 'AdminController::deleteImage/$1');

    // === Booking Management ===
    $routes->get('bookings', 'AdminController::bookings'); // If you have a separate view for this
    $routes->post('updateBookingStatus/(:num)/(:alpha)', 'AdminController::updateBookingStatus/$1/$2'); // Changed to POST
    $routes->post('addBooking', 'AdminController::addBooking');
});

// ===================
// 🌐 PUBLIC STATIC ROUTES
// ===================
$routes->get('/view/(:segment)', 'Auth::Open/$1');
$routes->view('/about', 'about');
$routes->view('/dashboard', 'dashboard');
$routes->view('/features', 'features');
$routes->view('/pricing', 'pricing');
$routes->view('/solution', 'solution');
$routes->view('/login', 'login');

// ===================
// 🖼 IMAGE ACCESS ROUTE
// ===================
$routes->get('uploads/images/(:segment)', 'AdminController::showImage/$1');


