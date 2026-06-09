<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">
            <i class="fas fa-chart-line text-primary me-2"></i>
            Dashboard Overview
        </h2>
        <p class="text-muted">Welcome to the WaterSaver Admin Panel</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-3"></i>
                <h3 class="mb-1"><?= $totalUsers ?></h3>
                <p class="mb-0">Total Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card-success">
            <div class="card-body text-center">
                <i class="fas fa-trophy fa-2x mb-3"></i>
                <h3 class="mb-1"><?= $totalAchievements ?></h3>
                <p class="mb-0">Achievements</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card-warning">
            <div class="card-body text-center">
                <i class="fas fa-gift fa-2x mb-3"></i>
                <h3 class="mb-1"><?= $totalRewards ?></h3>
                <p class="mb-0">Rewards</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card-info">
            <div class="card-body text-center">
                <i class="fas fa-tasks fa-2x mb-3"></i>
                <h3 class="mb-1"><?= $totalQuests ?></h3>
                <p class="mb-0">Quests</p>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-user-shield fa-2x text-primary mb-3"></i>
                <h4 class="mb-1"><?= $totalAdmins ?></h4>
                <p class="text-muted mb-0">Total Admins</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-calendar-day fa-2x text-success mb-3"></i>
                <h4 class="mb-1"><?= $todayLogins ?></h4>
                <p class="text-muted mb-0">Today's Logins</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-info mb-3"></i>
                <h4 class="mb-1"><?= date('H:i') ?></h4>
                <p class="text-muted mb-0">Current Time</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users and Top Users -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>
                    Recent Users
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recentUsers)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentUsers as $user): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= esc($user->fullname) ?></strong>
                                    <br>
                                    <small class="text-muted">@<?= esc($user->username) ?></small>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    <?= esc($user->ecopoints) ?> EP
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No users found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-crown me-2"></i>
                    Top Users by EcoPoints
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($topUsers)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($topUsers as $index => $user): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-warning text-dark me-2">#<?= $index + 1 ?></span>
                                    <strong><?= esc($user->fullname) ?></strong>
                                    <br>
                                    <small class="text-muted">Streak: <?= esc($user->login_streak) ?> days</small>
                                </div>
                                <span class="badge bg-success rounded-pill">
                                    <?= esc($user->ecopoints) ?> EP
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No users found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('/admin/add-user') ?>" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Add User
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('/admin/add-achievement') ?>" class="btn btn-success w-100">
                            <i class="fas fa-trophy me-2"></i>Add Achievement
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('/admin/add-reward') ?>" class="btn btn-warning w-100">
                            <i class="fas fa-gift me-2"></i>Add Reward
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('/admin/add-quest') ?>" class="btn btn-info w-100">
                            <i class="fas fa-tasks me-2"></i>Add Quest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>
