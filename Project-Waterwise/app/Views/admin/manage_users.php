<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-users text-primary me-2"></i>
            Manage Users
        </h2>
        <p class="text-muted">View and manage all system users</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/add-user') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New User
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= base_url('/admin/manage-users') ?>">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by username, fullname, or email..." 
                           value="<?= esc($search ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Level</th>
                        <th>EcoPoints</th>
                        <th>XP</th>
                        <th>Login Streak</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= esc($user->id) ?></td>
                                <td>
                                    <strong><?= esc($user->fullname) ?></strong>
                                    <?php if ($user->userlevel === 'admin'): ?>
                                        <span class="badge bg-danger ms-1">Admin</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($user->username) ?></td>
                                <td><?= esc($user->email) ?></td>
                                <td>
                                    <span class="badge <?= $user->userlevel === 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                                        <?= ucfirst($user->userlevel) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= esc($user->ecopoints ?? 0) ?> EP
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= esc($user->xp ?? 0) ?> XP
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <?= esc($user->login_streak ?? 0) ?> days
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M j, Y', strtotime($user->created_at)) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('/admin/edit-user/' . $user->id) ?>" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($user->id != session()->get('id')): ?>
                                            <a href="<?= base_url('/admin/delete-user/' . $user->id) ?>" 
                                               class="btn btn-outline-danger" 
                                               onclick="return confirmDelete('Are you sure you want to delete this user?')" 
                                               title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                No users found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>