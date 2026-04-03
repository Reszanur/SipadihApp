<?php
session_start();
include 'koneksi.php';

// Total diagnosa
$totalDiagnosa = $conn->query("SELECT COUNT(*) AS total FROM riwayat")->fetch_assoc()['total'];

// Total pengguna (asumsikan tabel users ada)
$totalPengguna = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];

// Diagnosa hari ini
$today = $conn->query("
    SELECT COUNT(*) AS total
    FROM riwayat
    WHERE DATE(tgl) = CURDATE()
")->fetch_assoc()['total'];

// Ambil semua riwayat
$riwayat = $conn->query("
    SELECT id_riwayat, nama, umur, jk, gejala, hasil,
           DATE_FORMAT(tgl, '%Y-%m-%d %H:%i') AS tgl
    FROM riwayat
    ORDER BY tgl DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - SiPADIH</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <header class="bg-white shadow py-4 mb-6">
        <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-blue-700">Dashboard Admin - SiPADIH</h1>
            <div class="flex gap-2">
                <a href="data_gejala.php" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Data Gejala</a>
                <a href="logout.php" class="text-sm bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">Logout</a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto">
        <div class="bg-white rounded-xl shadow p-4 mb-6">
            <h2 class="font-semibold mb-3">Ringkasan</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 bg-blue-50 rounded">Total Diagnosa: <strong><?= $totalDiagnosa ?></strong></div>
                <div class="p-4 bg-blue-50 rounded">User Terdaftar: <strong><?= $totalPengguna ?></strong></div>
                <div class="p-4 bg-blue-50 rounded">Diagnosa Hari Ini: <strong><?= $today ?></strong></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="font-semibold mb-3">Riwayat Diagnosa</h3>
            <table class="w-full text-sm border">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="p-2 border">No</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Umur</th>
                        <th class="p-2 border">JK</th>
                        <th class="p-2 border">Gejala</th>
                        <th class="p-2 border">Hasil</th>
                        <th class="p-2 border">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = $riwayat->fetch_assoc()) { ?>
                    <tr class="border-b hover:bg-blue-50">
                        <td class="p-2 border"><?= $no++ ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['umur']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['jk']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['gejala']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['hasil']) ?></td>
                        <td class="p-2 border"><?= $row['tgl'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>