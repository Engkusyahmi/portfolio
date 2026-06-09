<?= $this->extend('driver/layout') ?>
<?= $this->section('content') ?>

<div id="schedules" class="content-section">
    <h2 class="text-2xl font-bold mb-6">My Schedules</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-custom alert-success-custom">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert-custom alert-danger-custom">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($schedules)): ?>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg shadow-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="bg-gray-200 text-left px-6 py-4">Route</th>
                        <th class="bg-gray-200 text-left px-6 py-4">Date</th>
                        <th class="bg-gray-200 text-left px-6 py-4">Departure Time</th>
                        <th class="bg-gray-200 text-left px-6 py-4">Arrival Time</th>
                        <th class="bg-gray-200 text-left px-6 py-4">Bus Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $schedule): ?>
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="border-b px-6 py-4"><?= esc($schedule['route']) ?></td>
                            <td class="border-b px-6 py-4"><?= esc($schedule['date']) ?></td>
                            <td class="border-b px-6 py-4"><?= esc($schedule['departure_time']) ?></td>
                            <td class="border-b px-6 py-4"><?= esc($schedule['arrival_time']) ?></td>
                            <td class="border-b px-6 py-4"><?= esc($schedule['bus_name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-500 text-center py-6">No schedules available.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
