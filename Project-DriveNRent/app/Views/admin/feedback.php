<?= $this->extend('admin/layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold mb-6">Customer Feedback</h2>

<?php foreach ($feedbacks as $fb): ?>
<div class="bg-white p-4 rounded shadow mb-4">
    <p class="font-semibold"><?= esc($fb['customer']) ?></p>
    <p class="text-yellow-500">Rating: <?= esc($fb['rating']) ?>/5</p>
    <p class="text-gray-600 mt-2"><?= esc($fb['message']) ?></p>
</div>
<?php endforeach ?>

<?= $this->endSection() ?>
