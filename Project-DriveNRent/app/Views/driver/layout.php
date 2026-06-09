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
        <!-- Main Content Area - This is where the specific view content will be injected -->
                <main class="main-content-area">
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
            
            
              <!-- Custom Alert/Confirmation Modals (Replaces default browser alerts) -->
            <div id="customAlertOverlay" class="modal-overlay hidden">
                <div class="modal-content text-center">
                    <h3 id="customAlertTitle" class="text-2xl font-bold mb-4 text-gray-800">Alert</h3>
                    <p id="customAlertMessage" class="mb-6 text-gray-700"></p>
                    <div class="flex justify-center space-x-4">
                        <button id="customAlertConfirmBtn" class="btn-custom btn-red hidden">Confirm</button>
                        <button id="customAlertCloseBtn" class="btn-custom btn-primary-blue">OK</button>
                    </div>
                </div>
            </div>
            
            
            <!-- External JavaScript includes (from carbook-master) -->
            <script src="<?= base_url('/')?>/carbook-master/js/jquery.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/jquery-migrate-3.0.1.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/popper.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/bootstrap.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/jquery.easing.1.3.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/jquery.waypoints.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/jquery.stellar.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/owl.carousel.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/jquery.magnific-popup.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/aos.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/jquery.animateNumber.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/bootstrap-datepicker.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/jquery.timepicker.min.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/scrollax.min.js"></script>
            <!-- Google Maps API key should be handled securely in a real application -->
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/google-map.js"></script>
            <script src="<?= base_url('/')?>/carbook-master/js/main.js"></script>

            <script>
                // Global CSRF token and header for AJAX requests (if you decide to use AJAX later)
                const csrfToken = "<?= csrf_hash() ?>";
                const csrfHeader = '<?= csrf_header() ?>';
                
                
                
             // --- Custom Alert/Confirmation Functions ---
                function showCustomAlert(message, title = 'Alert', isConfirm = false, confirmCallback = null) {
                    const overlay = document.getElementById('customAlertOverlay');
                    const titleElement = document.getElementById('customAlertTitle');
                    const messageElement = document.getElementById('customAlertMessage');
                    const confirmBtn = document.getElementById('customAlertConfirmBtn');
                    const closeBtn = document.getElementById('customAlertCloseBtn');


               titleElement.textContent = title;
                    messageElement.textContent = message;
                    
                    
              if (isConfirm) {
                        confirmBtn.classList.remove('hidden');
                        closeBtn.textContent = 'Cancel';
                        confirmBtn.onclick = () => {
                            if (confirmCallback) {
                                confirmCallback();
                            }
                            closeCustomAlert();
                        };
                    } else {
                        confirmBtn.classList.add('hidden');
                        closeBtn.textContent = 'OK';
                    }
                    closeBtn.onclick = closeCustomAlert;
                    overlay.classList.add('show');
                    overlay.classList.remove('hidden');
                }

                function closeCustomAlert() {
                    const overlay = document.getElementById('customAlertOverlay');
                    overlay.classList.add('hidden');
                    overlay.classList.remove('show');
                    document.getElementById('customAlertConfirmBtn').onclick = null;
                    document.getElementById('customAlertCloseBtn').onclick = null;
                }

                // Override window.confirm and window.alert
                window.confirm = function(message) {
                    return new Promise((resolve) => {
                        showCustomAlert(message, 'Confirm Action', true, () => resolve(true));
                        document.getElementById('customAlertCloseBtn').onclick = () => {
                            closeCustomAlert();
                            resolve(false);
                        };
                    });
                };

                window.alert = function(message) {
                    showCustomAlert(message, 'Alert');
                };

                // --- Sidebar Navigation and Section Display ---
                document.addEventListener('DOMContentLoaded', () => {
                    const sidebarLinks = document.querySelectorAll('.sidebar-link');
                    const mainContents = document.querySelectorAll('.content-section');

                    function showSection(sectionId) {
                        mainContents.forEach(content => {
                            content.classList.add('hidden');
                        });

                        const targetSection = document.getElementById(sectionId);
                        if (targetSection) {
                            targetSection.classList.remove('hidden');
                        }

                        sidebarLinks.forEach(link => {
                            link.classList.remove('active');
                        });

                        const activeLink = document.querySelector(`.sidebar-link[data-section="${sectionId}"]`);
                        if (activeLink) {
                            activeLink.classList.add('active');
                        }
                    }

                    sidebarLinks.forEach(link => {
                        link.addEventListener('click', (event) => {
                            event.preventDefault();
                            const sectionId = event.currentTarget.dataset.section;
                            showSection(sectionId);
                            // Update URL hash without reloading
                            history.pushState(null, '', `#${sectionId}`);
                        });
                    });

                    // Initial section display based on URL hash or default to dashboard
                    const initialHash = window.location.hash.substring(1);
                    if (initialHash && Array.from(mainContents).some(content => content.id === initialHash)) {
                        showSection(initialHash);
                    } else {
                        showSection('dashboard');
                    }

                    // Handle browser back/forward buttons for hash changes
                    window.addEventListener('popstate', () => {
                        const hash = window.location.hash.substring(1);
                        if (hash && Array.from(mainContents).some(content => content.id === hash)) {
                            showSection(hash);
                        } else if (!hash) { // If hash is cleared (e.g., back to base URL)
                            showSection('dashboard');
                        }
                    });

                    // --- Attach custom confirm to delete forms ---
                    document.querySelectorAll('form[onsubmit*="confirm("]').forEach(form => {
                        form.addEventListener('submit', function(event) {
                            event.preventDefault();
                            const formElement = this;

                            window.confirm('Are you sure you want to delete this item?')
                                .then((result) => {
                                    if (result) {
                                        formElement.submit();
                                    }
                                });
                        });
                    });
                });
            </script>
        </body>
        </html>