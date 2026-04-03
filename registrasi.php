<?php
include 'koneksi.php';

$error = ''; // untuk menampung pesan error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $umur     = $_POST['umur'];
    $jk       = $_POST['jk'];
    $noTelp   = $_POST['noTelp'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek apakah nomor sudah terdaftar
    $stmt = $conn->prepare("SELECT id FROM users WHERE noTelp = ?");
    $stmt->bind_param("s", $noTelp);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Nomor telepon sudah terdaftar!";
    } else {
        $query = "INSERT INTO users (nama, umur, jk, noTelp, password) VALUES (?, ?, ?, ?, ?)";
        $stmt  = $conn->prepare($query);
        $stmt->bind_param("sisss", $nama, $umur, $jk, $noTelp, $password);
        $stmt->execute();

        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi | SIPADIH</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2966/2966485.png" type="image/png">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-300">

  <div class="bg-white/80 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-96">
    <h1 class="text-3xl font-bold text-center text-blue-800 mb-6">SIPADIH</h1>
    <h2 class="text-lg text-center text-gray-700 mb-4">Buat Akun Baru</h2>

    <?php if ($error): ?>
      <div class="mb-4 p-2 bg-red-100 text-red-600 rounded-lg text-sm">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form class="space-y-4" action="" method="post">
      <div>
        <label class="block text-gray-700 font-semibold">Nama Lengkap</label>
        <input type="text" name="nama" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Umur</label>
        <input type="number" name="umur" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Jenis Kelamin</label>
        <select name="jk" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
          <option value="">-- Pilih Jenis Kelamin --</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Nomor Telepon</label>
        <input type="tel" name="noTelp" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Password</label>
        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 rounded-lg transition">Daftar</button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
      Sudah punya akun?
      <a href="login.php" class="text-blue-700 font-semibold hover:underline">Masuk di sini</a>
    </p>
  </div>

</body>
</html>