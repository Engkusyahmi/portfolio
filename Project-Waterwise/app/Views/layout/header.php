<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title>WaterWise - Smart Water Conservation Gaming Platform</title>  
    
    <meta name="description" content="WaterWise is a gamified water conservation platform that helps you save water while earning rewards.">
    <meta name="keywords" content="water conservation, gamification, EcoPoints, sustainability, environmental protection">
    <meta name="author" content="Engku Syahmi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?= base_url('Waterwise/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Waterwise/css/jquery.fancybox.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Waterwise/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Waterwise/css/owl.carousel.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Waterwise/css/slit-slider.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Waterwise/css/animate.css') ?>">
    <link rel="stylesheet" href="<?= base_url('Waterwise/css/main.css') ?>">
    <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">

    <!-- Bootstrap 5 for better components -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Modernizr -->
    <script src="<?= base_url('Waterwise/js/modernizr-2.6.2.min.js') ?>"></script>

    <style>
        /* Fix viewport and scaling issues */
        html {
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        body {
            min-width: 320px;
            font-size: 16px;
            line-height: 1.6;
        }
        
        /* User Dashboard Specific Styles */
        .user-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            padding: 20px 0;
            position: relative;
            overflow: hidden;
        }
        
        .user-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23ffffff"></path></svg>') repeat-x;
            background-size: 1200px 120px;
            animation: wave 20s ease-in-out infinite;
            opacity: 0.3;
        }
        
        .user-stats {
            position: relative;
            z-index: 10;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.25);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Horizontal Navigation Fixes */
        .navbar-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 15px;
        }
        
        .navbar-nav > li {
            margin: 0;
        }
        
        .navbar-nav .nav-link {
            padding: 10px 15px;
            white-space: nowrap;
            color: white !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        
        .navbar-brand {
            margin-right: 30px !important;
        }
        
        #profileDropdown {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        #profileDropdown:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .profile-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #ffffff, #e3f2fd);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary-blue);
            font-size: 14px;
        }
        
        .main-content {
            padding-top: 80px;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
        }
        
        .dashboard-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Responsive fixes */
        @media (max-width: 768px) {
            .main-content {
                padding-top: 70px;
            }
            
            .user-header {
                padding: 15px 0;
            }
            
            .stat-card {
                margin-bottom: 15px;
            }
            
            .navbar-nav {
                flex-direction: column;
                gap: 5px;
            }
            
            .dashboard-container {
                padding: 15px;
            }
        }
        
        /* Ensure proper container sizing */
        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }
        }
    </style>
</head>

<body id="home">

<!-- Preloader -->
<div id="preloader">
    <div class="loder-box">
        <div class="water-drop"></div>
    </div>
</div>

<!-- Header -->
<header id="navigation" class="navbar-inverse navbar-fixed-top animated-header">
    <div class="container">
        <div class="navbar-header">
            <!-- Responsive nav -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php 
            $session = session();
            $uri = service('uri');
            $currentPage = $uri->getSegment(1);

            if (in_array($currentPage, ['login', 'register'])) {
                $homeLink = base_url('/');
            } else {
                $userlevel = $session->get('userlevel');
                if ($userlevel === 'admin') {
                    $homeLink = base_url('/admin');
                } elseif ($userlevel === 'user') {
                    $homeLink = base_url('/user');
                } else {
                    $homeLink = base_url('/');
                }
            }
            ?>

            <!-- Logo -->
            <h1 class="navbar-brand">
                <a href="<?= $homeLink ?>">WaterWise</a>
            </h1>
        </div>

        <?php if (!in_array($currentPage, ['login', 'register'])): ?>
            <nav class="collapse navbar-collapse navbar-right" role="navigation">
                <ul class="nav navbar-nav">

                    <?php if ($session->has('logged_in') && $session->get('userlevel') === 'user'): ?>
                        <li><a class="nav-link" href="<?= base_url('/user') ?>">Dashboard</a></li>
                        <li><a class="nav-link" href="<?= base_url('/user/quest') ?>">Quests</a></li>
                        <li><a class="nav-link" href="<?= base_url('/user/achievement') ?>">Achievements</a></li>
                        <li><a class="nav-link" href="<?= base_url('/user/rewardstore') ?>">Rewards</a></li>

                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-avatar">
                                    <?= strtoupper(substr($session->get('username'), 0, 1)) ?>
                                </div>
                                <strong><?= esc($session->get('username')) ?></strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('/user/settings') ?>"><i class="fa fa-cog"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php elseif ($session->has('logged_in') && $session->get('userlevel') === 'admin'): ?>
                        <li><a href="<?= base_url('/admin') ?>" class="nav-link">Admin Dashboard</a></li>
                        <li><a href="<?= base_url('/logout') ?>" class="nav-link">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?= base_url('/login') ?>" class="nav-link">Login</a></li>
                        <li><a href="<?= base_url('/register') ?>" class="nav-link">Register</a></li>
                    <?php endif; ?>

                </ul>
            </nav>
        <?php endif; ?>
    </div>
</header>

<!-- Main Content Wrapper -->
<main class="main-content" role="main">