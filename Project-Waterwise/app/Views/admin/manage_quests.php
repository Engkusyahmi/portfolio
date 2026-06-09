<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-tasks text-primary me-2"></i>
            Manage Quests
        </h2>
        <p class="text-muted">View and manage all quests</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/add-quest') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Quest
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>XP Reward</th>
                        <th>EcoPoints Reward</th>
                        <th>Type</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($quests)): ?>
                        <?php foreach ($quests as $quest): ?>
                            <tr>
                                <td><?= esc($quest->id) ?></td>
                                <td><strong><?= esc($quest->title) ?></strong></td>
                                <td><?= esc(substr($quest->description, 0, 50)) ?>...</td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= esc($quest->xp_reward) ?> XP
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= esc($quest->ecopoints_reward) ?> EP
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= ucfirst($quest->type) ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M j, Y', strtotime($quest->created_at)) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('/admin/edit-quest/' . $quest->id) ?>" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('/admin/delete-quest/' . $quest->id) ?>" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirmDelete('Are you sure you want to delete this quest?')" 
                                           title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-tasks fa-3x mb-3 d-block"></i>
                                No quests found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>