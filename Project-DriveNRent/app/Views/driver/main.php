<?php
// Retrieve session data

$username = session()->get('username') ?? 'Driver';
$driverId = session()->get('user_id') ?? null;

// Placeholder data - these should ideally be passed from DriverController
$totalRoutes = $totalRoutes ?? 0;
$totalStudents = $totalStudents ?? 0; // Re-added as per user request to keep the card
$totalBuses = $totalBuses ?? 0;
$unreadMessagesCount = $unreadMessagesCount ?? 0;
$averageRating = $averageRating ?? 'N/A';
$driverData = $driverData ?? []; // For profile section
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTracker Driver Portal</title>
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
            background-color: #512DA8; /* Dark Purple */
            color: white;
            padding: 1rem 0;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25); /* More pronounced shadow */
        }
        .header-nav .brand-text {
            color: #D1C4E9; /* Lighter Purple accent */
        }
        .header-nav a {
            transition: color 0.3s ease;
        }
        .header-nav a:hover {
            color: #B39DDB; /* Medium Purple on hover */
        }

        .sidebar {
            background-color: #673AB7; /* Primary Deep Purple for sidebar */
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
            color: #EDE7F6; /* Very Light Purple text */
            font-weight: 500;
            font-size: 1.05rem; /* Slightly larger font */
        }
        .sidebar-link:hover {
            background-color: #7E57C2; /* Purple 400 on hover */
            transform: translateX(12px); /* More pronounced slide effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar-link.active {
            background-color: #9575CD; /* Purple 300 active background */
            color: white;
            font-weight: 700;
            box-shadow: 0 6px 15px rgba(149, 117, 205, 0.7); /* Stronger purple shadow for active */
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
        .card-purple {
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%); /* Primary Purple gradient */
        }
        .card-purple .stat-value, .card-purple .stat-label, .card-purple .card-main-icon {
            color: white;
        }
        .card-purple .card-background-icon {
            color: rgba(255, 255, 255, 0.2);
        }

        .card-blue {
            background: linear-gradient(135deg, #42A5F5 0%, #2196F3 100%); /* Blue gradient (complementary) */
        }
        .card-blue .stat-value, .card-blue .stat-label, .card-blue .card-main-icon {
            color: white;
        }
        .card-blue .card-background-icon {
            color: rgba(255, 255, 255, 0.2);
        }

        .card-pink {
            background: linear-gradient(135deg, #E91E63 0%, #C2185B 100%); /* Pink gradient (vibrant contrast) */
        }
        .card-pink .stat-value, .card-pink .stat-label, .card-pink .card-main-icon {
            color: white;
        }
        .card-pink .card-background-icon {
            color: rgba(255, 255, 255, 0.2);
        }

        .card-amber {
            background: linear-gradient(135deg, #FFC107 0%, #FF8F00 100%); /* Amber gradient (for ratings) */
        }
        .card-amber .stat-value, .card-amber .stat-label, .card-amber .card-main-icon {
            color: white;
        }
        .card-amber .card-background-icon {
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
            background-color: #9C27B0; /* Primary Purple */
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
            border-color: #9C27B0;
            outline: 0;
            box-shadow: 0 0 0 4px rgba(156, 39, 176, 0.2);
        }
        .chat-input-area button {
            padding: 0.9rem 1.8rem; /* Larger button */
            background-color: #9C27B0; /* Primary Purple */
            color: white;
            border-radius: 0.85rem; /* More rounded */
            cursor: pointer;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .chat-input-area button:hover {
            background-color: #7B1FA2; /* Dark Purple */
            transform: translateY(-1px);
        }

        /* Rating Specific Styles (for displaying ratings) */
        .rating-stars {
            color: #fbc02d; /* Amber for active stars */
        }
        .rating-stars .empty-star {
            color: #e0e6eb; /* Light gray for empty stars */
        }

        /* Custom Button Style (general) */
        .btn-primary {
            background-color: #9C27B0; /* Primary Purple */
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
            background-color: #7B1FA2; /* Dark Purple */
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
            background-color: #EDE7F6; /* Very Light Purple background for headers */
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

        /* Form elements */
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
            border-color: #9C27B0;
            outline: 0;
            box-shadow: 0 0 0 6px rgba(156, 39, 176, 0.35);
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

    <nav class="header-nav">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a class="text-3xl font-bold" href="#">Bus<span class="brand-text">Tracker</span> Driver</a>
            <div class="flex items-center space-x-6">
                <span class="text-lg font-semibold">Welcome, <?= esc($username) ?>!</span>
                <a href="<?= base_url('logout') ?>" class="hover:text-purple-300 font-semibold text-lg transition duration-200">Logout</a>
            </div>
        </div>
    </nav>

    <div class="flex">
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
                    <!-- Removed "My Students" section -->
                    <li>
                        <a href="#chat-student" class="sidebar-link" data-section="chat-student">
                            <span class="icon ion-ios-chatbubbles"></span> Chat with Student
                        </a>
                    </li>
                    <li>
                        <a href="#rating" class="sidebar-link" data-section="rating">
                            <span class="icon ion-ios-star"></span> My Ratings
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

        <main class="main-content-area">
            <div id="dashboard" class="content-section">
                <h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard Overview</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="dashboard-card card-purple">
                        <span class="card-background-icon ion-ios-stats"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-stats"></span>
                            <h3 class="stat-label">Total Routes Assigned</h3>
                            <p class="stat-value" id="dashboardTotalRoutes"><?= esc($totalRoutes) ?></p>
                        </div>
                    </div>
                    <div class="dashboard-card card-amber">
                        <span class="card-background-icon ion-ios-star"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-star"></span>
                            <h3 class="stat-label">Average Rating</h3>
                            <p class="stat-value" id="dashboardAverageRating"><?= esc($averageRating) ?></p>
                        </div>
                    </div>
                    <div class="dashboard-card card-pink">
                        <span class="card-background-icon ion-ios-chatbubbles"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-chatbubbles"></span>
                            <h3 class="stat-label">Unread Messages</h3>
                            <p class="stat-value" id="dashboardUnreadCount"><?= esc($unreadMessagesCount) ?></p>
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

            <!-- Removed "My Students" content section -->

            <div id="chat-student" class="content-section hidden">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Chat with Student</h1>
                <div class="card mb-4">
                    <label for="selectStudent" class="block text-gray-700 text-sm font-bold mb-2">Select Student:</label>
                    <select id="selectStudent" class="form-control-custom">
                        <option value="">-- Select a student --</option>
                        </select>
                </div>
                <div class="chat-container">
                    <div class="chat-messages" id="driverChatMessages">
                        <div class="text-center text-gray-500">Select a student to start chatting.</div>
                    </div>
                    <div class="chat-input-area">
                        <input type="text" id="driverChatInput" placeholder="Type your message..." class="flex-grow">
                        <button id="sendDriverMessageBtn">Send</button>
                    </div>
                </div>
            </div>

            <div id="rating" class="content-section hidden">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">My Ratings</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="dashboard-card card-amber">
                        <span class="card-background-icon ion-ios-star"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-star"></span>
                            <h3 class="stat-label">Overall Rating</h3>
                            <p class="stat-value" id="overallRatingDisplay">N/A</p>
                        </div>
                    </div>
                    <div class="dashboard-card card-purple">
                        <span class="card-background-icon ion-ios-chatbubbles"></span>
                        <div class="card-content">
                            <span class="card-main-icon ion-ios-chatbubbles"></span>
                            <h3 class="stat-label">Total Reviews</h3>
                            <p class="stat-value" id="totalReviewsDisplay">0</p>
                        </div>
                    </div>
                </div>

                <h2 class="text-2xl font-bold mt-12 mb-6 text-gray-800">Recent Reviews</h2>
                <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="reviewsTableBody">
                            <tr><td colspan="4" class="text-center text-gray-500 py-4">Loading reviews...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="profile" class="content-section hidden">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">My Profile Information</h1>
                <div class="card bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full bg-white">
                        <tbody id="profileDetailsBody">
                            <?php
                            // Initial data can be rendered here or fully via AJAX
                            if (!empty($driverData)): ?>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">ID:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($driverData['id']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Full Name:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($driverData['fullname']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Username:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($driverData['username']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">User Level:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($driverData['userlevel']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Contact:</td>
                                    <td class="py-2 px-4 border-b"><?= esc($driverData['contact'] ?? 'N/A') ?></td>
                                </tr>
                                <?php if (!empty($driverData['image'])): ?>
                                <tr>
                                    <td class="font-semibold py-2 px-4 border-b">Profile Image:</td>
                                    <td class="py-2 px-4 border-b">
                                        <img src="<?= base_url('uploads/images/') ?><?= esc($driverData['image']) ?>" alt="Profile Image" class="w-20 h-20 rounded-full object-cover">
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

<script>
    const baseUrl = '<?= base_url() ?>';
    const currentUserId = <?= session()->get('user_id') ?>;
    const csrfToken = '<?= csrf_hash() ?>';
    const csrfHeader = '<?= csrf_header() ?>';

    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    const mainContents = document.querySelectorAll('.content-section');
    const dashboardUnreadCount = document.getElementById('dashboardUnreadCount');
    const selectStudent = document.getElementById('selectStudent');
    const driverChatMessages = document.getElementById('driverChatMessages');
    const driverChatInput = document.getElementById('driverChatInput');
    const sendDriverMessageBtn = document.getElementById('sendDriverMessageBtn');
    const overallRatingDisplay = document.getElementById('overallRatingDisplay');
    const totalReviewsDisplay = document.getElementById('totalReviewsDisplay');
    const reviewsTableBody = document.getElementById('reviewsTableBody');
    const profileDetailsBody = document.getElementById('profileDetailsBody');

    let currentChatStudentId = null;

    document.addEventListener('DOMContentLoaded', () => {
        showSection('dashboard');
        fetchGlobalUnreadCount();
        loadStudentsForChat();

        sidebarLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                showSection(e.currentTarget.dataset.section);
            });
        });

        sendDriverMessageBtn.addEventListener('click', sendDriverMessage);
        driverChatInput.addEventListener('keypress', e => {
            if (e.key === 'Enter') sendDriverMessage();
        });
        selectStudent.addEventListener('change', () => {
            currentChatStudentId = selectStudent.value;
            if (currentChatStudentId) loadChatMessages(currentChatStudentId);
        });

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
        const response = await fetch(`${baseUrl}/driver/get_schedules`);
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

    async function loadStudentsForChat() {
        selectStudent.innerHTML = '<option value="">-- Loading students --</option>';
        try {
            const res = await fetch(baseUrl + 'driver/chat/students');
            const data = await res.json();
            selectStudent.innerHTML = '<option value="">-- Select a student --</option>';
            data.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = s.fullname;
                selectStudent.appendChild(opt);
            });
        } catch (err) {
            console.error('Failed to load students', err);
        }
    }

    async function loadChatMessages(studentId) {
        driverChatMessages.innerHTML = '<div class="text-center text-gray-500">Loading...</div>';
        try {
            const res = await fetch(baseUrl + 'chat/messages-by-user/' + studentId);
            const data = await res.json();
            driverChatMessages.innerHTML = '';
            data.messages.forEach(msg => appendMessageToChat(msg, currentUserId, driverChatMessages));
            scrollToBottom(driverChatMessages);

            await fetch(baseUrl + 'chat/mark-read/' + studentId, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', [csrfHeader]: csrfToken }
            });
        } catch (err) {
            console.error('Error loading messages:', err);
        }
    }

    async function sendDriverMessage() {
        const messageText = driverChatInput.value.trim();
        if (!messageText || !currentChatStudentId) return;

        const formData = new FormData();
        formData.append('receiver_id', currentChatStudentId);
        formData.append('message_text', messageText);
        formData.append('<?= csrf_token() ?>', csrfToken);

        try {
            const res = await fetch(baseUrl + 'chat/send', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const result = await res.json();
            if (result.status === 'success') {
                appendMessageToChat({
                    sender_id: currentUserId,
                    receiver_id: currentChatStudentId,
                    message_text: messageText,
                    created_at: new Date().toISOString(),
                    is_read: 0
                }, currentUserId, driverChatMessages);
                driverChatInput.value = '';
                scrollToBottom(driverChatMessages);
            }
        } catch (err) {
            console.error('Send message error:', err);
        }
    }

    function fetchNewMessagesForCurrentChat() {
        if (!currentChatStudentId) return;
        fetch(`${baseUrl}chat/new-messages?other_user_id=${currentChatStudentId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.messages.length > 0) {
                data.messages.forEach(msg => appendMessageToChat(msg, currentUserId, driverChatMessages));
                scrollToBottom(driverChatMessages);

                fetch(`${baseUrl}chat/mark-read/${currentChatStudentId}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', [csrfHeader]: csrfToken }
                });
                fetchGlobalUnreadCount();
            }
        })
        .catch(err => console.error('Polling error:', err));
    }

    async function fetchGlobalUnreadCount() {
        try {
            const res = await fetch(`${baseUrl}chat/unread-count-api`, {
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

    async function loadMyRatings() {
        overallRatingDisplay.textContent = 'Loading...';
        totalReviewsDisplay.textContent = 'Loading...';
        reviewsTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';
        try {
            const res = await fetch(`${baseUrl}driver/get_ratings`);
            const data = await res.json();
            overallRatingDisplay.textContent = data.overall_rating ?? 'N/A';
            totalReviewsDisplay.textContent = data.total_reviews ?? 0;

            reviewsTableBody.innerHTML = '';
            data.reviews.forEach(r => {
                reviewsTableBody.innerHTML += `
                    <tr>
                        <td class="py-2 px-4 border-b">${escapeHtml(r.student_fullname)}</td>
                        <td class="py-2 px-4 border-b">${generateStarRating(r.rating)}</td>
                        <td class="py-2 px-4 border-b">${escapeHtml(r.comment)}</td>
                        <td class="py-2 px-4 border-b">${new Date(r.created_at).toLocaleDateString()}</td>
                    </tr>`;
            });
        } catch (err) {
            console.error('Rating error:', err);
        }
    }

// --- Load Profile ---
async function loadProfileDetails() {
    profileDetailsBody.innerHTML = '<tr><td colspan="2" class="text-center text-gray-500">Loading profile...</td></tr>';
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
    } catch (err) {
        console.error('Profile fetch error:', err);
        profileDetailsBody.innerHTML = '<tr><td colspan="2" class="text-center text-red-500">Error loading profile.</td></tr>';
    }
}

    function appendMessageToChat(msg, currentUserId, container) {
        const div = document.createElement('div');
        div.classList.add('chat-message-bubble', msg.sender_id == currentUserId ? 'sent' : 'received');
        div.innerHTML = `<p>${escapeHtml(msg.message_text)}</p><div class="message-meta">${msg.sender_id == currentUserId ? 'You' : 'Student'} - ${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>`;
        container.appendChild(div);
    }

    function scrollToBottom(el) {
        el.scrollTop = el.scrollHeight;
    }

    function escapeHtml(str) {
        if (typeof str !== 'string') return str;
        return str.replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m]));
    }

    function generateStarRating(rating) {
        let stars = '';
        const r = Math.round(rating * 2) / 2;
        for (let i = 1; i <= 5; i++) {
            stars += i <= r ? '&#9733;' : '<span class="text-gray-300">&#9733;</span>';
        }
        return stars;
    }
</script>
</body>
</html>
