<?php
include 'koneksi.php';

$id = $_POST['id'];
$namaGejala = $_POST['nama_gejala'];
$deskripsi = $_POST['deskripsi'];

$query = "UPDATE gejala SET nama_gejala = '$namaGejala', deskripsi = '$deskripsi' WHERE id = '$id'";
$conn->query($query);
?>