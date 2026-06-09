<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-gift text-primary me-2"></i>
            Manage Rewards
        </h2>
        <p class="text-muted">View and manage all rewards</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/add-reward') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Reward
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
                        <th>Name</th>
                        <th>Description</th>
                        <th>Cost</th>
                        <th>Type</th>
                        <th>Available</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rewards)): ?>
                        <?php foreach ($rewards as $reward): ?>
                            <tr>
                                <td><?= esc($reward->id) ?></td>
                                <td><strong><?= esc($reward->name) ?></strong></td>
                                <td><?= esc(substr($reward->description, 0, 50)) ?>...</td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= esc($reward->cost_ecopoints) ?> EP
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= ucfirst($reward->type) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $reward->available ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $reward->available ? 'Yes' : 'No' ?>
                                    </span>
                                </td>
                                <td>
                                    <img src="<?= base_url($reward->image_path ?? 'img/default.png') ?>" 
                                         alt="Reward" class="rounded" width="40" height="40"
                                         onerror="this.onerror=null;this.src='<?= base_url('img/default.png') ?>';">
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('/admin/edit-reward/' . $reward->id) ?>" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('/admin/delete-reward/' . $reward->id) ?>" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirmDelete('Are you sure you want to delete this reward?')" 
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
                                <i class="fas fa-gift fa-3x mb-3 d-block"></i>
                                No rewards found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>
