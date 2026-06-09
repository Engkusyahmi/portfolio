<?php if (!empty($schedules)): ?>
    <?php foreach ($schedules as $row): ?>
        <tr>
            <td class="py-2 px-4 border-b"><?= esc($row['bus_id']) ?></td>
            <td class="py-2 px-4 border-b"><?= esc($row['route_name']) ?></td>
            <td class="py-2 px-4 border-b"><?= esc($row['departure_time']) ?></td>
            <td class="py-2 px-4 border-b"><?= esc($row['arrival_time']) ?></td>
            <td class="py-2 px-4 border-b"><?= esc($row['driver_name'] ?? 'N/A') ?></td>
            <td class="py-2 px-4 border-b <?= $row['status'] === 'Delayed' ? 'text-red-600' : 'text-green-600' ?> font-semibold">
                <?= esc($row['status']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="6" class="text-center text-gray-500">No schedules found for today.</td></tr>
<?php endif; ?>
