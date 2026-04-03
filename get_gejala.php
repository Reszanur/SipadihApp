<?php
session_start();
include 'koneksi.php';

$query = "SELECT * FROM gejala";
$result = $conn->query($query);

$gejala = array();
while ($row = $result->fetch_assoc()) {
  $gejala[] = array(
    'id' => $row['id'],
    'nama_gejala' => $row['nama_gejala'],
    'deskripsi' => $row['deskripsi']
  );
}

echo json_encode($gejala);
?>