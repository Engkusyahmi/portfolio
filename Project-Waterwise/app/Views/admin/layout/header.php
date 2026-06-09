<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WaterSaver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateX(5px);
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .stat-card-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .navbar-brand {
            font-weight: bold;
            color: #667eea !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-tint"></i> WaterSaver Admin
                    </h4>
                    <nav class="nav flex-column">
                        <a class="nav-link <?= uri_string() == 'admin' ? 'active' : '' ?>" href="<?= base_url('/admin') ?>">
                            <i class="fas fa-chart-line me-2"></i> Dashboard
                        </a>
                        <a class="nav-link <?= strpos(uri_string(), 'manage-users') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/manage-users') ?>">
                            <i class="fas fa-users me-2"></i> Manage Users
                        </a>
                        <a class="nav-link <?= strpos(uri_string(), 'manage-achievements') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/manage-achievements') ?>">
                            <i class="fas fa-trophy me-2"></i> Achievements
                        </a>
                        <a class="nav-link <?= strpos(uri_string(), 'manage-rewards') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/manage-rewards') ?>">
                            <i class="fas fa-gift me-2"></i> Rewards
                        </a>
                        <a class="nav-link <?= strpos(uri_string(), 'manage-quests') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/manage-quests') ?>">
                            <i class="fas fa-tasks me-2"></i> Quests
                        </a>
                        <a class="nav-link <?= strpos(uri_string(), 'system-stats') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/system-stats') ?>">
                            <i class="fas fa-chart-bar me-2"></i> Statistics
                        </a>
                        <hr class="my-3">
                        <a class="nav-link" href="<?= base_url('/user') ?>">
                            <i class="fas fa-eye me-2"></i> View User Site
                        </a>
                        <a class="nav-link" href="<?= base_url('/logout') ?>">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content p-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <span class="navbar-brand">Admin Panel</span>
                        <div class="navbar-nav ms-auto">
                            <span class="nav-item nav-link">
                                Welcome, <?= esc(session()->get('username')) ?>
                            </span>
                        </div>
                    </div>
                </nav>

                <!-- Content Area -->
                <div class="p-4">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>