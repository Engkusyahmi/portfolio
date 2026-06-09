<?= $this->include('layout/header') ?>

<?php
if (!session()->has('userlevel') || session()->get('userlevel') !== 'user') {
    die('Access denied');
}

$session = session();
$username = esc($session->get('username'));
$ecopoints = $userData->ecopoints ?? 0;
$xp = $userData->xp ?? 0;
$loginStreak = $loginStreak ?? 0;
$hasClaimedToday = $hasClaimedToday ?? false;
$nextClaimCountdown = $nextClaimCountdown ?? '00:00:00';

// Calculate level and progress
$level = floor($xp / 100);
$currentXp = $xp % 100;
$xpPercent = min(100, ($currentXp / 100) * 100);

// Tasks with label and points
$tasks = [
    'daily_login' => ['label' => 'Claim Daily Login Reward', 'points' => 10, 'icon' => 'fa-calendar-check-o'],
    'submit_water_meter' => ['label' => 'Submit Water Meter Reading', 'points' => 15, 'icon' => 'fa-tachometer'],
    'upload_water_bill' => ['label' => 'Upload Water Bill Proof', 'points' => 20, 'icon' => 'fa-file-text-o'],
    'complete_profile' => ['label' => 'Complete Your Profile', 'points' => 15, 'icon' => 'fa-user-circle'],
];

$completedTasks = $completedTasks ?? [];
$activeQuests = $activeQuests ?? []; // ✅ GET ACTIVE QUESTS FROM CONTROLLER
?>

<!-- User Stats Header -->
<section class="user-header">
    <div class="container">
        <div class="user-stats">
            <div class="row text-center">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card">
                        <span class="stat-number"><?= number_format($ecopoints) ?></span>
                        <span class="stat-label">💧 EcoPoints</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card">
                        <span class="stat-number"><?= $level ?></span>
                        <span class="stat-label">🏆 Level</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card">
                        <span class="stat-number"><?= $loginStreak ?></span>
                        <span class="stat-label">🔥 Streak</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card">
                        <span class="stat-number"><?= isset($userRank) ? '#' . $userRank->rank : '#--' ?></span>
                        <span class="stat-label">📊 Rank</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<div class="dashboard-container">
    <div class="container">
        
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h1 class="h3 mb-2" style="color: var(--dark-blue);">Welcome back, <?= $username ?>! 👋</h1>
                                <p class="text-muted mb-0">Ready to make a difference for our planet today?</p>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-primary fs-6 px-3 py-2">
                                    <i class="fa fa-trophy"></i> Level <?= $level ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                
                <!-- XP Progress Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                        <h5 class="mb-0"><i class="fa fa-chart-line"></i> Your Progress</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p class="mb-2"><strong>Level <?= $level ?></strong> | XP: <?= $currentXp ?>/100</p>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                         role="progressbar" 
                                         style="width: <?= $xpPercent ?>%;" 
                                         aria-valuenow="<?= $xpPercent ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <?= round($xpPercent) ?>%
                                    </div>
                                </div>
                                <small class="text-muted">Next level in <?= 100 - $currentXp ?> XP</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="level-badge" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--success-green), #66bb6a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 1.5rem; font-weight: bold;">
                                    <?= $level ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Reward Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--warning-orange), #ffb74d);">
                        <h5 class="mb-0"><i class="fa fa-gift"></i> Daily Reward</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p class="mb-2">
                                    <strong>Login Streak: <?= $loginStreak ?> day(s)</strong> 🔥
                                </p>
                                <p class="mb-3">Next claim in: <span class="badge bg-info"><?= $nextClaimCountdown ?></span></p>
                                
                                <?php if ($hasClaimedToday): ?>
                                    <div class="alert alert-success d-flex align-items-center">
                                        <i class="fa fa-check-circle me-2"></i>
                                        <span>You've already claimed your daily reward today! Come back tomorrow for more EcoPoints.</span>
                                    </div>
                                <?php else: ?>
                                    <form method="post" action="<?= base_url('/user/claim-reward') ?>">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-warning btn-lg">
                                            <i class="fa fa-gift"></i> Claim Daily Reward (+10 EcoPoints)
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="reward-icon" style="font-size: 4rem; color: var(--warning-orange);">
                                    🎁
                                </div>
                            </div>
                        </div>

                        <?php if (session()->getFlashdata('claim_success')): ?>
                            <div class="alert alert-success mt-3">
                                <i class="fa fa-check-circle"></i> <?= session()->getFlashdata('claim_success') ?>
                            </div>
                        <?php elseif (session()->getFlashdata('claim_error')): ?>
                            <div class="alert alert-danger mt-3">
                                <i class="fa fa-exclamation-triangle"></i> <?= session()->getFlashdata('claim_error') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tasks Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--success-green), #66bb6a);">
                        <h5 class="mb-0"><i class="fa fa-tasks"></i> Ways to Earn EcoPoints</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $incompleteTasks = array_filter($tasks, function ($key) use ($completedTasks) {
                            return !in_array($key, $completedTasks);
                        }, ARRAY_FILTER_USE_KEY);
                        ?>

                        <?php if (empty($incompleteTasks)): ?>
                            <div class="text-center py-4">
                                <div style="font-size: 4rem; margin-bottom: 20px;">🎉</div>
                                <h4 style="color: var(--success-green);">All Tasks Completed!</h4>
                                <p class="text-muted">Great job saving water! Check back tomorrow for new challenges.</p>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($incompleteTasks as $taskKey => $task): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="task-card p-3 border rounded" style="background: linear-gradient(135deg, #f8f9fa, #ffffff); border-left: 4px solid var(--primary-blue) !important;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">
                                                        <i class="fa <?= $task['icon'] ?>" style="color: var(--primary-blue);"></i>
                                                        <?= esc($task['label']) ?>
                                                    </h6>
                                                    <small class="text-success">+<?= $task['points'] ?> EcoPoints</small>
                                                </div>
                                                <div class="ms-2">
                                                    <form method="post" action="<?= base_url('/user/complete-task') ?>" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="task_key" value="<?= esc($taskKey) ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-check"></i> Complete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                
                <!-- ✅ FIXED: Active Quest Section with Real Data -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--accent-blue), #29b6f6);">
                        <h5 class="mb-0"><i class="fa fa-crosshairs"></i> Active Quests</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($activeQuests)): ?>
                            <?php foreach ($activeQuests as $quest): ?>
                                <div class="active-quest-item border rounded p-3 mb-3" style="background: linear-gradient(135deg, #f8f9fa, #ffffff); border-left: 4px solid var(--primary-blue) !important;">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="quest-icon me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                                            <?php
                                            // Quest icons based on type
                                            $icons = [
                                                'daily' => '🚿',
                                                'weekly' => '🌧️',
                                                'special' => '🏆'
                                            ];
                                            echo $icons[$quest->type] ?? '🎯';
                                            ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?= esc($quest->title) ?></h6>
                                            <small class="text-muted">Started: <?= date('M j, Y', strtotime($quest->accepted_at)) ?></small>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-2"><?= esc($quest->description) ?></p>
                                    <div class="quest-rewards">
                                        <small class="text-success"><i class="fa fa-trophy"></i> +<?= $quest->ecopoints_reward ?> EcoPoints</small>
                                        <small class="text-info ms-2"><i class="fa fa-star"></i> +<?= $quest->xp_reward ?> XP</small>
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge bg-warning"><?= ucfirst($quest->type) ?> Quest</span>
                                        <span class="badge bg-info">In Progress</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="text-center">
                                <a href="<?= base_url('/user/quest') ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> Manage Quests
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <div class="quest-icon mb-3" style="font-size: 3rem; opacity: 0.5;">🎮</div>
                                <h6 class="text-muted">No Active Quests</h6>
                                <p class="text-muted small">Start a new quest to earn more rewards!</p>
                                <a href="<?= base_url('/user/quest') ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> Browse Quests
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue));">
                        <h5 class="mb-0"><i class="fa fa-chart-pie"></i> Quick Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-tint" style="color: var(--primary-blue);"></i> Water Saved</span>
                            <strong><?= number_format($ecopoints * 2) ?>L</strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-leaf" style="color: var(--success-green);"></i> CO₂ Reduced</span>
                            <strong><?= number_format($ecopoints * 0.5) ?>kg</strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-trophy" style="color: var(--warning-orange);"></i> Achievements</span>
                            <strong>3/12</strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-users" style="color: var(--accent-blue);"></i> Community Rank</span>
                            <strong><?= isset($userRank) ? '#' . $userRank->rank : '#--' ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard Preview -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--warning-orange), #ffb74d);">
                        <h5 class="mb-0"><i class="fa fa-trophy"></i> Top Water Savers</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($topUsers)): ?>
                            <?php foreach (array_slice($topUsers, 0, 5) as $i => $user): ?>
                                <div class="leaderboard-item d-flex align-items-center mb-2 p-2 rounded <?= $user->id === session()->get('id') ? 'bg-light border' : '' ?>">
                                    <div class="rank-badge me-3" style="width: 30px; height: 30px; background: <?= $i < 3 ? ['#ffd700', '#c0c0c0', '#cd7f32'][$i] : 'var(--medium-gray)' ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.8rem;">
                                        <?= $i + 1 ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold" style="font-size: 0.9rem;">
                                            <?= esc($user->username) ?><?= $user->id === session()->get('id') ? ' (You)' : '' ?>
                                        </div>
                                        <small class="text-muted"><?= number_format($user->ecopoints) ?> EcoPoints</small>
                                    </div>
                                    <?php if ($i < 3): ?>
                                        <div class="trophy-icon" style="color: <?= ['#ffd700', '#c0c0c0', '#cd7f32'][$i] ?>;">
                                            <i class="fa fa-trophy"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            <div class="text-center mt-3">
                                <a href="<?= base_url('/user/leaderboard') ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-list"></i> View Full Leaderboard
                                </a>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center">No leaderboard data available.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Additional Dashboard Styles */
.task-card {
    transition: all 0.3s ease;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.leaderboard-item {
    transition: all 0.3s ease;
}

.leaderboard-item:hover {
    background-color: #f8f9fa !important;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.progress-bar-animated {
    animation: progress-bar-stripes 1s linear infinite;
}

@keyframes progress-bar-stripes {
    0% { background-position: 1rem 0; }
    100% { background-position: 0 0; }
}

.bg-gradient {
    background-image: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
}

/* ✅ Active Quest Styling */
.active-quest-item {
    transition: all 0.3s ease;
}

.active-quest-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.quest-icon {
    transition: all 0.3s ease;
}

.active-quest-item:hover .quest-icon {
    transform: scale(1.1);
}

/* Fix for larger screens */
@media (min-width: 1200px) {
    .dashboard-container {
        max-width: 1400px;
        padding: 30px;
    }
    
    .container {
        max-width: 1320px;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .stat-card {
        padding: 25px;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 15px 40px;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .stat-card {
        padding: 15px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}
</style>

<?= $this->include('layout/footer') ?>