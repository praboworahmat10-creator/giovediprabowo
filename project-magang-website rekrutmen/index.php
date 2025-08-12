<?php
session_start();
include "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = md5($_POST['password']); // Gunakan hashing lebih aman di masa depan

  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) === 1) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "Username atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - First Routes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <style>
    body {
      background-color: #faeaea;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }
    .left-panel {
      background-color: #b71217;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      height: 100vh;
    }
    .logo {
      width: 100px;
      height: 100px;
      background-image: url('./gambar/logo.png');
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      background-color: white;
      border-radius: 50%;
      margin-bottom: 1rem;
    }

    .animate-fade {
      opacity: 0;
      animation: fadeIn 2s ease-in-out forwards;
    }
    .delay-300 {
      animation-delay: 0.3s;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    .login-card {
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 2rem;
      animation: slideIn 1s ease-out;
    }
    @keyframes slideIn {
      from { transform: translateX(50px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    .form-check-input:checked {
      background-color: #b71217;
      border-color: #b71217;
    }
    .btn-primary {
      background-color: #b71217;
      border: none;
    }
    .btn-primary:hover {
      background-color: #960f13;
    }
    .forgot-password {
      color: #b71217;
      text-decoration: none;
    }
    .forgot-password:hover {
      text-decoration: underline;
    }
    .form-control:focus {
      border-color: #b71217;
      box-shadow: 0 0 0 0.25rem rgba(183, 18, 23, 0.25);
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row min-vh-100">
    
    <!-- Panel Kiri -->
    <div class="col-lg-6 left-panel text-center">
      <div class="logo animate-fade"></div>
      <h6 class="mt-3 animate-fade delay-300">PT. Meissa Berkah Teknologi</h6>
    </div>

    <!-- Panel Kanan -->
    <div class="col-lg-6 d-flex align-items-center justify-content-center">
      <div class="login-card bg-white w-100" style="max-width: 420px;">
        <h4 class="fw-bold text-center">Selamat Datang</h4>
        <p class="text-center text-muted mb-4" style="font-size: 0.9rem;">
          Masukkan username dan password untuk mengakses aplikasi.
        </p>

        <form method="POST" action="">
          <div class="mb-3">
            <label for="username" class="form-label">Nama Pengguna</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Tulis nama pengguna" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan kata sandi" required />
              <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" />
              <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>
            <a href="#" class="forgot-password">Lupa Kata Sandi?</a>
          </div>
          <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>

        <?php if (!empty($error)) : ?>
          <div class="text-danger mt-3 text-center"><?= $error ?></div>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>

<script>
  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      eyeIcon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
      passwordInput.type = "password";
      eyeIcon.classList.replace("bi-eye-slash", "bi-eye");
    }
  }
</script>

</body>
</html>
