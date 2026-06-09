<?php
// Retrieve session data
$username = session()->get('username') ?? 'Student';
$studentId = session()->get('user_id') ?? null;

// Placeholder data - these should ideally be passed from StudentController
$nextDepartureTime = $nextDepartureTime ?? 'N/A';
$nextDepartureRoute = $nextDepartureRoute ?? 'N/A';
$unreadMessagesCount = $unreadMessagesCount ?? 0;
$studentData = $studentData ?? []; // For profile section
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTracker Student Portal</title>
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <!-- IonIcons CDN for icons -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* General Layout */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5; /* Light gray */
            color: #2c3e50; /* Darker text for better readability */
        }
        .header-nav {
            background-color: #2196F3; /* Primary Blue */
            color: white;
            padding: 1rem 0;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25); /* More pronounced shadow */
        }
        .header-nav .brand-text {
            color: #81D4FA; /* Light Blue accent */
        }
        .header-nav a {
            transition: color 0.3s ease;
        }
        .header-nav a:hover {
            color: #BBDEFB; /* Lighter blue on hover */
        }

        .sidebar {
            background-color: #1976D2; /* Darker Blue for sidebar */
            color: white;
            min-height: calc(100vh - 64px); /* Full height minus header */
            padding-top: 2.5rem; /* Increased padding */
            box-shadow: 6px 0 16px rgba(0, 0, 0, 0.35); /* Deeper, more noticeable shadow */
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 1.2rem 1.8rem; /* More generous padding */
            margin-bottom: 0.85rem; /* Increased margin */
            border-radius: 0.85rem; /* More rounded */
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            color: #e3f2fd; /* Very Light Blue text */
            font-weight: 500;
            font-size: 1.05rem; /* Slightly larger font */
        }
        .sidebar-link:hover {
            background-color: #2196F3; /* Primary Blue on hover */
            transform: translateX(12px); /* More pronounced slide effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar-link.active {
            background-color: #42A5F5; /* Blue 400 active background */
            color: white;
            font-weight: 700;
            box-shadow: 0 6px 15px rgba(66, 165, 245, 0.7); /* Stronger blue shadow for active */
            transform: translateX(8px);
        }
        .sidebar-link .icon {
            font-size: 1.8rem; /* Larger icons */
            margin-right: 1.4rem; /* More space for icons */
        }

        .main-content-area {
            flex-grow: 1;
            padding: 3.5rem; /* Even more increased padding for spacious feel */
            background-color: #f0f2f5; /* Matches body background */
        }
        .content-section {
            background-color: #ffffff;
            border-radius: 1.5rem; /* Very rounded corners */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.18); /* Stronger, softer shadow */
            padding: 3.5rem; /* More generous padding */
            margin-bottom: 3.5rem; /* Space between sections */
            border: 1px solid #e2e8f0; /* Subtle light border */
        }

        /* Card Styling (for dashboard stats) */
        .dashboard-card {
            background-color: #ffffff;
            border-radius: 1.5rem; /* Rounded corners */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12); /* Subtle shadow */
            padding: 3rem; /* Increased padding */
            text-align: center;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            border: 1px solid #e2e8f0; /* Light border */
            position: relative; /* For icon positioning */
            overflow: hidden; /* For background gradient */
            display: flex; /* Use flex to center content */
            flex-direction: column; /* Stack content vertically */
            justify-content: center; /* Center vertically */
            align-items: center; /* Center horizontally */
        }
        .dashboard-card:hover {
            transform: translateY(-12px); /* More pronounced lift effect on hover */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25); /* More pronounced shadow on hover */
        }
        .dashboard-card .card-background-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 8rem; /* Even larger background icon */
            color: rgba(255, 255, 255, 0.1); /* More subtle white tint for gradients */
            z-index: 1;
            pointer-events: none; /* Ensure it doesn't interfere with clicks */
        }
        .dashboard-card .card-content {
            position: relative;
            z-index: 2; /* Ensure content is above background icon */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%; /* Take full width for centering */
        }
        .dashboard-card .card-main-icon {
            font-size: 3.5rem; /* Prominent icon size */
            margin-bottom: 1rem; /* Space below icon */
            color: white; /* Always white for gradient cards */
            text-shadow: 0 2px 4px rgba(0,0,0,0.2); /* Subtle shadow for icon */
        }
        .dashboard-card .stat-value {
            font-size: 5rem; /* Even larger numbers */
            font-weight: 900; /* Extra bold value */
            margin-top: 0; /* Remove top margin, controlled by label margin-bottom */
            margin-bottom: 0;
            line-height: 1; /* Tighter line height */
            position: relative;
            z-index: 2; /* Ensure text is above background elements */
        }
        .dashboard-card .stat-label {
            font-size: 1.3rem; /* Slightly larger label */
            color: white; /* Always white for gradient cards */
            font-weight: 700; /* Bolder label */
            text-transform: uppercase;
            letter-spacing: 0.05em;
            position: relative;
            z-index: 2;
            line-height: 1.2;
            margin-bottom: 0.5rem; /* Space between label and value */
        }
        /* Specific card colors */
        .card-blue {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); /* Blue gradient */
        }
        .card-blue .stat-value, .card-blue .stat-label, .card-blue .card-main-icon {
            color: white;
        }
        .card-blue .card-background-icon {
            color: rgba(255, 255, 255, 0.2);
        }

        .card-orange {
            background: linear-gradient(135deg, #FFC107 0%, #FF8F00 100%); /* Amber/Orange gradient (kept for contrast) */
        }
        .card-orange .stat-value, .card-orange .stat-label, .card-orange .card-main-icon {
            color: white;
        }
        .card-orange .card-background-icon {
            color: rgba(255, 255, 255, 0.2);
        }

        .card-purple {
            background: linear-gradient(135deg, #673AB7 0%, #512DA8 100%); /* Deep Purple gradient */
        }
        .card-purple .stat-value, .card-purple .stat-label, .card-purple .card-main-icon {
            color: white;
        }
        .card-purple .card-background-icon {
            color: rgba(255, 255, 255, 0.2);
        }

        /* Chat Specific Styles */
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 500px; /* Fixed height for chat window */
            border: 1px solid #e2e8f0; /* Gray-200 */
            border-radius: 1rem; /* More rounded */
            overflow: hidden;
            background-color: #f7fafc;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05); /* Subtle shadow */
        }
        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1.5rem; /* More padding */
            display: flex;
            flex-direction: column;
            gap: 0.75rem; /* More space between messages */
        }
        .chat-message-bubble {
            max-width: 75%; /* Slightly wider bubbles */
            padding: 0.9rem 1.25rem; /* More padding */
            border-radius: 1.25rem; /* More rounded */
            line-height: 1.5;
            word-wrap: break-word;
            font-size: 0.95rem;
        }
        .chat-message-bubble.sent {
            align-self: flex-end;
            background-color: #2196F3; /* Primary Blue */
            color: white;
            border-bottom-right-radius: 0.5rem; /* Slightly less rounded on one corner */
        }
        .chat-message-bubble.received {
            align-self: flex-start;
            background-color: #e0e6eb; /* Light gray */
            color: #2d3748; /* Dark gray */
            border-bottom-left-radius: 0.5rem; /* Slightly less rounded on one corner */
        }
        .message-meta {
            font-size: 0.7rem; /* Smaller meta text */
            color: rgba(255,255,255,0.7); /* Lighter for sent */
            margin-top: 0.4rem;
            text-align: right;
        }
        .chat-message-bubble.received .message-meta {
            color: #718096; /* Darker for received */
            text-align: left;
        }
        .chat-input-area {
            display: flex;
            padding: 1.5rem; /* More padding */
            border-top: 1px solid #e2e8f0;
            background-color: #ffffff; /* White background for input area */
        }
        .chat-input-area input {
            flex-grow: 1;
            padding: 0.9rem 1.2rem; /* More padding */
            border: 1px solid #cbd5e0; /* Matches form inputs */
            border-radius: 0.85rem; /* More rounded */
            margin-right: 0.75rem; /* More space */
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .chat-input-area input:focus {
            border-color: #2196F3;
            outline: 0;
            box-shadow: 0 0 0 4px rgba(33, 150, 243, 0.2);
        }
        .chat-input-area button {
            padding: 0.9rem 1.8rem; /* Larger button */
            background-color: #2196F3; /* Primary Blue */
            color: white;
            border-radius: 0.85rem; /* More rounded */
            cursor: pointer;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .chat-input-area button:hover {
            background-color: #1976D2; /* Darker Blue */
            transform: translateY(-1px);
        }

        /* Rating Specific Styles (for displaying ratings) */
        .rating-star {
            font-size: 1.5rem; /* Larger stars for display */
            color: #fbc02d; /* Amber */
            margin-right: 0.1rem;
        }

        /* Custom Button Style (general) */
        .btn-primary {
            background-color: #2196F3; /* Primary Blue */
            color: white;
            padding: 0.9rem 2.2rem; /* Consistent with admin buttons */
            border-radius: 0.85rem;
            font-weight: 600;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease, box-shadow 0.2s ease;
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-primary:hover {
            background-color: #1976D2; /* Darker Blue */
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: separate; /* Use separate for rounded corners */
            border-spacing: 0;
            border-radius: 1rem; /* More rounded table corners */
            overflow: hidden; /* Ensures rounded corners are visible */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Stronger shadow for table */
        }
        th, td {
            padding: 1.4rem 2rem; /* More generous padding */
            text-align: left;
            border-bottom: 1px solid #dfe6e9; /* Lighter border */
            font-size: 0.95rem;
            color: #34495e;
        }
        th {
            background-color: #e3f2fd; /* Lightest Blue background for headers */
            font-weight: 700;
            color: #2d3748; /* Darker text for headers */
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.03em;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tbody tr:hover {
            background-color: #fcfdfe; /* Very subtle hover effect for rows */
        }

        /* Form elements (for rating submission) */
        .form-control-custom {
            display: block;
            width: 100%;
            padding: 0.9rem 1.6rem;
            font-size: 1.05rem;
            line-height: 1.5;
            color: #34495e;
            background-color: #f7fafc;
            border: 1px solid #cbd5e0;
            border-radius: 0.85rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control-custom:focus {
            border-color: #2196F3;
            outline: 0;
            box-shadow: 0 0 0 6px rgba(33, 150, 243, 0.35);
        }
        .form-label-custom {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 600;
            color: #718096;
            font-size: 1.05rem;
        }

        /* Alerts */
        .alert-custom {
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2.5rem;
            font-weight: 500;
            border-left: 10px solid;
            font-size: 1.1rem;
        }
        .alert-success-custom {
            background-color: #d4edda;
            color: #155724;
            border-color: #28a745;
        }
        .alert-danger-custom {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #dc3545;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Student Navbar -->
    <nav class="header-nav">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a class="text-3xl font-bold" href="#">Bus<span class="brand-text">Tracker</span> Student</a>
            <div class="flex items-center space-x-6">
                <span class="text-lg font-semibold">Welcome, <?= esc($username) ?>!</span>
                <a href="<?= base_url('logout') ?>" class="hover:text-blue-300 font-semibold text-lg transition duration-200">Logout</a>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar Navigation -->
        <aside class="sidebar w-64 flex-shrink-0">
            <nav class="p-4">
                <ul>
                    <li>
                        <a href="#dashboard" class="sidebar-link active" data-section="dashboard">
                            <span class="icon ion-ios-speedometer"></span> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#schedules" class="sidebar-link" data-section="schedules">
                            <span class="icon ion-ios-calendar"></span> My Schedules
                        </a>
                    </li>
                    <li>
                        <a href="#chat-driver" class="sidebar-link" data-section="chat-driver">
                            <span class="icon ion-ios-chatbubbles"></span> Chat with Driver
                        </a>
                    </li>
                    <li>
                        <a href="#rate-driver" class="sidebar-link" data-section="rate-driver">
                            <span class="icon ion-ios-star"></span> Rate Driver
                        </a>
                    </li>
                    <li>
                        <a href="#profile" class="sidebar-link" data-section="profile">
                            <span class="icon ion-ios-person"></span> My Profile
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content-area">
            <!-- Dashboard Section -->
            <div id="dashboard" class="content-section">
                <h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard Overview</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="dashboard-card card-blue">
                        <span class="card-background-icon ion-ios-bus"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-bus"></span>
                            <h3 class="stat-label">Next Bus Departure</h3>
                            <p class="stat-value"><?= esc($nextDepartureTime) ?></p>
                            <p class="text-sm opacity-80">Route: <?= esc($nextDepartureRoute) ?></p>
                        </div>
                    </div>
                    <div class="dashboard-card card-orange">
                        <span class="card-background-icon ion-ios-chatbubbles"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-chatbubbles"></span>
                            <h3 class="stat-label">Unread Messages</h3>
                            <p class="stat-value" id="dashboardUnreadCount"><?= esc($unreadMessagesCount) ?></p>
                        </div>
                    </div>
                    <div class="dashboard-card card-purple">
                        <span class="card-background-icon ion-ios-book"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-book"></span>
                            <h3 class="stat-label">Total Bookings</h3>
                            <p class="stat-value">5</p> <!-- Placeholder, fetch from DB -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Schedules Section -->
            <div id="schedules" class="content-section hidden">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">My Schedules & Map</h1>
                <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
                
            <!--Map-->
            <div class="container">
            <h1> UniSZA Kampus Besut MAP</h1>
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3969.7011977881257!2d102.62652007372489!3d5.
             756077731607967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31b6faab905b2ca7%3A0xa81ba1f9f9407ce8!2sUniSZA%20Kampus%20Besut!5e0!3m2!1sen!2smy!4v1751551385084!5m2!1sen!2smy" 
             width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        
            <!--End Map-->
            
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th>Bus Name</th>
                                <th>Route Name</th>
                                <th>Departure Time</th>
                                <th>Arrival Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="schedulesTableBody">
                            <tr><td colspan="6" class="text-center text-gray-500 py-4">Loading schedules...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chat with Driver Section -->
            <div id="chat-driver" class="content-section hidden">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Chat with Driver</h1>
                <div class="card mb-4">
                    <label for="selectDriver" class="block text-gray-700 text-sm font-bold mb-2">Select Driver:</label>
                    <select id="selectDriver" class="form-control-custom">
                        <option value="">-- Select a driver --</option>
                        <!-- Dynamically load drivers from backend -->
                    </select>
                </div>
                <div class="chat-container">
                    <div class="chat-messages" id="studentChatMessages">
                        <div class="text-center text-gray-500">Select a driver to start chatting.</div>
                    </div>
                    <div class="chat-input-area">
                        <input type="text" id="studentChatInput" placeholder="Type your message..." class="flex-grow">
                        <button id="sendStudentMessageBtn">Send</button>
                    </div>
                </div>
            </div>

            <!-- Rate Driver Section -->
            <!-- Rate Driver Section -->
<div id="rate-driver" class="content-section hidden">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Rate Your Driver</h1>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-custom alert-success-custom">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert-custom alert-danger-custom">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form id="ratingForm" action="<?= base_url('ratings/submit') ?>" method="post" class="form-section">
        <?= csrf_field() ?>

        <!-- Driver Selection -->
        <div class="mb-5">
            <label for="driverSelectRating" class="form-label-custom">Select Driver:</label>
            <select id="driverSelectRating" name="driver_id" class="form-control-custom" required>
                <option value="">-- Select a driver --</option>
                <?php if (!empty($drivers)): ?>
                    <?php foreach ($drivers as $driver): ?>
                        <option value="<?= esc($driver['id']) ?>"><?= esc($driver['fullname']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Star Rating -->
        <div class="mb-5">
            <label class="form-label-custom">Rating:</label>
            <div class="flex items-center space-x-1" id="starRating">
                <span class="rating-star cursor-pointer text-3xl text-gray-400" data-value="1">&#9733;</span>
                <span class="rating-star cursor-pointer text-3xl text-gray-400" data-value="2">&#9733;</span>
                <span class="rating-star cursor-pointer text-3xl text-gray-400" data-value="3">&#9733;</span>
                <span class="rating-star cursor-pointer text-3xl text-gray-400" data-value="4">&#9733;</span>
                <span class="rating-star cursor-pointer text-3xl text-gray-400" data-value="5">&#9733;</span>
            </div>
            <input type="hidden" id="selectedRating" name="rating" value="0" required>
        </div>

        <!-- Comment -->
        <div class="mb-5">
            <label for="comment" class="form-label-custom">Comment (Optional):</label>
            <textarea id="comment" name="comment" rows="4" placeholder="Enter your comments here..." class="form-control-custom"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Submit Rating</button>
        </div>
    </form>
</div>

            
            
            
            
            
            
            
            
            
            
            
            
            

            <!-- My Profile Section -->
            <div id="profile" class="content-section hidden">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">My Profile Information</h1>
                <div class="card bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full bg-white">
                        <tbody id="profileDetailsBody">
                            <?php
                            // Initial data can be rendered here or fully via AJAX
                            if (!empty($studentData)): ?>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">ID:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($studentData['id']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Full Name:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($studentData['fullname']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Username:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($studentData['username']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">User Level:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($studentData['userlevel']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Contact:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($studentData['contact'] ?? 'N/A') ?></td>
                                </tr>
                                <?php if (!empty($studentData['image'])): ?>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Profile Image:</td>
                                    <td class="py-2 px-4 border-b">
                                        <img src="<?= base_url('uploads/images/') ?><?= esc($studentData['image']) ?>" alt="Profile Image" class="w-20 h-20 rounded-full object-cover">
                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php else: ?>
                                <tr><td colspan="2" class="text-center text-gray-500">No profile data available.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
    


     

<!-- JavaScript for dynamic content and interactivity -->
   <script>
const baseUrl = "<?= base_url() ?>";
const csrfToken = "<?= csrf_hash() ?>";
const csrfTokenName = "<?= csrf_token() ?>";
const currentUserId = <?= json_encode(session()->get('user_id')) ?>;

// Elements
const sidebarLinks = document.querySelectorAll('.sidebar-link');
const mainContents = document.querySelectorAll('.content-section');
const dashboardUnreadCount = document.getElementById('dashboardUnreadCount');

const selectDriver = document.getElementById('selectDriver');
const studentChatMessages = document.getElementById('studentChatMessages');
const studentChatInput = document.getElementById('studentChatInput');
const sendStudentMessageBtn = document.getElementById('sendStudentMessageBtn');

const schedulesTableBody = document.getElementById('schedulesTableBody');
const driverSelectRating = document.getElementById('driverSelectRating');
const starRatingContainer = document.getElementById('starRating');
const selectedRatingInput = document.getElementById('selectedRating');
const commentInput = document.getElementById('comment');
const ratingForm = document.getElementById('ratingForm');
const profileDetailsBody = document.getElementById('profileDetailsBody');

let currentChatDriverId = null;

// --- INIT ---
document.addEventListener('DOMContentLoaded', () => {
    showSection('dashboard');
    fetchGlobalUnreadCount();

    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            showSection(e.currentTarget.dataset.section);
        });
    });

    if (sendStudentMessageBtn) {
        sendStudentMessageBtn.addEventListener('click', sendStudentMessage);
    }

    if (studentChatInput) {
        studentChatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendStudentMessage();
        });
    }

    if (selectDriver) {
        selectDriver.addEventListener('change', (e) => {
            const selectedDriverId = e.target.value;
            currentChatDriverId = selectedDriverId;
            if (selectedDriverId) loadChatMessages(selectedDriverId);
            else studentChatMessages.innerHTML = '<div class="text-center text-gray-500">Select a driver to start chatting.</div>';
        });
    }
    
    
    if (starRatingContainer) {
        starRatingContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('rating-star')) {
                const value = parseInt(e.target.dataset.value);
                selectedRatingInput.value = value;
                updateStarDisplay(value);
            }
        });
    }

    if (ratingForm) {
        ratingForm.addEventListener('submit', submitRating);
    }

    setInterval(fetchNewMessagesForCurrentChat, 3000);
    setInterval(fetchGlobalUnreadCount, 10000);
});

// --- Show Sections ---
async function showSection(sectionId) {
    mainContents.forEach(c => c.classList.add('hidden'));
    const target = document.getElementById(sectionId);
    if (target) target.classList.remove('hidden');

    sidebarLinks.forEach(l => l.classList.remove('active'));
    const activeLink = document.querySelector(`.sidebar-link[data-section="${sectionId}"]`);
    if (activeLink) activeLink.classList.add('active');

    if (sectionId === 'schedules') loadSchedules();
    else if (sectionId === 'chat-driver') {
        await loadDriversForChat();
        if (selectDriver.value) {
            currentChatDriverId = selectDriver.value;
            loadChatMessages(selectDriver.value);
        } else {
            studentChatMessages.innerHTML = '<div class="text-center text-gray-500">Select a driver to start chatting.</div>';
            currentChatDriverId = null;
        }
    } else if (sectionId === 'rate-driver') {
        await loadDriversForRating();
        updateStarDisplay(selectedRatingInput.value);
    } else if (sectionId === 'profile') {
        await loadProfileDetails();
    }
}

// --- Load Schedules ---
async function loadSchedules() {
    schedulesTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500 py-4">Loading schedules...</td></tr>';
    try {
        const response = await fetch(`${baseUrl}student/get_schedules`);
        const data = await response.json();
        if (data.status === 'success') {
            if (data.schedules.length === 0) {
                schedulesTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500 py-4">No schedules found.</td></tr>';
                return;
            }
            let html = '';
            data.schedules.forEach(schedule => {
                html += `
                    <tr>
                        <td class="py-2 px-4 border-b">${escapeHtml(schedule.bus_id)}</td>
                        <td class="py-2 px-4 border-b">${escapeHtml(schedule.route_name)}</td>
                        <td class="py-2 px-4 border-b">${escapeHtml(schedule.departure_time)}</td>
                        <td class="py-2 px-4 border-b">${escapeHtml(schedule.arrival_time)}</td>
                        <td class="py-2 px-4 border-b ${['Delayed', 'delayed'].includes(schedule.status) ? 'text-red-600' : 'text-green-600'} font-semibold">
                            ${escapeHtml(schedule.status)}
                        </td>
                    </tr>`;
            });
            schedulesTableBody.innerHTML = html;
        } else {
            schedulesTableBody.innerHTML = `<tr><td colspan="6" class="text-center text-red-500 py-4">${escapeHtml(data.message || 'Failed to load schedules.')}</td></tr>`;
        }
    } catch {
        schedulesTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-red-500 py-4">Error loading schedules.</td></tr>';
    }
}

// --- Load Chat Drivers ---
async function loadDriversForChat() {
    selectDriver.innerHTML = '<option value="">-- Loading drivers --</option>';
    try {
        const response = await fetch(`${baseUrl}student/chat/drivers`);
        const drivers = await response.json();
        selectDriver.innerHTML = '<option value="">-- Select a driver --</option>';
        drivers.forEach(driver => {
            const option = document.createElement('option');
            option.value = driver.id;
            option.textContent = driver.fullname;
            selectDriver.appendChild(option);
        });
    } catch {
        selectDriver.innerHTML = '<option value="">-- Failed to load drivers --</option>';
    }
}

// --- Load Messages ---
async function loadChatMessages(driverId) {
    studentChatMessages.innerHTML = '<div class="text-center text-gray-500">Loading messages...</div>';
    try {
        const res = await fetch(`${baseUrl}chat/messages-by-user/${driverId}`);
        const data = await res.json();

        if (data.status === 'success') {
            studentChatMessages.innerHTML = '';
            data.messages.forEach(msg => appendMessageToChat(msg, currentUserId, studentChatMessages));
            scrollToBottom(studentChatMessages);

            await fetch(`${baseUrl}chat/mark-read/${driverId}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', [csrfHeader]: csrfToken }
            });
        } else {
            studentChatMessages.innerHTML = `<div class="text-center text-red-500">${escapeHtml(data.message || 'Failed to load messages.')}</div>`;
        }
    } catch (err) {
        console.error('Chat load error:', err);
        studentChatMessages.innerHTML = `<div class="text-center text-red-500">Failed to load messages.</div>`;
    }
}

// --- Send Message ---
async function sendStudentMessage() {
    const messageText = studentChatInput.value.trim();
    if (!messageText || !currentChatDriverId) {
        alert('Please select a driver and enter a message.');
        return;
    }

    const formData = new FormData();
    formData.append('receiver_id', currentChatDriverId);
    formData.append('message_text', messageText);
    formData.append(csrfTokenName, csrfToken);

    try {
        const res = await fetch(`${baseUrl}chat/send`, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const result = await res.json();
        if (result.status === 'success') {
            appendMessageToChat({
                sender_id: currentUserId,
                message_text: messageText,
                created_at: new Date().toISOString()
            }, currentUserId, studentChatMessages);
            studentChatInput.value = '';
            scrollToBottom(studentChatMessages);
        } else {
            alert('Error sending message.');
        }
    } catch {
        alert('Error sending message.');
    }
}

// --- Poll New Messages ---
function fetchNewMessagesForCurrentChat() {
    if (!currentChatDriverId) return;
    fetch(`${baseUrl}chat/new-messages?other_user_id=${currentChatDriverId}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success' && data.messages.length > 0) {
            data.messages.forEach(msg => appendMessageToChat(msg, currentUserId, studentChatMessages));
            scrollToBottom(studentChatMessages);
            fetch(`${baseUrl}chat/mark-read/${currentChatDriverId}`, {
                method: 'POST',
                headers: { [csrfTokenName]: csrfToken, 'X-Requested-With': 'XMLHttpRequest' }
            });
            fetchGlobalUnreadCount();
        }
    });
}

// --- Global Unread Count ---
async function fetchGlobalUnreadCount() {
    try {
        const res = await fetch(`${baseUrl}chat/unread-count-api`, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (data.status === 'success') {
            dashboardUnreadCount.textContent = data.unread_count;
        }
    } catch (err) {
        console.error('Unread count error:', err);
    }
}

// --- Load Drivers for Rating ---
async function loadDriversForRating() {
    driverSelectRating.innerHTML = '<option value="">-- Loading drivers --</option>';
    try {
        const response = await fetch(`${baseUrl}student/ratings/drivers`);
        const drivers = await response.json();
        driverSelectRating.innerHTML = '<option value="">-- Select a driver --</option>';
        drivers.forEach(driver => {
            const option = document.createElement('option');
            option.value = driver.id;
            option.textContent = driver.fullname;
            driverSelectRating.appendChild(option);
        });
    } catch {
        driverSelectRating.innerHTML = '<option value="">-- Failed to load drivers --</option>';
    }
}

// --- Submit Rating ---

function updateStarDisplay(selected) {
    const stars = starRatingContainer.querySelectorAll('.rating-star');
    stars.forEach((star, i) => {
        star.style.color = i < selected ? '#fbc02d' : '#e0e6eb';
    });
}

async function submitRating(event) {
    event.preventDefault();

    const driverId = driverSelectRating.value;
    const rating = selectedRatingInput.value;
    const comment = commentInput.value.trim();

    if (!driverId || rating === '0') {
        alert('Please select a driver and star rating.');
        return;
    }

    const formData = new FormData();
    formData.append('driver_id', driverId);
    formData.append('rating', rating);
    formData.append('comment', comment);
    formData.append(csrfTokenName, csrfToken); // ✅ Correctly append CSRF token

    try {
        const response = await fetch(`${baseUrl}student/ratings/submit`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // ✅ marks as AJAX
            }
        });

        const result = await response.json();
        if (result.status === 'success') {
            alert('Rating submitted successfully!');
            ratingForm.reset();
            selectedRatingInput.value = '0';
            updateStarDisplay(0);
        } else {
            alert('Error submitting rating: ' + (result.message || 'Unknown error'));
        }
    } catch (err) {
        console.error('Error submitting rating:', err);
        alert('Network error while submitting rating.');
    }
}

// --- Load Profile ---
async function loadProfileDetails() {
    profileDetailsBody.innerHTML = '<tr><td colspan="2" class="text-center text-gray-500">Loading driver profile...</td></tr>';
    try {
        const response = await fetch(`${baseUrl}driver/profile_details`);
        const data = await response.json();
        if (data.status === 'success') {
            const p = data.profile;
            profileDetailsBody.innerHTML = `
                <tr><td class="font-semibold">ID:</td><td>${escapeHtml(p.id)}</td></tr>
                <tr><td class="font-semibold">Full Name:</td><td>${escapeHtml(p.fullname)}</td></tr>
                <tr><td class="font-semibold">Username:</td><td>${escapeHtml(p.username)}</td></tr>
                <tr><td class="font-semibold">User Level:</td><td>${escapeHtml(p.userlevel)}</td></tr>
                <tr><td class="font-semibold">Contact:</td><td>${escapeHtml(p.contact || 'N/A')}</td></tr>
                ${p.image ? `<tr><td class="font-semibold">Profile Image:</td><td><img src="${baseUrl}uploads/images/${escapeHtml(p.image)}" class="w-20 h-20 rounded-full object-cover"></td></tr>` : ''}
            `;
        } else {
            profileDetailsBody.innerHTML = `<tr><td colspan="2" class="text-center text-red-500">${escapeHtml(data.message || 'Failed to load profile')}</td></tr>`;
        }
    } catch {
        profileDetailsBody.innerHTML = '<tr><td colspan="2" class="text-center text-red-500">Error loading profile.</td></tr>';
    }
}

// --- Helpers ---
function appendMessageToChat(msg, userId, container) {
    const bubble = document.createElement('div');
    bubble.className = msg.sender_id == userId ? 'text-right mb-2' : 'text-left mb-2';
    bubble.innerHTML = `
        <div class="inline-block px-4 py-2 rounded-lg ${msg.sender_id == userId ? 'bg-blue-200' : 'bg-gray-200'}">
            ${escapeHtml(msg.message_text)}
        </div>
        <div class="text-xs text-gray-500">${new Date(msg.created_at).toLocaleTimeString()}</div>`;
    container.appendChild(bubble);
}

function scrollToBottom(el) {
    el.scrollTop = el.scrollHeight;
}

function updateStarDisplay(selected) {
    const stars = starRatingContainer.querySelectorAll('.rating-star');
    stars.forEach((star, i) => {
        star.style.color = i < selected ? '#fbc02d' : '#e0e6eb';
    });
}

function escapeHtml(text) {
    if (typeof text !== 'string') return text;
    return text.replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;',
        '"': '&quot;', "'": '&#039;'
    }[m]));
}
</script>


</body>
</html>
