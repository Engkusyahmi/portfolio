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
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h1 class="h3 mb-2" style="color: var(--dark-blue);">
                                    <i class="fa fa-crosshairs"></i> Water Conservation Quests
                                </h1>
                                <p class="text-muted mb-0">Complete quests to earn EcoPoints and help save our planet's water resources</p>
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

        <!-- Quest Categories -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                        <h5 class="mb-0"><i class="fa fa-filter"></i> Quest Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="category-card text-center p-3 border rounded" style="background: linear-gradient(135deg, #e3f2fd, #ffffff); cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2.5rem;">🏠</div>
                                    <h6 class="mb-1">Home Conservation</h6>
                                    <small class="text-muted">Indoor water saving</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="category-card text-center p-3 border rounded" style="background: linear-gradient(135deg, #e8f5e8, #ffffff); cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2.5rem;">🌱</div>
                                    <h6 class="mb-1">Garden & Outdoor</h6>
                                    <small class="text-muted">Outdoor water efficiency</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="category-card text-center p-3 border rounded" style="background: linear-gradient(135deg, #fff3e0, #ffffff); cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2.5rem;">🏢</div>
                                    <h6 class="mb-1">Community</h6>
                                    <small class="text-muted">Neighborhood initiatives</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="category-card text-center p-3 border rounded" style="background: linear-gradient(135deg, #fce4ec, #ffffff); cursor: pointer; transition: all 0.3s ease;">
                                    <div class="category-icon mb-2" style="font-size: 2.5rem;">📚</div>
                                    <h6 class="mb-1">Education</h6>
                                    <small class="text-muted">Learn & share knowledge</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Quests -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--success-green), #66bb6a);">
                        <h5 class="mb-0"><i class="fa fa-list"></i> Available Quests</h5>
                    </div>
                    <div class="card-body">
                        
                        <?php if (!empty($allQuests)): ?>
                            <?php foreach ($allQuests as $quest): ?>
                                <?php 
                                    // Check if user has accepted this quest
                                    $isAccepted = isset($userQuestStatus[$quest->id]);
                                    $questStatus = $isAccepted ? $userQuestStatus[$quest->id]->status : null;
                                    $isCompleted = $questStatus === 'completed';
                                    $isPending = $questStatus === 'pending';
                                ?>
                                
                                <div class="quest-item border rounded p-4 mb-3 <?= $isCompleted ? 'quest-completed' : ($isPending ? 'quest-pending' : '') ?>" 
                                     style="background: linear-gradient(135deg, #f8f9fa, #ffffff); border-left: 4px solid var(--primary-blue) !important;">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="quest-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
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
                                                <div>
                                                    <h6 class="mb-1">
                                                        <?= esc($quest->title) ?>
                                                        <?php if ($isCompleted): ?>
                                                            <span class="badge bg-success ms-2">Completed</span>
                                                        <?php elseif ($isPending): ?>
                                                            <span class="badge bg-warning ms-2">In Progress</span>
                                                        <?php endif; ?>
                                                    </h6>
                                                    <div class="quest-badges">
                                                        <span class="badge bg-primary me-1"><?= ucfirst($quest->type) ?></span>
                                                        <span class="badge bg-info me-1">Quest</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-2"><?= esc($quest->description) ?></p>
                                            <div class="quest-rewards">
                                                <small class="text-success"><i class="fa fa-trophy"></i> +<?= $quest->ecopoints_reward ?> EcoPoints</small>
                                                <small class="text-info ms-3"><i class="fa fa-star"></i> +<?= $quest->xp_reward ?> XP</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <div class="quest-duration mb-2">
                                                <small class="text-muted"><i class="fa fa-clock-o"></i> <?= ucfirst($quest->type) ?> Quest</small>
                                            </div>
                                            
                                            <?php if ($isCompleted): ?>
                                                <button class="btn btn-success" disabled>
                                                    <i class="fa fa-check"></i> Completed
                                                </button>
                                            <?php elseif ($isPending): ?>
                                                <div class="btn-group-vertical w-100">
                                                    <form method="post" action="<?= base_url('/user/complete-quest') ?>" class="mb-2">
                                                        <input type="hidden" name="quest_id" value="<?= $quest->id ?>">
                                                        <button type="submit" class="btn btn-success w-100">
                                                            <i class="fa fa-check"></i> Complete Quest
                                                        </button>
                                                    </form>
                                                    <form method="post" action="<?= base_url('/user/cancel-quest') ?>" 
                                                          onsubmit="return confirm('Are you sure you want to cancel this quest?')">
                                                        <input type="hidden" name="quest_id" value="<?= $quest->id ?>">
                                                        <button type="submit" class="btn btn-outline-danger w-100">
                                                            <i class="fa fa-times"></i> Cancel Quest
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <form method="post" action="<?= base_url('/user/accept-quest') ?>">
                                                    <input type="hidden" name="quest_id" value="<?= $quest->id ?>">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-play"></i> Start Quest
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div style="font-size: 4rem; opacity: 0.3; margin-bottom: 20px;">🎯</div>
                                <h5 class="text-muted">No Quests Available</h5>
                                <p class="text-muted">Check back later for new water conservation challenges!</p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">
                
                <!-- Active Quests -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--accent-blue), #29b6f6);">
                        <h5 class="mb-0"><i class="fa fa-play-circle"></i> Active Quests</h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $activeQuests = array_filter($userQuests, function($quest) {
                            return $quest->status === 'pending';
                        });
                        ?>
                        
                        <?php if (!empty($activeQuests)): ?>
                            <?php foreach ($activeQuests as $activeQuest): ?>
                                <?php 
                                // Find the quest details
                                $questDetails = null;
                                foreach ($allQuests as $quest) {
                                    if ($quest->id == $activeQuest->quest_id) {
                                        $questDetails = $quest;
                                        break;
                                    }
                                }
                                ?>
                                <?php if ($questDetails): ?>
                                    <div class="active-quest-item border rounded p-3 mb-3" style="background: #f8f9fa;">
                                        <h6 class="mb-1"><?= esc($questDetails->title) ?></h6>
                                        <small class="text-muted">Started: <?= date('M j, Y', strtotime($activeQuest->accepted_at)) ?></small>
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fa fa-trophy"></i> +<?= $questDetails->ecopoints_reward ?> EcoPoints</small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <div style="font-size: 3rem; opacity: 0.5; margin-bottom: 15px;">🎯</div>
                                <h6 class="text-muted">No Active Quests</h6>
                                <p class="text-muted small">Start a quest from the list to begin earning rewards!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quest Tips -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--success-green), #66bb6a);">
                        <h5 class="mb-0"><i class="fa fa-lightbulb-o"></i> Quest Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--primary-blue);">💡</div>
                                <div>
                                    <small><strong>Start Easy:</strong> Begin with daily quests to build momentum and confidence.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--success-green);">📸</div>
                                <div>
                                    <small><strong>Document Progress:</strong> Take photos to track your water-saving improvements.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--warning-orange);">👥</div>
                                <div>
                                    <small><strong>Involve Family:</strong> Get family members involved for better results.</small>
                                </div>
                            </div>
                        </div>
                        <div class="tip-item">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-2" style="color: var(--accent-blue);">🏆</div>
                                <div>
                                    <small><strong>Stay Consistent:</strong> Complete quests regularly to maintain your streak.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quest Statistics -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue));">
                        <h5 class="mb-0"><i class="fa fa-chart-bar"></i> Your Quest Stats</h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $completedCount = count(array_filter($userQuests, function($q) { return $q->status === 'completed'; }));
                        $activeCount = count(array_filter($userQuests, function($q) { return $q->status === 'pending'; }));
                        $totalQuests = count($userQuests);
                        $successRate = $totalQuests > 0 ? round(($completedCount / $totalQuests) * 100) : 0;
                        ?>
                        
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-check-circle" style="color: var(--success-green);"></i> Completed</span>
                            <strong><?= $completedCount ?></strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-play-circle" style="color: var(--primary-blue);"></i> Active</span>
                            <strong><?= $activeCount ?></strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span><i class="fa fa-clock-o" style="color: var(--warning-orange);"></i> Total Accepted</span>
                            <strong><?= $totalQuests ?></strong>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-trophy" style="color: var(--accent-blue);"></i> Success Rate</span>
                            <strong><?= $successRate ?>%</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Quest Page Specific Styles */
.category-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.quest-item {
    transition: all 0.3s ease;
}

.quest-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.quest-completed {
    opacity: 0.8;
    background: linear-gradient(135deg, #e8f5e8, #ffffff) !important;
    border-left-color: var(--success-green) !important;
}

.quest-pending {
    background: linear-gradient(135deg, #fff3e0, #ffffff) !important;
    border-left-color: var(--warning-orange) !important;
}

.quest-icon {
    transition: all 0.3s ease;
}

.quest-item:hover .quest-icon {
    transform: scale(1.1);
}

.tip-item {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.tip-item:last-child {
    border-bottom: none;
}

.active-quest-item {
    border-left: 3px solid var(--primary-blue) !important;
}

@media (max-width: 768px) {
    .quest-item .row {
        text-align: center;
    }
    
    .quest-item .col-md-4 {
        margin-top: 15px;
    }
    
    .category-card {
        margin-bottom: 15px;
    }
    
    .btn-group-vertical .btn {
        margin-bottom: 5px;
    }
}
</style>

<?= $this->include('layout/footer') ?>