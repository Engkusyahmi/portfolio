<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">
            <i class="fas fa-chart-bar text-primary me-2"></i>
            System Statistics
        </h2>
        <p class="text-muted">Detailed analytics and system performance</p>
    </div>
</div>

<!-- User Statistics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    User Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <h3 class="text-primary"><?= number_format($userStats['total_users']) ?></h3>
                        <p class="text-muted">Total Users</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h3 class="text-success"><?= number_format($userStats['active_today']) ?></h3>
                        <p class="text-muted">Active Today</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h3 class="text-warning"><?= number_format($userStats['total_ecopoints']) ?></h3>
                        <p class="text-muted">Total EcoPoints</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h3 class="text-info"><?= number_format($userStats['avg_login_streak'], 1) ?></h3>
                        <p class="text-muted">Avg Login Streak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Achievement Statistics -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-trophy me-2"></i>
                    Achievement Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h4 class="text-success"><?= number_format($achievementStats['total_achievements']) ?></h4>
                        <p class="text-muted">Total Achievements</p>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-info"><?= number_format($achievementStats['total_unlocked']) ?></h4>
                        <p class="text-muted">Total Unlocked</p>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-4">
                        <span class="badge bg-dark fs-6"><?= $achievementStats['bronze_count'] ?></span>
                        <p class="text-muted small">Bronze</p>
                    </div>
                    <div class="col-4">
                        <span class="badge bg-secondary fs-6"><?= $achievementStats['silver_count'] ?></span>
                        <p class="text-muted small">Silver</p>
                    </div>
                    <div class="col-4">
                        <span class="badge bg-warning fs-6"><?= $achievementStats['gold_count'] ?></span>
                        <p class="text-muted small">Gold</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reward Statistics -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <i class="fas fa-gift me-2"></i>
                    Reward Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4 mb-3">
                        <h4 class="text-warning"><?= number_format($rewardStats['total_rewards']) ?></h4>
                        <p class="text-muted">Total Rewards</p>
                    </div>
                    <div class="col-4 mb-3">
                        <h4 class="text-success"><?= number_format($rewardStats['available_rewards']) ?></h4>
                        <p class="text-muted">Available</p>
                    </div>
                    <div class="col-4 mb-3">
                        <h4 class="text-info"><?= number_format($rewardStats['total_redeemed']) ?></h4>
                        <p class="text-muted">Redeemed</p>
                    </div>
                </div>
                <?php if ($rewardStats['total_rewards'] > 0): ?>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: <?= ($rewardStats['total_redeemed'] / $rewardStats['total_rewards']) * 100 ?>%">
                            <?= number_format(($rewardStats['total_redeemed'] / $rewardStats['total_rewards']) * 100, 1) ?>% Redemption Rate
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quest Statistics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    Quest Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3 class="text-info"><?= number_format($questStats['total_quests']) ?></h3>
                        <p class="text-muted">Total Quests</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-primary"><?= number_format($questStats['accepted_quests']) ?></h3>
                        <p class="text-muted">Accepted Quests</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-success"><?= number_format($questStats['completed_quests']) ?></h3>
                        <p class="text-muted">Completed Quests</p>
                    </div>
                </div>
                <?php if ($questStats['accepted_quests'] > 0): ?>
                    <hr>
                    <div class="text-center">
                        <h5>Quest Completion Rate</h5>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: <?= ($questStats['completed_quests'] / $questStats['accepted_quests']) * 100 ?>%">
                                <?= number_format(($questStats['completed_quests'] / $questStats['accepted_quests']) * 100, 1) ?>%
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- System Information -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-server me-2"></i>
                    System Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <i class="fas fa-calendar fa-2x text-primary mb-2"></i>
                        <h6>Current Date</h6>
                        <p class="text-muted"><?= date('M j, Y') ?></p>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fas fa-clock fa-2x text-success mb-2"></i>
                        <h6>Current Time</h6>
                        <p class="text-muted"><?= date('H:i:s') ?></p>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fas fa-code fa-2x text-warning mb-2"></i>
                        <h6>Framework</h6>
                        <p class="text-muted">CodeIgniter 4</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fas fa-database fa-2x text-info mb-2"></i>
                        <h6>Database</h6>
                        <p class="text-muted">MySQL</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>