<h2 class="text-xl font-bold mb-4">Chat with <?= esc($receiver['fullname']) ?> (<?= esc($receiver['userlevel']) ?>)</h2>

<div class="bg-white p-4 border rounded-lg max-h-96 overflow-y-auto mb-4">
    <?php foreach ($messages as $msg): ?>
        <div class="mb-2 <?= $msg['sender_id'] == $currentUserId ? 'text-right' : 'text-left' ?>">
            <span class="inline-block px-3 py-2 rounded-lg <?= $msg['sender_id'] == $currentUserId ? 'bg-blue-100' : 'bg-gray-200' ?>">
                <?= esc($msg['message_text']) ?>
            </span><br>
            <small class="text-gray-500"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></small>
        </div>
    <?php endforeach; ?>
</div>

<form action="<?= base_url('chat/sendMessage') ?>" method="post" class="flex items-center space-x-2">
    <?= csrf_field() ?>
    <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">
    <input type="text" name="message_text" placeholder="Type your message..." required class="w-full p-2 border rounded">
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Send</button>
</form>
