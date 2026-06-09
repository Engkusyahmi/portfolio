<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BusTracker</title>
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #A7C7E7 0%, #D1E7F5 100%); /* Soft blue gradient background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            /* Removed: overflow: hidden; */ /* This was preventing scrolling */
        }
        .register-container {
            background-color: #ffffff;
            border-radius: 1.75rem; /* More rounded corners */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25); /* Stronger, softer shadow */
            padding: 4rem 4.5rem; /* Even more generous padding */
            width: 100%;
            max-width: 550px; /* Slightly wider for better balance */
            text-align: center;
            border: 1px solid rgba(226, 232, 240, 0.6); /* Subtle light border */
            position: relative;
            z-index: 10; /* Ensure it's above any background elements */
        }
        .form-title {
            font-size: 2.8rem; /* Larger, more impactful title */
            font-weight: 800; /* Extra bold */
            color: #2c3e50; /* Darker text for contrast */
            margin-bottom: 3rem; /* More space below title */
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05); /* Subtle text shadow */
        }
        .form-control-custom {
            display: block;
            width: 100%;
            padding: 1rem 1.8rem; /* Increased padding */
            font-size: 1.1rem; /* Slightly larger font */
            line-height: 1.5;
            color: #34495e; /* Darker text */
            background-color: #fcfdfe; /* Very light input background */
            border: 1px solid #cbd5e0; /* Lighter border */
            border-radius: 1rem; /* More rounded inputs */
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .form-control-custom:focus {
            border-color: #4299e1; /* A slightly deeper blue for focus */
            outline: 0;
            box-shadow: 0 0 0 8px rgba(66, 153, 225, 0.3); /* Softer, wider blue focus shadow */
        }
        .form-label-custom {
            display: block;
            margin-bottom: 0.8rem; /* More space */
            font-weight: 700; /* Bolder labels */
            color: #5a67d8; /* A pleasant blue-purple for labels */
            font-size: 1.1rem;
            text-align: left; /* Align labels to the left */
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); /* Attractive blue-purple gradient */
            color: white;
            padding: 1.1rem 3rem; /* Larger, more prominent button */
            border-radius: 1rem; /* More rounded */
            font-weight: 700;
            transition: all 0.3s ease; /* Smooth transition for all properties */
            cursor: pointer;
            border: none;
            box-shadow: 0 8px 15px rgba(0,0,0,0.2); /* Stronger shadow */
            text-transform: uppercase;
            letter-spacing: 0.08em; /* Slightly more spaced letters */
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            transform: translateY(-5px); /* More pronounced lift effect */
            box-shadow: 0 12px 25px rgba(0,0,0,0.3); /* Even stronger shadow on hover */
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); /* Reverse gradient on hover */
        }
        .btn-primary:active {
            transform: translateY(-2px); /* Slight press effect */
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }
        .text-link {
            color: #5a67d8; /* Matching label color for links */
            font-weight: 700;
            transition: color 0.2s ease;
        }
        .text-link:hover {
            color: #434190; /* Darker blue-purple on hover */
            text-decoration: underline;
        }
        .error-message {
            color: #e74c3c; /* Red for errors */
            font-size: 0.95rem; /* Slightly larger error text */
            margin-top: 0.6rem; /* More space */
            text-align: left;
            font-weight: 500;
        }
        .alert-success-custom {
            background-color: #d4edda;
            color: #155724;
            border-left: 6px solid #28a745; /* Thicker border */
            padding: 1.2rem; /* More padding */
            border-radius: 0.75rem; /* More rounded */
            margin-bottom: 2rem; /* More space */
            text-align: left;
            font-weight: 600;
        }
        .alert-danger-custom {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 6px solid #dc3545; /* Thicker border */
            padding: 1.2rem; /* More padding */
            border-radius: 0.75rem; /* More rounded */
            margin-bottom: 2rem; /* More space */
            text-align: left;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1 class="form-title">Register Account</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-success-custom">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-danger-custom">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert-danger-custom">
                <p class="font-bold mb-2">Please correct the following errors:</p>
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div>
                <label for="fullname" class="form-label-custom">Full Name</label>
                <input type="text" name="fullname" id="fullname" class="form-control-custom" value="<?= old('fullname') ?>" placeholder="Enter your full name">
                <?php if ($validation->hasError('fullname')): ?>
                    <p class="error-message"><?= $validation->getError('fullname') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="username" class="form-label-custom">Username</label>
                <input type="text" name="username" id="username" class="form-control-custom" value="<?= old('username') ?>" placeholder="Choose a username" autocomplete="off">
                <?php if ($validation->hasError('username')): ?>
                    <p class="error-message"><?= $validation->getError('username') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="contact" class="form-label-custom">Contact Number</label>
                <input type="text" name="contact" id="contact" class="form-control-custom" value="<?= old('contact') ?>" placeholder="Enter your contact number">
                <?php if ($validation->hasError('contact')): ?>
                    <p class="error-message"><?= $validation->getError('contact') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="password" class="form-label-custom">Password</label>
                <input type="password" name="password" id="password" class="form-control-custom" placeholder="Enter your password" autocomplete="new-password">
                <?php if ($validation->hasError('password')): ?>
                    <p class="error-message"><?= $validation->getError('password') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="pass_confirm" class="form-label-custom">Confirm Password</label>
                <input type="password" name="pass_confirm" id="pass_confirm" class="form-control-custom" placeholder="Confirm your password" autocomplete="new-password">
                <?php if ($validation->hasError('pass_confirm')): ?>
                    <p class="error-message"><?= $validation->getError('pass_confirm') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="userlevel" class="form-label-custom">Register As</label>
                <select name="userlevel" id="userlevel" class="form-control-custom">
                    <option value="">-- Select User Type --</option>
                    <option value="student" <?= old('userlevel') == 'student' ? 'selected' : '' ?>>Student</option>
                    <option value="driver" <?= old('userlevel') == 'driver' ? 'selected' : '' ?>>Driver</option>
                    <!-- IMPORTANT: Removed 'admin' option here for public registration -->
                </select>
                <?php if ($validation->hasError('userlevel')): ?>
                    <p class="error-message"><?= $validation->getError('userlevel') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="image" class="form-label-custom">Profile Image</label>
                <input type="file" name="image" id="image" class="form-control-custom" accept="image/jpeg,image/png,image/gif">
                <p class="text-gray-500 text-sm mt-1 text-left">Max 2MB, JPG/PNG/GIF.</p>
                <?php if ($validation->hasError('image')): ?>
                    <p class="error-message"><?= $validation->getError('image') ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-primary w-full">Register</button>
        </form>

        <p class="mt-8 text-gray-600">
            Already have an account? <a href="<?= base_url('login') ?>" class="text-link">Login here</a>
        </p>
    </div>
</body>
</html>
