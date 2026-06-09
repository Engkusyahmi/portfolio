<?= $this->extend('admin/layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-6">Dashboard Overview</h2>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <!-- Total Cars -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Total Cars</h3>
        <p class="text-3xl font-bold"><?= esc($totalCars ?? 0) ?></p>
    </div>

    <!-- Total Bookings -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Total Bookings</h3>
        <p class="text-3xl font-bold"><?= esc($totalBookings ?? 0) ?></p>
    </div>

    <!-- Pending Bookings -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Pending Bookings</h3>
        <p class="text-3xl font-bold"><?= esc($pendingBookings ?? 0) ?></p>
    </div>

    <!-- Approved Bookings -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Approved Bookings</h3>
        <p class="text-3xl font-bold"><?= esc($approvedBookings ?? 0) ?></p>
    </div>

</div>

<!-- Recent Activity -->
<div class="mt-8">
    <h3 class="text-xl font-bold mb-4">Recent Bookings</h3>
    <?php if(!empty($recentActivity)): ?>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Booking ID</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Bus</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recentActivity as $booking): ?>
                        <tr class="border-t">
                            <td class="px-4 py-2"><?= esc($booking['id']) ?></td>
                            <td class="px-4 py-2"><?= esc($booking['user_id']) ?></td>
                            <td class="px-4 py-2"><?= esc($booking['bus_name']) ?></td>
                            <td class="px-4 py-2"><?= esc($booking['status']) ?></td>
                            <td class="px-4 py-2"><?= esc($booking['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-500">No recent bookings available.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
