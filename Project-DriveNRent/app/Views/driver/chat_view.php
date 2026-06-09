<?= $this->extend('driver/layout') ?>
<?= $this->section('content') ?>

<div id="chat-student" class="content-section">
    <h2 class="text-2xl font-bold mb-6">Chat with <?= esc($receiver['fullname']) ?> (<?= esc($receiver['userlevel']) ?>)</h2>

    <div class="chat-container mb-6">
        <div class="chat-messages">
            <?php foreach ($messages as $msg): ?>
                <div class="chat-message-bubble <?= $msg['sender_id'] == $currentUserId ? 'sent' : 'received' ?>">
                    <?= esc($msg['message_text']) ?>
                    <div class="message-meta">
                        <?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <form action="<?= base_url('chat/sendMessage') ?>" method="post" class="chat-input-area">
            <?= csrf_field() ?>
            <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">
            <input type="text" name="message_text" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
