<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-trophy text-primary me-2"></i>
            Manage Achievements
        </h2>
        <p class="text-muted">View and manage all achievements</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/add-achievement') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Achievement
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
                        <th>Level Required</th>
                        <th>Category</th>
                        <th>Tier</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($achievements)): ?>
                        <?php foreach ($achievements as $achievement): ?>
                            <tr>
                                <td><?= esc($achievement->id) ?></td>
                                <td><strong><?= esc($achievement->title) ?></strong></td>
                                <td><?= esc(substr($achievement->description, 0, 50)) ?>...</td>
                                <td>
                                    <span class="badge bg-info">
                                        Level <?= esc($achievement->level_required) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= esc($achievement->category) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $achievement->tier === 'gold' ? 'bg-warning' : ($achievement->tier === 'silver' ? 'bg-secondary' : 'bg-dark') ?>">
                                        <?= ucfirst($achievement->tier) ?>
                                    </span>
                                </td>
                                <td>
                                    <img src="<?= base_url($achievement->image_path) ?>" 
                                         alt="Achievement" class="rounded" width="40" height="40">
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('/admin/edit-achievement/' . $achievement->id) ?>" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('/admin/delete-achievement/' . $achievement->id) ?>" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirmDelete('Are you sure you want to delete this achievement?')" 
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
                                <i class="fas fa-trophy fa-3x mb-3 d-block"></i>
                                No achievements found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>