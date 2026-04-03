<?php
session_start();
include 'koneksi.php';

$query = "SELECT * FROM gejala ORDER BY CAST(SUBSTRING(id_gejala, 2) AS UNSIGNED) ASC";
$result = $conn->query($query);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Data Gejala - SiPADIH</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">
  <header class="bg-white shadow py-4">
    <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
      <h1 class="text-xl font-semibold text-blue-700">Data Gejala - SiPADIH</h1>
      <div class="flex items-center gap-2">
        <a href="tambah_gejala.php" class="text-sm bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Gejala</a>
        <a href="admin.php" class="text-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Kembali ke Dashboard</a>
      </div>
    </div>
  </header>

  <main class="max-w-5xl mx-auto p-6">
    <div class="bg-white rounded-xl shadow p-4">
      <h3 class="font-semibold mb-3">Data Gejala</h3>
      <table class="w-full text-sm border">
        <thead class="bg-blue-50">
          <tr>
            <th class="p-2 border">No</th>
            <th class="p-2 border">Kode Gejala</th>
            <th class="p-2 border">Nama Gejala</th>
            <th class="p-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody id="gejalaBody">
          <?php
          if ($result->num_rows > 0) {
            $no = 1;
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td class='p-2 border'>" . $no++ . "</td>";
              echo "<td class='p-2 border'>" . $row["id_gejala"] . "</td>";
              echo "<td class='p-2 border'><span id='nama_gejala_" . $row["id_gejala"] . "'>" . $row["nama_gejala"] . "</span><input type='text' id='edit_nama_gejala_" . $row["id_gejala"] . "' value='" . $row["nama_gejala"] . "' class='hidden w-full border rounded-lg px-3 py-2'></td>";
              echo "<td class='p-2 border flex justify-center gap-2'>";
              echo "<button id='edit_" . $row["id_gejala"] . "' onclick='editGejala(\"" . $row["id_gejala"] . "\")' class='text-sm bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Edit</button>";
              echo "<button id='simpan_" . $row["id_gejala"] . "' onclick='simpanGejala(\"" . $row["id_gejala"] . "\")' class='hidden text-sm bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>Simpan</button>";
              echo "<a href='hapus_gejala.php?id_gejala=" . $row["id_gejala"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='text-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Hapus</a>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='4' class='p-2 border'>Tidak ada data</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    function editGejala(id) {
      document.getElementById('nama_gejala_' + id).classList.add('hidden');
      document.getElementById('edit_nama_gejala_' + id).classList.remove('hidden');
      document.getElementById('edit_' + id).classList.add('hidden');
      document.getElementById('simpan_' + id).classList.remove('hidden');
    }

    function simpanGejala(id) {
      const namaGejala = document.getElementById('edit_nama_gejala_' + id).value.trim();

      if (namaGejala) {
        $.ajax({
          type: 'POST',
          url: 'simpan_gejala.php',
          data: {id_gejala: id, nama_gejala: namaGejala},
          success: function(data) {
            document.getElementById('nama_gejala_' + id).innerHTML = namaGejala;
            document.getElementById('nama_gejala_' + id).classList.remove('hidden');
            document.getElementById('edit_nama_gejala_' + id).classList.add('hidden');
            document.getElementById('edit_' + id).classList.remove('hidden');
            document.getElementById('simpan_' + id).classList.add('hidden');
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      } else {
        alert('Please fill in all fields');
      }
    }
  </script>
</body>
</html>