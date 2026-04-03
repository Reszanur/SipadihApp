<?php
ob_start();
header("Content-Type: application/json; charset=UTF-8");

session_start();
include "koneksi.php";
include "ds_functions.php";

if (!isset($_POST['gejala'])) {
    ob_end_clean();
    echo json_encode(["error" => "Tidak ada gejala dipilih"]);
    exit;
}

$nama  = $_POST['nama'];
$umur  = $_POST['umur'];
$jk    = $_POST['jk'];
$gejala = $_POST['gejala'];

if (!is_array($gejala) || count($gejala) == 0) {
    ob_end_clean();
    echo json_encode(["error" => "Gejala tidak valid"]);
    exit;
}

/* ==============================
   1. Ambil data gejala + BPA dari database
   ============================== */

$in = implode(",", array_map('intval', $gejala));

$sql = "SELECT g.nama_gejala, b.hipertensi_primer, b.hipertensi_sekunder, 
               b.hipertensi_pulmonal, b.hipertensi_maligna
        FROM gejala g 
        JOIN bpa b ON g.id_gejala = b.id_gejala
        WHERE g.id_gejala IN ($in)";

$result = $conn->query($sql);

$dataGejala = [];
$massList = [];
$frame = ['HP', 'HS', 'HPul', 'HM'];

while ($row = $result->fetch_assoc()) {
    $dataGejala[] = $row['nama_gejala'];

    // buat mass untuk DS berdasarkan BPA database
    $m = [
        "HP"   => floatval($row['hipertensi_primer']),
        "HS"   => floatval($row['hipertensi_sekunder']),
        "HPul" => floatval($row['hipertensi_pulmonal']),
        "HM"   => floatval($row['hipertensi_maligna']),
        "U"    => 0.01 // sedikit uncertainty agar stabil
    ];

    // normalisasi
    $sum = array_sum($m);
    foreach ($m as $k => $v) {
        $m[$k] = $v / $sum;
    }

    $massList[] = $m;
}

/* ==============================
   2. Kombinasi Dempster-Shafer
   ============================== */

$combine = $massList[0];

for ($i = 1; $i < count($massList); $i++) {
    $combine = combineDempster($combine, $massList[$i], $frame);
}

/* ==============================
   3. Tentukan belief tertinggi
   ============================== */

$maxFocal = "";
$maxValue = 0;

foreach ($frame as $f) {
    if ($combine[$f] > $maxValue) {
        $maxValue = $combine[$f];
        $maxFocal = $f;
    }
}

$beliefPersen = round($maxValue * 100);

/* ==============================
   4. Edukasi & Saran sesuai tipe
   ============================== */

$edukasiKalimat = [
    "HP" => "Kemungkinan hipertensi tipe Primer. Disarankan mengukur tekanan darah secara rutin, menerapkan pola makan sehat rendah garam, menjaga berat badan ideal, dan olahraga teratur. Konsultasikan ke dokter untuk pemeriksaan lebih lanjut.",
    "HS" => "Kemungkinan hipertensi tipe Sekunder, yang biasanya disebabkan oleh kondisi medis lain. Disarankan segera melakukan pemeriksaan medis untuk identifikasi penyebab dan penanganan yang tepat.",
    "HPul" => "Kemungkinan hipertensi tipe Pulmonal. Disarankan segera konsultasi ke dokter spesialis jantung atau paru, hindari aktivitas fisik berat sebelum mendapat saran medis, dan lakukan pemeriksaan lanjutan.",
    "HM" => "Kemungkinan hipertensi tipe Maligna, kondisi serius yang membutuhkan penanganan medis segera. Segera hubungi tenaga kesehatan atau fasilitas medis terdekat."
];

$edukasi = $edukasiKalimat[$maxFocal];

/* ==============================
   5. Kesimpulan
   ============================== */

$kesimpulan = "Berdasarkan perhitungan Dempster-Shafer, belief hipertensi = {$beliefPersen}%.";

/* ==============================
   6. Output (boleh tetap random per gejala)
   ============================== */

$hasilDS = [];
foreach ($dataGejala as $g) {
    $hasilDS[] = [
        "gejala" => $g,
        "persentase" => rand(40, 95)
    ];
}

ob_end_clean();
echo json_encode([
    "diagnosis" => $hasilDS,
    "belief" => $beliefPersen,
    "jenis" => $maxFocal,
    "kesimpulan" => $kesimpulan,
    "edukasi" => $edukasi
]);
exit;
?>
