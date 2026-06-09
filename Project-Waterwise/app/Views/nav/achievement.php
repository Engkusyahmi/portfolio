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
                                    <i class="fa fa-trophy"></i> Achievements & Badges
                                </h1>
                                <p class="text-muted mb-0">Unlock achievements by completing water conservation milestones</p>
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

        <!-- Achievement Progress Overview -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="achievement-stat-icon mb-2" style="font-size: 2.5rem; color: var(--success-green);">🏆</div>
                        <h4 class="mb-1">3</h4>
                        <small class="text-muted">Unlocked</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="achievement-stat-icon mb-2" style="font-size: 2.5rem; color: var(--warning-orange);">🔒</div>
                        <h4 class="mb-1">9</h4>
                        <small class="text-muted">Locked</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="achievement-stat-icon mb-2" style="font-size: 2.5rem; color: var(--primary-blue);">📊</div>
                        <h4 class="mb-1">25%</h4>
                        <small class="text-muted">Progress</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="achievement-stat-icon mb-2" style="font-size: 2.5rem; color: var(--accent-blue);">⭐</div>
                        <h4 class="mb-1">150</h4>
                        <small class="text-muted">Points Earned</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievement Categories -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                        <h5 class="mb-0"><i class="fa fa-filter"></i> Achievement Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded active" data-category="all" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">🏆</div>
                                    <small class="fw-bold">All</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="beginner" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">🌱</div>
                                    <small class="fw-bold">Beginner</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="conservation" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">💧</div>
                                    <small class="fw-bold">Conservation</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="community" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">👥</div>
                                    <small class="fw-bold">Community</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="expert" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">🎯</div>
                                    <small class="fw-bold">Expert</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6 mb-3">
                                <div class="category-filter text-center p-3 border rounded" data-category="special" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2rem;">⭐</div>
                                    <small class="fw-bold">Special</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements Grid -->
        <div class="row">
            
            <!-- Unlocked Achievement 1 -->
            <div class="col-lg-4 col-md-6 mb-4" data-category="beginner">
                <div class="achievement-card card border-0 shadow-sm unlocked" style="background: linear-gradient(135deg, #e8f5e8, #ffffff); border-left: 4px solid var(--success-green) !important;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--success-green), #66bb6a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            🌱
                            <div class="unlock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: var(--warning-orange); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</div>
                        </div>
                        <h5 class="mb-2" style="color: var(--dark-blue);">First Drop</h5>
                        <p class="text-muted small mb-3">Complete your first water conservation action</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-success me-1">+50 EcoPoints</span>
                            <span class="badge bg-info">+25 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-success"><i class="fa fa-check-circle"></i> Unlocked on Jan 15, 2025</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unlocked Achievement 2 -->
            <div class="col-lg-4 col-md-6 mb-4" data-category="conservation">
                <div class="achievement-card card border-0 shadow-sm unlocked" style="background: linear-gradient(135deg, #e3f2fd, #ffffff); border-left: 4px solid var(--primary-blue) !important;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            🚿
                            <div class="unlock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: var(--warning-orange); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</div>
                        </div>
                        <h5 class="mb-2" style="color: var(--dark-blue);">Shower Saver</h5>
                        <p class="text-muted small mb-3">Take 5 showers under 5 minutes each</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-success me-1">+100 EcoPoints</span>
                            <span class="badge bg-info">+50 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-primary"><i class="fa fa-check-circle"></i> Unlocked on Jan 18, 2025</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unlocked Achievement 3 -->
            <div class="col-lg-4 col-md-6 mb-4" data-category="beginner">
                <div class="achievement-card card border-0 shadow-sm unlocked" style="background: linear-gradient(135deg, #fff3e0, #ffffff); border-left: 4px solid var(--warning-orange) !important;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--warning-orange), #ffb74d); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            📅
                            <div class="unlock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: var(--warning-orange); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</div>
                        </div>
                        <h5 class="mb-2" style="color: var(--dark-blue);">Week Warrior</h5>
                        <p class="text-muted small mb-3">Log in for 7 consecutive days</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-success me-1">+75 EcoPoints</span>
                            <span class="badge bg-info">+35 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-warning"><i class="fa fa-check-circle"></i> Unlocked on Jan 22, 2025</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Locked Achievement 1 -->
            <div class="col-lg-4 col-md-6 mb-4" data-category="conservation">
                <div class="achievement-card card border-0 shadow-sm locked" style="background: linear-gradient(135deg, #f5f5f5, #ffffff); border-left: 4px solid #cccccc !important; opacity: 0.7;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: #cccccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            🔧
                            <div class="lock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: #666; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">🔒</div>
                        </div>
                        <h5 class="mb-2" style="color: #666;">Leak Detective</h5>
                        <p class="text-muted small mb-3">Find and fix 3 water leaks in your home</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-secondary me-1">+200 EcoPoints</span>
                            <span class="badge bg-secondary">+100 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted"><i class="fa fa-lock"></i> Progress: 1/3 leaks fixed</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Locked Achievement 2 -->
            <div class="col-lg-4 col-md-6 mb-4" data-category="community">
                <div class="achievement-card card border-0 shadow-sm locked" style="background: linear-gradient(135deg, #f5f5f5, #ffffff); border-left: 4px solid #cccccc !important; opacity: 0.7;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: #cccccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            👥
                            <div class="lock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: #666; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">🔒</div>
                        </div>
                        <h5 class="mb-2" style="color: #666;">Community Leader</h5>
                        <p class="text-muted small mb-3">Invite 5 friends to join WaterWise</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-secondary me-1">+300 EcoPoints</span>
                            <span class="badge bg-secondary">+150 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted"><i class="fa fa-lock"></i> Progress: 0/5 friends invited</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Locked Achievement 3 -->
            <div class="col-lg-4 col-md-6 mb-4" data-category="expert">
                <div class="achievement-card card border-0 shadow-sm locked" style="background: linear-gradient(135deg, #f5f5f5, #ffffff); border-left: 4px solid #cccccc !important; opacity: 0.7;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: #cccccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            🌧️
                            <div class="lock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: #666; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">🔒</div>
                        </div>
                        <h5 class="mb-2" style="color: #666;">Rain Harvester</h5>
                        <p class="text-muted small mb-3">Set up a rainwater collection system</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-secondary me-1">+250 EcoPoints</span>
                            <span class="badge bg-secondary">+125 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted"><i class="fa fa-lock"></i> Requirements not met</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- More locked achievements... -->
            <div class="col-lg-4 col-md-6 mb-4" data-category="special">
                <div class="achievement-card card border-0 shadow-sm locked" style="background: linear-gradient(135deg, #f5f5f5, #ffffff); border-left: 4px solid #cccccc !important; opacity: 0.7;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: #cccccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            🏆
                            <div class="lock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: #666; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">🔒</div>
                        </div>
                        <h5 class="mb-2" style="color: #666;">Water Champion</h5>
                        <p class="text-muted small mb-3">Reach the top 10 on the leaderboard</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-secondary me-1">+500 EcoPoints</span>
                            <span class="badge bg-secondary">+250 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted"><i class="fa fa-lock"></i> Current rank: #67</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-category="conservation">
                <div class="achievement-card card border-0 shadow-sm locked" style="background: linear-gradient(135deg, #f5f5f5, #ffffff); border-left: 4px solid #cccccc !important; opacity: 0.7;">
                    <div class="card-body text-center p-4">
                        <div class="achievement-badge mb-3" style="width: 80px; height: 80px; background: #cccccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 2rem; position: relative;">
                            📊
                            <div class="lock-indicator" style="position: absolute; top: -5px; right: -5px; width: 25px; height: 25px; background: #666; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">🔒</div>
                        </div>
                        <h5 class="mb-2" style="color: #666;">Data Tracker</h5>
                        <p class="text-muted small mb-3">Log water usage for 30 consecutive days</p>
                        <div class="achievement-rewards mb-3">
                            <span class="badge bg-secondary me-1">+400 EcoPoints</span>
                            <span class="badge bg-secondary">+200 XP</span>
                        </div>
                        <div class="achievement-progress">
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 23%;" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted"><i class="fa fa-lock"></i> Progress: 7/30 days</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Achievement Page Specific Styles */
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

.achievement-card {
    transition: all 0.3s ease;
    height: 100%;
}

.achievement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.achievement-card.unlocked:hover {
    transform: translateY(-8px);
}

.achievement-card.locked {
    cursor: not-allowed;
}

.achievement-badge {
    transition: all 0.3s ease;
}

.achievement-card:hover .achievement-badge {
    transform: scale(1.1);
}

.unlock-indicator {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

@media (max-width: 768px) {
    .achievement-card .card-body {
        padding: 1.5rem !important;
    }
    
    .achievement-badge {
        width: 60px !important;
        height: 60px !important;
        font-size: 1.5rem !important;
    }
    
    .category-filter {
        margin-bottom: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filtering
    const categoryFilters = document.querySelectorAll('.category-filter');
    const achievementCards = document.querySelectorAll('.achievement-card');
    
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            categoryFilters.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            this.classList.add('active');
            
            const category = this.getAttribute('data-category');
            
            // Show/hide achievement cards based on category
            achievementCards.forEach(card => {
                const cardCategory = card.closest('[data-category]').getAttribute('data-category');
                
                if (category === 'all' || cardCategory === category) {
                    card.closest('.col-lg-4').style.display = 'block';
                } else {
                    card.closest('.col-lg-4').style.display = 'none';
                }
            });
        });
    });
});
</script>

<?= $this->include('layout/footer') ?>