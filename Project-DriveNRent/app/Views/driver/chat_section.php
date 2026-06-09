<?= $this->extend('driver/layout') ?>
<?= $this->section('content') ?>

<div id="chat-student" class="content-section">
    <h2 class="text-2xl font-bold mb-6">Chat & Contact Students</h2>

    <?php if (!empty($chatPartners)): ?>
        <?php foreach ($chatPartners as $partner): ?>
            <div class="border rounded-xl p-5 mb-5 shadow-lg bg-white flex justify-between items-center">
                <div>
                    <div class="font-semibold text-lg text-gray-800">
                        <?= esc($partner['fullname']) ?> (<?= esc($partner['userlevel']) ?>)
                    </div>
                    <?php if ($partner['unread_count'] > 0): ?>
                        <div class="text-red-600 font-medium text-sm mt-1">
                            <?= $partner['unread_count'] ?> unread message(s)
                        </div>
                    <?php endif; ?>
                </div>
                <a href="<?= base_url('chat/viewChat/' . $partner['id']) ?>" class="btn-primary text-sm px-6 py-2">View Chat</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-gray-500 text-center py-4">No chats yet.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
