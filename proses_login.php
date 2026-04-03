<?php
session_start();
include 'koneksi.php';

if (isset($_POST['nama'], $_POST['password'])) {
    $nama = $_POST['nama'];
    $pwd  = $_POST['password'];

    // Prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE nama = ?");
    $stmt->bind_param('s', $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pwd, $row['password'])) {
            // Login berhasil
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: konsultasi.php');
            }
            exit;
        } else {
            // Password salah
            $_SESSION['login_error'] = 'Password salah!';
        }
    } else {
        // Nama tidak ditemukan
        $_SESSION['login_error'] = 'Nama tidak ditemukan!';
    }

    // Kembali ke halaman login
    header('Location: login.php');
    exit;
}
?>