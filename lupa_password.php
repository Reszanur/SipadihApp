<?php
// Koneksi ke database
include 'koneksi.php';

if (isset($_POST['nama']) && isset($_POST['noTelp']) && isset($_POST['passwordBaru']) && isset($_POST['konfirmasiPassword'])) {
  $nama = $_POST['nama'];
  $noTelp = $_POST['noTelp'];
  $passwordBaru = $_POST['passwordBaru'];
  $konfirmasiPassword = $_POST['konfirmasiPassword'];

  if ($passwordBaru !== $konfirmasiPassword) {
    echo "Password baru dan konfirmasi password tidak cocok!";
  } else {
    $query = "SELECT * FROM users WHERE nama = '$nama' AND noTelp = '$noTelp'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      $hashed_password = password_hash($passwordBaru, PASSWORD_DEFAULT);
      $query = "UPDATE users SET password = '$hashed_password' WHERE nama = '$nama' AND noTelp = '$noTelp'";
      $conn->query($query);
      echo "Password berhasil direset!";
      header('Location: login.php');
    } else {
      echo "Nama atau nomor telepon tidak ditemukan!";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password | SIPADIH</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2966/2966485.png" type="image/png">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-300">

  <div class="bg-white/80 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-96">
    <h1 class="text-3xl font-bold text-center text-blue-800 mb-6"> SIPADIH</h1>
    <h2 class="text-lg text-center text-gray-700 mb-4">Lupa Password</h2>

    <form id="lupaPasswordForm" class="space-y-4" action="" method="post">
      <div>
        <label class="block text-gray-700 font-semibold">Nama Lengkap</label>
        <input type="text" name="nama" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Nomor Telepon</label>
        <input type="tel" name="noTelp" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Password Baru</label>
        <input type="password" name="passwordBaru" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Konfirmasi Password Baru</label>
        <input type="password" name="konfirmasiPassword" class="w-100 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 rounded-lg transition">Reset Password</button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
      <a href="login.php" class="text-blue-700 font-semibold hover:underline">Kembali ke halaman login</a>
    </p>
  </div>

</body>
</html>