<?php
session_start();
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | SIPADIH</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2966/2966485.png" type="image/png">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-300">

  <div class="bg-white/80 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-96">
    <h1 class="text-3xl font-bold text-center text-blue-800 mb-6"> SIPADIH</h1>
    <h2 class="text-lg text-center text-gray-700 mb-4">Masuk ke Akun Anda</h2>

    <?php if (!empty($error)) { ?>
      <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
        <?= $error ?>
      </div>
    <?php } ?>

    <form id="loginForm" class="space-y-4" action="proses_login.php" method="post">
      <div>
        <label class="block text-gray-700 font-semibold">Nama Lengkap</label>
        <input type="text" name="nama" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Password</label>
        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 rounded-lg transition">Masuk</button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
      Belum punya akun?
      <a href="registrasi.php" class="text-blue-700 font-semibold hover:underline">Daftar di sini</a>
      <span class="text-gray-600 mx-2">|</span>
      <a href="lupa_password.php" class="text-blue-700 font-semibold hover:underline">Lupa Password</a>
    </p>
  </div>

</body>
</html>