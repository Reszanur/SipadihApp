<?php
session_start();
include 'koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM gejala WHERE id_gejala = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
header('Location: data_gejala.php');
exit;
?>