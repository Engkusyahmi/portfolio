<?php if (!empty($profile)): ?>
    <tr>
        <td>ID:</td>
        <td><?= esc($profile['id']) ?></td>
    </tr>
    <tr>
        <td>Full Name:</td>
        <td><?= esc($profile['fullname']) ?></td>
    </tr>
    <tr>
        <td>Username:</td>
        <td><?= esc($profile['username']) ?></td>
    </tr>
    <tr>
        <td>User Level:</td>
        <td><?= esc($profile['userlevel']) ?></td>
    </tr>
    <tr>
        <td>Contact:</td>
        <td><?= esc($profile['contact']) ?></td>
    </tr>
<?php else: ?>
    <tr><td colspan="2">Profile not found.</td></tr>
<?php endif; ?>
