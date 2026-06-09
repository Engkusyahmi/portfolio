<?= $this->include('layout/header') ?>

<?php
if (!session()->has('userlevel') || session()->get('userlevel') !== 'user') {
    die('Access denied');
}

$session = session();
$username = esc($session->get('username'));
$ecopoints = $userData->ecopoints ?? 0;
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
                                    🏆 Reward Store
                                </h1>
                                <p class="text-muted mb-0">Redeem your EcoPoints for amazing rewards and make a real impact</p>
                            </div>
                            <div class="text-end">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="ecopoints-display bg-success text-white px-4 py-2 rounded-pill">
                                        <i class="fa fa-leaf"></i> <?= number_format($ecopoints) ?> EcoPoints
                                    </div>
                                    <a href="<?= base_url('/user') ?>" class="btn btn-outline-primary">
                                        <i class="fa fa-arrow-left"></i> Back to Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Reward Categories -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                        <h5 class="mb-0"><i class="fa fa-tags"></i> Reward Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded active" data-category="all" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">🎁</div>
                                    <small class="fw-bold">All Rewards</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="avatar" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">👤</div>
                                    <small class="fw-bold">Avatars</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="badge" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">🏆</div>
                                    <small class="fw-bold">Badges</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="booster" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">⚡</div>
                                    <small class="fw-bold">Boosters</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="theme" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">🎨</div>
                                    <small class="fw-bold">Themes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Rewards Grid -->
            <div class="col-lg-9">
                <div class="row" id="rewards-grid">
                    
                    <?php if (!empty($rewards)): ?>
                        <?php foreach ($rewards as $reward): ?>
                            <div class="col-lg-4 col-md-6 mb-4 reward-item" data-category="<?= esc($reward->type) ?>">
                                <div class="reward-card card border-0 shadow-sm h-100" style="transition: all 0.3s ease;">
                                    <div class="reward-image" style="height: 200px; background: linear-gradient(135deg, <?= getTypeGradient($reward->type) ?>); display: flex; align-items: center; justify-content: center; font-size: 4rem; border-radius: 8px 8px 0 0;">
                                        <?= getTypeIcon($reward->type) ?>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="reward-category mb-2">
                                            <span class="badge <?= getTypeBadgeClass($reward->type) ?>"><?= ucfirst($reward->type) ?></span>
                                            <?php if (in_array($reward->id, $redeemedIds)): ?>
                                                <span class="badge bg-success ms-1">Owned</span>
                                            <?php endif; ?>
                                        </div>
                                        <h6 class="card-title mb-2"><?= esc($reward->name) ?></h6>
                                        <p class="card-text text-muted small flex-grow-1"><?= esc($reward->description) ?></p>
                                        <div class="reward-cost mb-3">
                                            <span class="h5 <?= getTypeTextClass($reward->type) ?> mb-0">
                                                <i class="fa fa-leaf"></i> <?= number_format($reward->cost_ecopoints) ?> EcoPoints
                                            </span>
                                        </div>
                                        
                                        <?php if (in_array($reward->id, $redeemedIds)): ?>
                                            <button class="btn btn-success btn-sm" disabled>
                                                <i class="fa fa-check"></i> Already Owned
                                            </button>
                                        <?php elseif ($ecopoints >= $reward->cost_ecopoints): ?>
                                            <form method="post" action="<?= base_url('/user/redeemReward') ?>" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="reward_id" value="<?= $reward->id ?>">
                                                <button type="submit" class="btn <?= getTypeButtonClass($reward->type) ?> btn-sm" 
                                                        onclick="return confirm('Are you sure you want to redeem <?= esc($reward->name) ?> for <?= number_format($reward->cost_ecopoints) ?> EcoPoints?')">
                                                    <i class="fa fa-shopping-cart"></i> Redeem Now
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fa fa-lock"></i> Insufficient Points
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <div style="font-size: 4rem; opacity: 0.5; margin-bottom: 20px;">🎁</div>
                            <h4 class="text-muted">No Rewards Available</h4>
                            <p class="text-muted">Check back later for new rewards!</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                
                <!-- Your EcoPoints -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--success-green), #66bb6a);">
                        <h5 class="mb-0"><i class="fa fa-leaf"></i> Your EcoPoints</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="ecopoints-display mb-3" style="font-size: 2.5rem; color: var(--success-green); font-weight: bold;">
                            <?= number_format($ecopoints) ?>
                        </div>
                        <p class="text-muted small mb-3">Available for redemption</p>
                        <div class="earning-tip p-3 rounded" style="background: linear-gradient(135deg, #e8f5e8, #ffffff);">
                            <small class="text-success">
                                <i class="fa fa-lightbulb-o"></i> 
                                <strong>Tip:</strong> Complete daily quests to earn more EcoPoints!
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Recent Redemptions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                        <h5 class="mb-0"><i class="fa fa-history"></i> Recent Redemptions</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($redeemedIds)): ?>
                            <?php 
                            $recentRewards = array_filter($rewards, function($reward) use ($redeemedIds) {
                                return in_array($reward->id, $redeemedIds);
                            });
                            $recentRewards = array_slice($recentRewards, 0, 3);
                            ?>
                            <?php foreach ($recentRewards as $reward): ?>
                                <div class="d-flex align-items-center mb-2 p-2 bg-light rounded">
                                    <div class="reward-mini-icon me-2" style="font-size: 1.5rem;">
                                        <?= getTypeIcon($reward->type) ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="fw-bold"><?= esc($reward->name) ?></small>
                                        <br>
                                        <small class="text-muted"><?= number_format($reward->cost_ecopoints) ?> EcoPoints</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <div style="font-size: 3rem; opacity: 0.5; margin-bottom: 15px;">📦</div>
                                <h6 class="text-muted">No Redemptions Yet</h6>
                                <p class="text-muted small">Your redeemed rewards will appear here.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Reward Tips -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--warning-orange), #ffb74d);">
                        <h5 class="mb-0"><i class="fa fa-lightbulb-o"></i> Reward Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--success-green);">💡</div>
                                <div>
                                    <small><strong>Save Up:</strong> Premium rewards offer better value for your EcoPoints.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--primary-blue);">🎯</div>
                                <div>
                                    <small><strong>Set Goals:</strong> Choose a reward and work towards earning enough points.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--accent-blue);">❤️</div>
                                <div>
                                    <small><strong>Check Daily:</strong> New rewards are added regularly!</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--warning-orange);">⏰</div>
                                <div>
                                    <small><strong>Limited Time:</strong> Some rewards may have limited availability.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
// Helper functions for reward display
function getTypeGradient($type) {
    switch ($type) {
        case 'avatar': return '#e8f5e8, #c8e6c9';
        case 'badge': return '#fff3e0, #ffcc02';
        case 'booster': return '#e3f2fd, #bbdefb';
        case 'theme': return '#fce4ec, #f8bbd9';
        default: return '#f5f5f5, #ffffff';
    }
}

function getTypeIcon($type) {
    switch ($type) {
        case 'avatar': return '👤';
        case 'badge': return '🏆';
        case 'booster': return '⚡';
        case 'theme': return '🎨';
        default: return '🎁';
    }
}

function getTypeBadgeClass($type) {
    switch ($type) {
        case 'avatar': return 'bg-success';
        case 'badge': return 'bg-warning';
        case 'booster': return 'bg-primary';
        case 'theme': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

function getTypeTextClass($type) {
    switch ($type) {
        case 'avatar': return 'text-success';
        case 'badge': return 'text-warning';
        case 'booster': return 'text-primary';
        case 'theme': return 'text-danger';
        default: return 'text-secondary';
    }
}

function getTypeButtonClass($type) {
    switch ($type) {
        case 'avatar': return 'btn-success';
        case 'badge': return 'btn-warning';
        case 'booster': return 'btn-primary';
        case 'theme': return 'btn-danger';
        default: return 'btn-secondary';
    }
}
?>

<style>
/* Reward Store Specific Styles */
.category-filter {
    transition: all 0.3s ease;
}

.category-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
    color: white !important;
}

.category-filter.active {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
    color: white !important;
    border-color: var(--primary-blue) !important;
}

.reward-card {
    transition: all 0.3s ease;
}

.reward-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.reward-image {
    transition: all 0.3s ease;
}

.reward-card:hover .reward-image {
    transform: scale(1.05);
}

.ecopoints-display {
    background: linear-gradient(135deg, var(--success-green), #66bb6a);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmer 2s ease-in-out infinite alternate;
}

@keyframes shimmer {
    0% { opacity: 1; }
    100% { opacity: 0.7; }
}

.tip-item {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.tip-item:last-child {
    border-bottom: none;
}

@media (max-width: 768px) {
    .reward-card .card-body {
        padding: 1rem !important;
    }
    
    .reward-image {
        height: 150px !important;
        font-size: 3rem !important;
    }
    
    .category-filter {
        margin-bottom: 10px;
    }
    
    .ecopoints-display {
        font-size: 1.5rem !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filtering
    const categoryFilters = document.querySelectorAll('.category-filter');
    const rewardItems = document.querySelectorAll('.reward-item');
    
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            categoryFilters.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            this.classList.add('active');
            
            const selectedCategory = this.getAttribute('data-category');
            
            // Show/hide reward items based on selected category
            rewardItems.forEach(item => {
                if (selectedCategory === 'all' || item.getAttribute('data-category') === selectedCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?= $this->include('layout/footer') ?>