<?= $this->include('layout/header') ?>

<?php
if (!session()->has('userlevel') || session()->get('userlevel') !== 'user') {
    die('Access denied');
}

$session = session();
$username = esc($session->get('username'));
?>

<div class="dashboard-container">
    <div class="container">
        
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h1 class="h3 mb-2" style="color: var(--dark-blue);">
                                    <i class="fa fa-trophy"></i> Water Conservation Leaderboard
                                </h1>
                                <p class="text-muted mb-0">See how you rank among other water conservation champions</p>
                            </div>
                            <div class="text-end">
                                <a href="<?= base_url('/user') ?>" class="btn btn-outline-primary">
                                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 3 Podium -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--warning-orange), #ffb74d);">
                        <h5 class="mb-0"><i class="fa fa-crown"></i> Top 3 Champions</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row text-center">
                            <?php if (!empty($topUsers)): ?>
                                <!-- 2nd Place -->
                                <?php if (isset($topUsers[1])): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="podium-card" style="background: linear-gradient(135deg, #e8e8e8, #ffffff); border-radius: 15px; padding: 30px; position: relative;">
                                        <div class="podium-rank" style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #c0c0c0; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem;">2</div>
                                        <div class="podium-avatar mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #c0c0c0, #e8e8e8); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; font-weight: bold;">
                                            <?= strtoupper(substr($topUsers[1]->username, 0, 1)) ?>
                                        </div>
                                        <h5 class="mb-2"><?= esc($topUsers[1]->username) ?></h5>
                                        <p class="text-muted mb-2"><?= number_format($topUsers[1]->ecopoints) ?> EcoPoints</p>
                                        <div class="trophy-icon" style="color: #c0c0c0; font-size: 2rem;">🥈</div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- 1st Place -->
                                <?php if (isset($topUsers[0])): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="podium-card" style="background: linear-gradient(135deg, #ffd700, #ffffff); border-radius: 15px; padding: 40px; position: relative; transform: scale(1.1);">
                                        <div class="podium-rank" style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: #ffd700; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.5rem;">1</div>
                                        <div class="podium-avatar mb-3" style="width: 100px; height: 100px; background: linear-gradient(135deg, #ffd700, #ffed4e); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2.5rem; font-weight: bold;">
                                            <?= strtoupper(substr($topUsers[0]->username, 0, 1)) ?>
                                        </div>
                                        <h4 class="mb-2"><?= esc($topUsers[0]->username) ?></h4>
                                        <p class="text-muted mb-2"><?= number_format($topUsers[0]->ecopoints) ?> EcoPoints</p>
                                        <div class="trophy-icon" style="color: #ffd700; font-size: 3rem;">👑</div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- 3rd Place -->
                                <?php if (isset($topUsers[2])): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="podium-card" style="background: linear-gradient(135deg, #cd7f32, #ffffff); border-radius: 15px; padding: 30px; position: relative;">
                                        <div class="podium-rank" style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #cd7f32; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem;">3</div>
                                        <div class="podium-avatar mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #cd7f32, #deb887); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; font-weight: bold;">
                                            <?= strtoupper(substr($topUsers[2]->username, 0, 1)) ?>
                                        </div>
                                        <h5 class="mb-2"><?= esc($topUsers[2]->username) ?></h5>
                                        <p class="text-muted mb-2"><?= number_format($topUsers[2]->ecopoints) ?> EcoPoints</p>
                                        <div class="trophy-icon" style="color: #cd7f32; font-size: 2rem;">🥉</div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Full Leaderboard -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                        <h5 class="mb-0"><i class="fa fa-list"></i> Full Leaderboard</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th class="px-4 py-3">Rank</th>
                                        <th class="py-3">User</th>
                                        <th class="py-3">EcoPoints</th>
                                        <th class="py-3">Badge</th>
                                        <th class="py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($topUsers)): ?>
                                        <?php foreach ($topUsers as $i => $user): ?>
                                            <tr class="<?= $user->id === session()->get('id') ? 'table-primary' : '' ?>" style="<?= $user->id === session()->get('id') ? 'background-color: rgba(0, 119, 190, 0.1) !important;' : '' ?>">
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rank-badge me-2" style="width: 35px; height: 35px; background: <?= $i < 3 ? ['#ffd700', '#c0c0c0', '#cd7f32'][$i] : 'var(--medium-gray)' ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                            <?= $i + 1 ?>
                                                        </div>
                                                        <?php if ($i < 3): ?>
                                                            <span style="color: <?= ['#ffd700', '#c0c0c0', '#cd7f32'][$i] ?>; font-size: 1.2rem;">
                                                                <?= ['👑', '🥈', '🥉'][$i] ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                            <?= strtoupper(substr($user->username, 0, 1)) ?>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">
                                                                <?= esc($user->username) ?>
                                                                <?= $user->id === session()->get('id') ? '<span class="badge bg-primary ms-2">You</span>' : '' ?>
                                                            </div>
                                                            <small class="text-muted">Water Champion</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="fw-bold text-success"><?= number_format($user->ecopoints) ?></div>
                                                    <small class="text-muted">EcoPoints</small>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge bg-info"><?= esc($user->badge) ?></span>
                                                </td>
                                                <td class="py-3">
                                                    <?php if ($i < 3): ?>
                                                        <span class="badge bg-warning">Top 3</span>
                                                    <?php elseif ($i < 10): ?>
                                                        <span class="badge bg-success">Top 10</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Active</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <!-- Show current user if not in top 10 -->
                                        <?php if (isset($userRank) && $userRank->rank > 10): ?>
                                            <tr style="border-top: 3px solid var(--primary-blue);">
                                                <td colspan="5" class="text-center py-2">
                                                    <small class="text-muted">...</small>
                                                </td>
                                            </tr>
                                            <tr class="table-primary" style="background-color: rgba(0, 119, 190, 0.1) !important;">
                                                <td class="px-4 py-3">
                                                    <div class="rank-badge" style="width: 35px; height: 35px; background: var(--primary-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                        <?= $userRank->rank ?>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                            <?= strtoupper(substr($userData->username, 0, 1)) ?>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">
                                                                <?= esc($userData->username) ?>
                                                                <span class="badge bg-primary ms-2">You</span>
                                                            </div>
                                                            <small class="text-muted">Water Champion</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="fw-bold text-success"><?= number_format($userData->ecopoints) ?></div>
                                                    <small class="text-muted">EcoPoints</small>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge bg-info"><?= esc($userData->badge) ?></span>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge bg-primary">Your Rank</span>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;">🏆</div>
                                                <h5 class="text-muted">No leaderboard data available</h5>
                                                <p class="text-muted">Start earning EcoPoints to appear on the leaderboard!</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                
                <!-- Your Rank Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--success-green), #66bb6a);">
                        <h5 class="mb-0"><i class="fa fa-user"></i> Your Ranking</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="rank-display mb-3" style="font-size: 3rem; color: var(--primary-blue); font-weight: bold;">
                            #<?= isset($userRank) ? $userRank->rank : '--' ?>
                        </div>
                        <h5 class="mb-2"><?= esc($username) ?></h5>
                        <p class="text-muted mb-3"><?= isset($userData) ? number_format($userData->ecopoints) : '0' ?> EcoPoints</p>
                        
                        <?php if (isset($userRank)): ?>
                            <?php if ($userRank->rank <= 3): ?>
                                <div class="achievement-badge mb-3" style="color: #ffd700; font-size: 2rem;">👑</div>
                                <p class="text-success"><strong>Amazing! You're in the top 3!</strong></p>
                            <?php elseif ($userRank->rank <= 10): ?>
                                <div class="achievement-badge mb-3" style="color: var(--success-green); font-size: 2rem;">🏆</div>
                                <p class="text-success"><strong>Great! You're in the top 10!</strong></p>
                            <?php else: ?>
                                <div class="achievement-badge mb-3" style="color: var(--primary-blue); font-size: 2rem;">💪</div>
                                <p class="text-primary"><strong>Keep going! You can climb higher!</strong></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <a href="<?= base_url('/user/quest') ?>" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Earn More Points
                        </a>
                    </div>
                </div>

                <!-- Leaderboard Tips -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--warning-orange), #ffb74d);">
                        <h5 class="mb-0"><i class="fa fa-lightbulb-o"></i> Climbing Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--success-green);">💧</div>
                                <div>
                                    <small><strong>Daily Login:</strong> Claim your daily rewards consistently for bonus points.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--primary-blue);">🎯</div>
                                <div>
                                    <small><strong>Complete Quests:</strong> Finish water conservation quests for big point rewards.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--accent-blue);">🏆</div>
                                <div>
                                    <small><strong>Achievements:</strong> Unlock achievements to earn bonus EcoPoints.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--warning-orange);">📊</div>
                                <div>
                                    <small><strong>Track Usage:</strong> Regular water usage tracking gives steady points.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard Stats -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue));">
                        <h5 class="mb-0"><i class="fa fa-chart-bar"></i> Leaderboard Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-users" style="color: var(--primary-blue);"></i> Total Users</span>
                            <strong><?= isset($topUsers) ? count($topUsers) : '0' ?></strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-trophy" style="color: var(--warning-orange);"></i> Top Score</span>
                            <strong><?= isset($topUsers[0]) ? number_format($topUsers[0]->ecopoints) : '0' ?></strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-leaf" style="color: var(--success-green);"></i> Avg. Points</span>
                            <strong><?= isset($topUsers) && count($topUsers) > 0 ? number_format(array_sum(array_column($topUsers, 'ecopoints')) / count($topUsers)) : '0' ?></strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-clock-o" style="color: var(--accent-blue);"></i> Updated</span>
                            <strong>Real-time</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Leaderboard Specific Styles */
.podium-card {
    transition: all 0.3s ease;
}

.podium-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.rank-badge {
    transition: all 0.3s ease;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 119, 190, 0.05) !important;
}

.tip-item {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.tip-item:last-child {
    border-bottom: none;
}

@media (max-width: 768px) {
    .podium-card {
        transform: none !important;
        margin-bottom: 20px;
    }
    
    .rank-display {
        font-size: 2rem !important;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>

<?= $this->include('layout/footer') ?>