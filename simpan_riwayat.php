<?php
include 'koneksi.php';

if (isset($_POST['nama']) && isset($_POST['gejala']) && isset($_POST['hasil'])) {
  $nama = $_POST['nama'];
  $gejala = $_POST['gejala'];
  $hasil = $_POST['hasil'];

  $query = "INSERT INTO riwayat_diagnosa (nama, gejala, hasil, tanggal) VALUES ('$nama', '$gejala', '$hasil', CURDATE())";
  $result = $conn->query($query);

  if ($result) {
    echo "Data berhasil disimpan";
  } else {
    echo "Gagal menyimpan data";
  }
}
?>