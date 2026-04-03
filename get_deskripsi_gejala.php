<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT edukasi, saran FROM edukasi_saran WHERE id_gejala = '$id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<h4 class="font-semibold text-blue-700 mb-2">Edukasi:</h4>';
        echo '<p>' . $row['edukasi'] . '</p>';
        echo '<h4 class="font-semibold text-blue-700 mb-2 mt-4">Saran:</h4>';
        echo '<p>' . $row['saran'] . '</p>';
    } else {
        echo 'Edukasi dan saran tidak ditemukan';
    }
} else {
    echo 'ID gejala tidak ditemukan';
}
?>