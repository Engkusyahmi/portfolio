<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Chat & Contact Driver</h2>
    
    <?php if (!empty($chatPartners)): ?>
        <?php foreach ($chatPartners as $partner): ?>
            <div class="border rounded p-3 mb-3 shadow bg-white">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="font-semibold"><?= esc($partner['fullname']) ?> (<?= esc($partner['userlevel']) ?>)</div>
                        <?php if ($partner['unread_count'] > 0): ?>
                            <div class="text-red-500 text-sm"><?= $partner['unread_count'] ?> unread message(s)</div>
                        <?php endif; ?>
                    </div>
                    <a href="<?= base_url('chat/viewChat/' . $partner['id']) ?>" class="btn btn-primary">View Chat</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-gray-500">No chats yet.</div>
    <?php endif; ?>
</div>
