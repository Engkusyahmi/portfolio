<?= $this->extend('admin/layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-6">Bookings</h2>

<table class="w-full bg-white rounded shadow overflow-hidden">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Customer</th>
            <th class="p-3">Car</th>
            <th class="p-3">Date</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($bookings as $booking): ?>
        <tr class="border-t">
            <td class="p-3"><?= esc($booking['customer_name']) ?></td>
            <td class="p-3"><?= esc($booking['car_name']) ?></td>
            <td class="p-3"><?= esc($booking['date']) ?></td>
            <td class="p-3">
                <span class="px-3 py-1 rounded text-white
                    <?= $booking['status'] === 'confirmed' ? 'bg-green-500' : 'bg-yellow-500' ?>">
                    <?= esc($booking['status']) ?>
                </span>
            </td>
            <td class="p-3 space-x-2">
                <a href="<?= base_url('admin/booking/confirm/'.$booking['id']) ?>" class="text-green-600">Confirm</a>
                <a href="<?= base_url('admin/booking/cancel/'.$booking['id']) ?>" class="text-red-600">Cancel</a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
