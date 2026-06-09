<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Admin Dashboard') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Top Bar -->
<header class="bg-slate-900 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Car Rental Admin</h1>
    <a href="<?= base_url('logout') ?>" class="text-red-300 hover:text-red-400">Logout</a>
</header>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-800 text-white p-5 space-y-4">
        <a href="<?= base_url('admin/dashboard') ?>" class="block hover:bg-slate-700 p-2 rounded">
            📊 Dashboard
        </a>
        <a href="<?= base_url('admin/bookings') ?>" class="block hover:bg-slate-700 p-2 rounded">
            📖 Bookings
        </a>
        <a href="<?= base_url('admin/cars') ?>" class="block hover:bg-slate-700 p-2 rounded">
            🚗 Cars
        </a>
        <a href="<?= base_url('admin/feedback') ?>" class="block hover:bg-slate-700 p-2 rounded">
            💬 Feedback
        </a>
        <a href="<?= base_url('admin/profile') ?>" class="block hover:bg-slate-700 p-2 rounded">
            ⚙️ Profile
        </a>
    </aside>

    <!-- Page Content -->
    <main class="flex-1 p-8">
        <?= $this->renderSection('content') ?>
    </main>

</div>

</body>
</html>
