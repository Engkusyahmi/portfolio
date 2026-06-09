<?= $this->extend('admin/layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-6">Cars Management</h2>

<a href="<?= base_url('admin/cars/create') ?>"
   class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
   + Add New Car
</a>

<div class="grid md:grid-cols-3 gap-6">
<?php foreach ($cars as $car): ?>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold text-lg"><?= esc($car['name']) ?></h3>
        <p class="text-gray-500"><?= esc($car['type']) ?></p>
        <p class="font-semibold">RM <?= esc($car['price']) ?>/day</p>

        <div class="mt-3 flex gap-3">
            <a href="<?= base_url('admin/cars/edit/'.$car['id']) ?>" class="text-blue-600">Edit</a>
            <a href="<?= base_url('admin/cars/delete/'.$car['id']) ?>" class="text-red-600"
               onclick="return confirm('Delete this car?')">
               Delete
            </a>
        </div>
    </div>
<?php endforeach ?>
</div>

<?= $this->endSection() ?>
