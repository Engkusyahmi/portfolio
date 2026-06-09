<?= $this->include('layout/header') ?>

<div class="container py-5">
    <h2 class="mb-4">⚙️ Settings</h2>

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

    <!-- CURRENT PROFILE DISPLAY -->
    <div class="text-center mb-5">
        <img src="<?= base_url('images/pfp/' . ($userData['profile_pic'] ?? 'default1.png')) ?>"
             class="rounded-circle border border-3 <?= esc($userData['border_style'] ?? '') ?>"
             width="120" height="120" alt="Profile Picture">
        <div class="mt-2">
            <button class="btn btn-outline-primary" onclick="document.getElementById('edit-profile').style.display='block'">
                Edit Profile Picture
            </button>
        </div>
    </div>

    <!-- PROFILE PICTURE & BORDER EDIT SECTION -->
    <div id="edit-profile" style="display:none;">
        <form method="post" action="<?= base_url('/user/updateProfile') ?>">
            <?= csrf_field() ?>
            
            <!-- PROFILE PICTURE SELECTION -->
            <div class="mb-5">
                <h4>👤 Select Profile Picture</h4>
                <div class="d-flex flex-wrap gap-3">
                    <?php foreach ($profilePictures as $pic): ?>
                        <div class="text-center">
                            <label>
                                <input type="radio" name="profile_pic" value="<?= $pic['filename'] ?>"
                                    <?= isset($userData['profile_pic']) && $userData['profile_pic'] === $pic['filename'] ? 'checked' : '' ?>>
                                <img src="<?= base_url('images/pfp/' . $pic['filename']) ?>" class="rounded-circle" width="80">
                            </label>
                            <div><?= $pic['locked'] ? '🔒 Locked' : '✅ Free' ?></div>
                            <?php if ($pic['locked']): ?>
                                <small class="text-warning">Unlock with EcoPoints</small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- BORDER STYLE SELECTION -->
            <div class="mb-5">
                <h4>🎨 Profile Picture Border</h4>
                <select name="pfp_border" class="form-control" style="max-width: 300px;">
                    <?php foreach ($profileBorders as $key => $label): ?>
                        <option value="<?= esc($key) ?>" <?= ($userData['border_style'] ?? '') === $key ? 'selected' : '' ?>>
                            <?= esc($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted d-block mt-1">Some borders may require EcoPoints to unlock.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <!-- USER DETAILS -->
    <div class="mb-5">
        <h4>📋 User Information</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" class="form-control" value="<?= esc($userData['fullname'] ?? '') ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" class="form-control" value="<?= esc($userData['email'] ?? '') ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label>Subscription Plan</label>
                <input type="text" class="form-control" value="<?= ucfirst($userData['subscription_plan'] ?? 'Basic') ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label>Current Level</label>
                <input type="text" class="form-control" value="Level <?= floor(($userData['xp'] ?? 0) / 100) ?>" readonly>
            </div>
        </div>
    </div>

    <!-- MANUAL WATER USAGE UPDATE -->
    <div class="mb-5">
        <h4>💧 Water Usage Update</h4>
        <form action="<?= base_url('/user/updateWater') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group mb-3">
                <label for="water_reading">Current Meter/Bill Reading (e.g., RM or m³)</label>
                <input type="text" name="water_reading" class="form-control" required>
                <small class="text-muted">Enter your current water meter reading or bill amount</small>
            </div>
            <div class="form-group mb-3">
                <label for="proof_photo">Upload Image of Bill / Water Meter</label>
                <input type="file" name="proof_photo" class="form-control" accept="image/*" required>
                <small class="text-muted">Upload a clear photo of your water bill or meter reading</small>
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-upload"></i> Submit Update (+20 EcoPoints, +25 XP)
            </button>
        </form>
    </div>

    <!-- SUBSCRIPTION PLANS -->
    <div class="mb-5">
        <h4>💎 Subscription Plans</h4>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card <?= ($userData['subscription_plan'] ?? 'basic') === 'basic' ? 'border-primary' : '' ?>">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Basic Plan</h5>
                        <small class="text-muted">Free</small>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>✅ Basic water tracking</li>
                            <li>✅ Daily rewards</li>
                            <li>✅ Basic achievements</li>
                            <li>❌ Premium rewards</li>
                            <li>❌ Advanced analytics</li>
                        </ul>
                        <?php if (($userData['subscription_plan'] ?? 'basic') === 'basic'): ?>
                            <span class="badge bg-success">Current Plan</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card <?= ($userData['subscription_plan'] ?? 'basic') === 'gold' ? 'border-warning' : '' ?>">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Gold Plan</h5>
                        <small><strong>RM 19.99/month</strong></small>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>✅ Everything in Basic</li>
                            <li>✅ Premium rewards access</li>
                            <li>✅ 2x daily rewards</li>
                            <li>✅ Exclusive achievements</li>
                            <li>❌ Advanced analytics</li>
                        </ul>
                        <?php if (($userData['subscription_plan'] ?? 'basic') === 'gold'): ?>
                            <span class="badge bg-warning">Current Plan</span>
                        <?php else: ?>
                            <form method="post" action="<?= base_url('/user/upgradeSubscription') ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="plan" value="gold">
                                <input type="hidden" name="amount" value="19.99">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fa fa-credit-card"></i> Upgrade - RM 19.99
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card <?= ($userData['subscription_plan'] ?? 'basic') === 'diamond' ? 'border-info' : '' ?>">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Diamond Plan</h5>
                        <small><strong>RM 49.99/month</strong></small>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>✅ Everything in Gold</li>
                            <li>✅ Advanced analytics</li>
                            <li>✅ 3x daily rewards</li>
                            <li>✅ All premium features</li>
                            <li>✅ Priority support</li>
                        </ul>
                        <?php if (($userData['subscription_plan'] ?? 'basic') === 'diamond'): ?>
                            <span class="badge bg-info">Current Plan</span>
                        <?php else: ?>
                            <form method="post" action="<?= base_url('/user/upgradeSubscription') ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="plan" value="diamond">
                                <input type="hidden" name="amount" value="49.99">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fa fa-credit-card"></i> Upgrade - RM 49.99
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHANGE PASSWORD -->
    <div class="mb-5">
        <h4>🔒 Change Password</h4>
        <form action="<?= base_url('/user/changePassword') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group mb-2">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button class="btn btn-warning" type="submit">Change Password</button>
        </form>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" method="post" action="<?= base_url('/user/processPayment') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" id="selectedPlan" name="plan" value="">
                    <input type="hidden" id="selectedAmount" name="amount" value="">
                    
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" name="card_number" placeholder="1234 5678 9012 3456" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expiryDate" class="form-label">Expiry Date</label>
                            <input type="text" class="form-control" id="expiryDate" name="expiry_date" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cardName" class="form-label">Cardholder Name</label>
                        <input type="text" class="form-control" id="cardName" name="card_name" required>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Your payment will be processed securely. You will be charged <span id="displayAmount"></span> for the <span id="displayPlan"></span> plan.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="paymentForm" class="btn btn-primary">
                    <i class="fa fa-credit-card"></i> Process Payment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle subscription upgrade clicks
    document.querySelectorAll('form[action*="upgradeSubscription"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const plan = this.querySelector('input[name="plan"]').value;
            const amount = this.querySelector('input[name="amount"]').value;
            
            document.getElementById('selectedPlan').value = plan;
            document.getElementById('selectedAmount').value = amount;
            document.getElementById('displayPlan').textContent = plan.charAt(0).toUpperCase() + plan.slice(1);
            document.getElementById('displayAmount').textContent = 'RM ' + amount;
            
            // Show payment modal
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        });
    });
    
    // Format card number input
    document.getElementById('cardNumber').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });
    
    // Format expiry date input
    document.getElementById('expiryDate').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
    
    // Format CVV input
    document.getElementById('cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 3);
    });
});
</script>

<?= $this->include('layout/footer') ?>