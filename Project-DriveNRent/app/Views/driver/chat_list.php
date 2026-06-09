<?= $this->extend('driver/layout') ?>
<?= $this->section('content') ?>

<div id="chat-student" class="content-section">
    <h2 class="text-2xl font-bold mb-6">Chat with Students</h2>

    <?php if (!empty($chatUsers)): ?>
        <ul class="space-y-4">
            <?php foreach ($chatUsers as $user): ?>
                <li class="bg-white p-4 rounded-xl shadow border hover:bg-gray-50 transition">
                    <div class="flex justify-between items-center">
                        <div class="text-lg font-semibold text-gray-800">
                            <?= esc($user['fullname']) ?>
                        </div>
                        <a href="<?= base_url('driver/chat/' . $user['id']) ?>" class="btn-primary text-sm px-5 py-1.5">
                            Chat Now
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="text-gray-500 py-4 text-center">No students to chat with.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
