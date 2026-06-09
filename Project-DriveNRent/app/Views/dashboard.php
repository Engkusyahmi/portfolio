<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTracker - Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>?v=<?= time(); ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* All your previous general styles */
        body { font-family: 'Poppins', sans-serif; background: #C0C0C0; color: #333; margin: 0; padding: 0; line-height: 1.6; }
          header { background: linear-gradient(to right, #4682B4, #0F0); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
        .logo a { font-size: 1.8rem; font-weight: 700; color: white !important; text-transform: uppercase; letter-spacing: 1px; }
        .navbar a { color: white !important; text-decoration: none; margin-left: 1.5rem; font-weight: 500; transition: color 0.3s ease; }
        .navbar a:hover { color: #f0f0f0 !important; text-decoration: underline !important; }
        .hero { position: relative; height: 400px; background: url('https://source.unsplash.com/random/1600x900/?bus,road') no-repeat center center/cover; display: flex; align-items: center; justify-content: center; text-align: center; color: white; margin-bottom: 2rem; }
        .hero-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); }
         .hero-content { position: relative; z-index: 1; max-width: 800px; padding: 0 1rem; }
        .hero-content h1 { font-size: 3.5rem; margin-bottom: 1rem; font-weight: 700; }
        .hero-content p { font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9; }
        .hero-content .btn { background-color: #2F4F4F; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 600; transition: background-color 0.3s ease, transform 0.2s ease; }
        .hero-content .btn:hover { background-color: #228B22; transform: translateY(-2px); }
        .center-heading { text-align: center; font-weight: 700; margin-top: 40px; margin-bottom: 30px; font-size: 2.5rem; color: #34495e; }
        

        /* --- UPDATED STATS GRID & CARD CSS STARTS HERE --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* More compact */
            gap: 1.5rem; /* Consistent gap */
            padding: 0 2rem;
            max-width: 1200px;
            margin: 0 auto; /* Center the grid */
        }

        .stat-card {
            background: #ffffff;
            padding: 1.5rem; /* Reduced padding for a more compact card */
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center; /* Center align all text and inline content */
            display: flex; /* Use flexbox for vertical centering */
            flex-direction: column; /* Stack children vertically */
            align-items: center; /* Horizontally center items within the flex container */
            justify-content: center; /* Vertically center content if card height varies */
            min-height: 180px; /* Optional: Gives cards a consistent minimum height */
        }

        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12); }

        .stat-card h3 {
            font-size: 1rem;
            text-transform: uppercase;
            color: #7f8c8d;
            margin-bottom: 0.5rem; /* Reduced margin for compactness */
            font-weight: 600;
        }

        .stat-value {
            font-size: 2.5rem; /* Slightly smaller value for better fit */
            font-weight: 700;
            color: #c0392b;
            line-height: 1;
            margin-bottom: 1rem; /* Space between value and icon (if icon is below) */
        }

        .stat-icon {
            font-size: 2.2rem; /* Adjusted icon size for visual balance */
            color: #fff;
            width: 65px; /* Larger circular background */
            height: 65px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto; /* Center icon horizontally and add bottom margin */
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            order: -1; /* This is key! It moves the icon to the top within the flex column */
        }
        /* --- UPDATED STATS GRID & CARD CSS ENDS HERE --- */


        /* Specific icon background colors remain the same */
        .driver .stat-icon { background-color: #3498db; }
        .admins .stat-icon { background-color: #9b59b6; }
        .students .stat-icon { background-color: #2ecc71; }
        .bookings .stat-icon { background-color: #e67e22; }
        .approved .stat-icon { background-color: #1abc9c; }
        .pending .stat-icon { background-color: #f39c12; }

        /* Charts Container */
        .charts-container { background: #ffffff; margin: 3rem auto; padding: 2.5rem; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); max-width: 1200px; }
        .charts-container h3 { font-size: 1.8rem; color: #34495e; margin-bottom: 1.5rem; font-weight: 600; border-bottom: 2px solid #ecf0f1; padding-bottom: 10px; }

        /* Activity Container */
        .activity-container { background: #ffffff; margin: 3rem auto; padding: 2.5rem; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); max-width: 1200px; margin-bottom: 4rem; }
        .activity-container h3 { font-size: 1.8rem; color: #34495e; margin-bottom: 1.5rem; font-weight: 600; border-bottom: 2px solid #ecf0f1; padding-bottom: 10px; }
        .activity-item { display: flex; align-items: flex-start; border-bottom: 1px solid #ecf0f1; padding: 1rem 0; }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon { width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1.2rem; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); }

        /* Activity icon colors */
        .bg-success { background-color: #28a745 !important; }
        .bg-warning { background-color: #ffc107 !important; }
        .bg-secondary { background-color: #6c757d !important; }

        .activity-item div:first-of-type { font-weight: 500; color: #555; margin-bottom: 0.3rem; }
        .activity-time { font-size: 0.9rem; color: #95a5a6; }

        /* Utility classes for Bootstrap overrides if needed, but prefer custom styling */
        .d-flex { display: flex; }
        .justify-content-between { justify-content: space-between; }
        .align-items-center { align-items: center; }
        .mb-4 { margin-bottom: 1.5rem !important; }

        /* General override for Bootstrap link styles in header */
        .navbar a,
        .logo a {
            text-decoration: none !important;
            color: inherit;
        }

    </style>
</head>
<body>

    <header>
        <div class="logo">
            <a href="<?= base_url(); ?>">BusTracker</a>
        </div>
        <nav class="navbar">
            <a href="<?= base_url(''); ?>">Home</a>
            <a href="<?= base_url('/dashboard'); ?>">Dashboard</a>
            <a href="<?= base_url('/about'); ?>">About</a>
            <a href="<?= base_url('/features'); ?>">Features</a>
            <a href="<?= base_url('/pricing'); ?>">Pricing</a>
            <a href="<?= base_url('/solution'); ?>">Solution</a>
            <a href="<?= base_url('/login'); ?>">login</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
       
            <h1 class="center-heading">Welcome to <span style="color:#28a745;">BusTracker</span></h1>
            <p>Fast &amp; Easy Way To Track &amp; Booking Bus</p>
            <a href="<?= base_url('/features'); ?>" class="btn">Discover Features</a>
        </div>
    </section>
 
    <div class="container-fluid">
        <h1 class="center-heading"><span style="color:#4682B4, #0F0;">Dashboard Of BusTracker</span></h1>
        <div class="stats-grid">
            <div class="stat-card driver">
                <div class="stat-icon"><i class="fas fa-bus"></i></div>
                <h3>Total Driver</h3>
                <div class="stat-value"><?= $totalDriver ?></div>
            </div>
            <div class="stat-card admins">
                <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                <h3>Total Admin</h3>
                <div class="stat-value"><?= $totalAdmin ?></div>
            </div>
            <div class="stat-card students">
                <div class="stat-icon"><i class="fas fa-child"></i></div>
                <h3>Total Student</h3>
                <div class="stat-value"><?= $totalStudent ?></div>
            </div>
            <div class="stat-card bookings">
                <div class="stat-icon"><i class="fas fa-ticket-alt"></i></div>
                <h3>Total Bookings</h3>
                <div class="stat-value"><?= $totalBookings ?></div>
            </div>
            <div class="stat-card approved">
                <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                <h3>Total Approved</h3>
                <div class="stat-value"><?= $approvedBookings ?></div>
            </div>
            <div class="stat-card pending">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <h3>Total Pending</h3>
                <div class="stat-value"><?= $pendingBookings ?></div>
            </div>
        </div>

        <div class="charts-container">
            <h3 class="mb-4">Monthly Activity Overview</h3>
            <canvas id="monthlyActivityChart" height="100"></canvas>
        </div>

        <div class="activity-container">
            <h3 class="mb-4">Recent Activities</h3>
            <?php foreach ($recentActivity as $activity): ?>
                <div class="activity-item">
                    <div class="activity-icon bg-<?php echo $activity['status'] == 'approved' ? 'success' : ($activity['status'] == 'pending' ? 'warning' : 'secondary'); ?>">
                        <i class="fas <?php echo $activity['status'] == 'approved' ? 'fa-clipboard-check' : ($activity['status'] == 'pending' ? 'fa-spinner' : 'fa-list'); ?>"></i>
                    </div>
                    <div>
                        <div><?= ucfirst($activity['status']) ?> booking by ID <?= $activity['id'] ?></div>
                        <div class="activity-time"><?= date('d M Y, h:i A', strtotime($activity['created_at'])) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('monthlyActivityChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($monthlyStats['labels']) ?>,
                datasets: [
                    {
                        label: 'Bookings',
                        data: <?= json_encode($monthlyStats['bookings']) ?>,
                        backgroundColor: '#e67e22'
                    },
                    {
                        label: 'Approved',
                        data: <?= json_encode($monthlyStats['approved']) ?>,
                        backgroundColor: '#1abc9c'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>