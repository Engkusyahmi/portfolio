<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('<?= base_url("images/bglogin.jpg") ?>') no-repeat center center fixed;
      background-size: cover;
    }

    #login-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    #divlogin {
      background: rgba(255, 255, 255, 0.1);
      padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 400px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    h1 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #ffffff;
    }

    label {
      font-weight: bold;
      color: #ffffff;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      margin-bottom: 15px;
      background-color: rgba(255, 255, 255, 0.85);
      color: #000000;
      border: none;
      border-radius: 10px;
      font-size: 16px;
    }

    input[type="submit"] {
      width: 100%;
      background: linear-gradient(to right, #007bff, #28a745);
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    input[type="submit"]:hover {
      background: linear-gradient(to right, #0056b3, #1e7e34);
    }

    .remember-line {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }

    .remember-line input {
      margin-right: 8px;
    }

    .remember-line label {
      color: #ffffff;
    }

    .alert {
      background: rgba(248, 215, 218, 0.9);
      color: #721c24;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #f5c6cb;
      border-radius: 5px;
    }

    .register-link {
      margin-top: 20px;
      text-align: center;
    }

    .register-link a {
      color: #00d4ff;
      font-weight: bold;
      text-decoration: none;
    }

    .register-link a:hover {
      color: #ffffff;
    }
  </style>
</head>
<body>

<div id="login-wrapper">
  <div id="divlogin">
    <h1>Login</h1>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('login') ?>" onsubmit="return rememberUser();" autocomplete="off">
      <?= csrf_field() ?>

      <label for="user">Username:</label>
      <input type="text" id="user" name="user" placeholder="Enter your username" autocomplete="off" required>

      <label for="p">Password:</label>
      <input type="password" id="p" name="p" placeholder="Enter your password" autocomplete="new-password" required>
      <input type="checkbox" onclick="togglePassword()"> Show

      <div class="remember-line">
        <input type="checkbox" id="rm" name="rm">
        <label for="rm">Remember me</label>
      </div>

      <input type="submit" value="Login">
    </form>

    <div class="register-link">
      <a href="<?= base_url('forgot-password') ?>">Forgot password?</a><br>
      Don’t have an account? <a href="<?= base_url('register') ?>">Register</a>
    </div>
  </div>
</div>

<script>
  // Detect if login error exists
  const loginError = <?= session()->getFlashdata('error') ? 'true' : 'false' ?>;

  // Autofill only if no login error
  window.onload = function () {
    if (!loginError && localStorage.getItem("remember") === "1") {
      document.getElementById("user").value = localStorage.getItem("user") || "";
      document.getElementById("p").value = localStorage.getItem("pass") || "";
      document.getElementById("rm").checked = true;
    }
  };

  // Save or clear credentials on login
  function rememberUser() {
    const remember = document.getElementById("rm").checked;
    const username = document.getElementById("user").value;
    const password = document.getElementById("p").value;

    if (remember) {
      localStorage.setItem("user", username);
      localStorage.setItem("pass", password);
      localStorage.setItem("remember", "1");
    } else {
      localStorage.removeItem("user");
      localStorage.removeItem("pass");
      localStorage.removeItem("remember");
    }

    return true;
  }

  // Show/hide password toggle
  function togglePassword() {
    const pwd = document.getElementById("p");
    pwd.type = pwd.type === "password" ? "text" : "password";
  }
</script>

</body>
</html>
