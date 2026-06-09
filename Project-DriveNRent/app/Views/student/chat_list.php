<h2 class="text-xl font-bold mb-4">Chat with Drivers</h2>
<ul class="space-y-2">
    <?php foreach ($chatUsers as $user): ?>
        <li>
            <a href="<?= base_url('student/chat/' . $user['id']) ?>" class="text-blue-600 underline">
                <?= esc($user['fullname']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
