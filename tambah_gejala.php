<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
  $nama_gejala = $_POST['nama_gejala'];
  $deskripsi = $_POST['deskripsi'];

  $query = "INSERT INTO gejala (nama_gejala, deskripsi) VALUES ('$nama_gejala', '$deskripsi')";
  $result = $conn->query($query);

  if ($result) {
    echo "<script>alert('Data gejala berhasil ditambahkan!');</script>";
    header("Location: data_gejala.php");
  } else {
    echo "<script>alert('Gagal menambahkan data gejala!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Tambah Gejala - SiPADIH</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<header class="bg-white shadow py-4">
  <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-blue-700">Tambah Gejala - SiPADIH</h1>
    <div class="flex items-center gap-2">
      <a href="data_gejala.php" class="text-sm bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kembali ke Data Gejala</a>
      <a href="admin.php" class="text-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Kembali ke Dashboard</a>
    </div>
  </div>
</header>

  <main class="max-w-5xl mx-auto p-6">
    <div class="bg-white rounded-xl shadow p-4 mb-4">
      <h3 class="font-semibold mb-3">Tambah Data Gejala</h3>
      <form action="" method="post">
        <div class="mb-4">
          <label for="nama_gejala" class="block text-sm font-medium text-gray-700">Nama Gejala</label>
          <input type="text" id="nama_gejala" name="nama_gejala" class="block w-full p-2 border border-gray-300 rounded-md">
        </div>
        <div class="mb-4">
          <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
          <textarea id="deskripsi" name="deskripsi" class="block w-full p-2 border border-gray-300 rounded-md"></textarea>
        </div>
        <button type="submit" name="tambah" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah</button>
      </form>
    </div>
  </main>

  <script src="script.js"></script>
</body>
</html>