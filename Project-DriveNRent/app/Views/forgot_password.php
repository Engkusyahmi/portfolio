<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<style>body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7f6;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    color: #333;
}

.container {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 450px;
}

h2 {
    color: #007bff;
    margin-bottom: 25px;
    font-size: 2em;
    letter-spacing: 0.5px;
}

p {
    color: #28a745; /* For success messages */
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Specific style for instruction text */
p.instruction {
    color: #555;
    background-color: transparent;
    border: none;
    font-weight: normal;
    font-size: 1.1em;
    margin-bottom: 30px; /* More space below instruction */
    line-height: 1.5;
    text-align: center;
}

/* For error messages, if you implement them */
p.error {
    color: #dc3545;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    margin-bottom: 10px;
    font-size: 1.1em;
    color: #555;
    align-self: flex-start; /* Align label to the left */
}

input[type="text"] {
    width: calc(100% - 20px);
    padding: 12px;
    margin-bottom: 25px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1em;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="text"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    outline: none;
}

button[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 14px 25px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1em;
    font-weight: bold;
    letter-spacing: 0.5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    width: 100%;
}

button[type="submit"]:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

button[type="submit"]:active {
    transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .container {
        margin: 20px;
        padding: 30px;
    }

    h2 {
        font-size: 1.8em;
    }

    button[type="submit"] {
        padding: 12px 20px;
        font-size: 1em;
    }
}</style>
<body>
    <div class="container">
        <h2>Forgot Password</h2>

        <?php if (session()->getFlashdata('message')): ?>
            <p><?= session()->getFlashdata('message') ?></p>
        <?php endif; ?>

        <form method="post" action="<?= base_url('forgot-password/send') ?>">
            <p class="instruction">Please enter your username or email address below to reset your password.</p>
            <label for="user_identifier">Username or Email:</label>
            <input type="text" name="user_identifier" id="user_identifier" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>