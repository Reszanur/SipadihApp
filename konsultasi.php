<?php
session_start();
include 'koneksi.php';

$query = "SELECT * FROM gejala";
$result = $conn->query($query);
if (!$result) die("Query gagal: " . $conn->error);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konsultasi | SIPADIH</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>
<body class="bg-gradient-to-b from-blue-50 to-blue-100 min-h-screen flex flex-col">

<nav class="bg-blue-700 text-white shadow-lg">
  <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold">SIPADIH</h1>
    <a href="logout.php" class="bg-white text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-100 font-semibold">Logout</a>
  </div>
</nav>

<main class="flex-grow max-w-5xl mx-auto bg-white shadow-md rounded-xl mt-10 p-8">
  <h2 class="text-3xl font-bold text-blue-800 mb-6 text-center">Konsultasi Diagnosis Hipertensi</h2>

  <div class="grid md:grid-cols-3 gap-4 mb-6">
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
      <input id="nama" type="text" placeholder="Nama lengkap" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Umur</label>
      <input id="umur" type="number" placeholder="Umur" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
      <select id="jk" class="w-full border rounded-lg px-3 py-2">
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
    </div>
  </div>

  <hr class="my-6 border-gray-300">

  <h3 class="text-xl font-semibold text-blue-700 mb-4">Pilih Gejala:</h3>
  <div id="gejalaList" class="space-y-2 max-h-60 overflow-y-auto border rounded-lg p-3">
    <?php while ($row = $result->fetch_assoc()) { ?>
      <label class="flex items-center space-x-2 cursor-pointer hover:bg-blue-50 p-1 rounded">
        <input type="checkbox" name="gejala[]" value="<?= $row['id_gejala']; ?>" class="rounded text-blue-600">
        <span><?= $row['nama_gejala']; ?></span>
      </label>
    <?php } ?>
  </div>

  <div class="text-center mt-8">
    <button id="btnProcess" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-lg">Proses Diagnosis</button>
    <button id="btnReset" class="bg-gray-200 hover:bg-gray-300 px-6 py-3 rounded-lg ml-3">Reset</button>
  </div>

  <div id="resultCard" class="hidden mt-10 p-6 bg-blue-50 border border-blue-200 rounded-xl">
    <h3 class="text-2xl font-bold text-blue-800 mb-3">Hasil Diagnosis</h3>
    <div id="resultBars" class="space-y-3 mb-4"></div>
    <p><strong>Kesimpulan:</strong> <span id="kesimpulan"></span></p>

    <div class="mt-4 bg-white p-4 rounded-lg">
      <h4 class="font-semibold text-blue-700 mb-2">Edukasi & Saran:</h4>
      <div id="edukasi" class="text-gray-700 leading-relaxed"></div>
    </div>

    <div class="text-center mt-6">
      <button id="btnPrint" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">Cetak Hasil</button>
    </div>
  </div>
</main>

<footer class="bg-blue-700 text-white text-center py-4 mt-10">
  <p>2025 SIPADIH | Sistem Pakar Diagnosis Hipertensi</p>
</footer>

<script>
document.getElementById('btnProcess').addEventListener('click', processDiagnosis);
document.getElementById('btnReset').addEventListener('click', resetForm);
document.getElementById('btnPrint').addEventListener('click', printResult);

function processDiagnosis() {
  const nama = document.getElementById('nama').value.trim();
  const umur = document.getElementById('umur').value;
  const jk   = document.getElementById('jk').value;
  const gejala = $('[name="gejala[]"]:checked').map((_,c)=>c.value).get();

  if (!nama || !umur || !jk || gejala.length === 0) {
    alert("Harap isi semua field!");
    return;
  }

  const formData = new FormData();
  formData.append('nama', nama);
  formData.append('umur', umur);
  formData.append('jk', jk);
  gejala.forEach(g => formData.append('gejala[]', g));

  fetch('proses_diagnosis.php', {
    method: 'POST',
    body: formData
  })
  .then(r => r.text())
  .then(text => {
    console.log("RESPON PHP:", text);
    let res = JSON.parse(text);
    tampilkanHasil(res);
  })
  .catch(err => alert("Terjadi kesalahan: " + err));
}

function tampilkanHasil(res) {
  document.getElementById('resultCard').classList.remove('hidden');
  const bars = document.getElementById('resultBars');
  bars.innerHTML = '';

  res.diagnosis.forEach(item => {
    bars.innerHTML += `
      <div class="flex justify-between items-center mb-2">
        <span>${item.gejala}</span>
        <div class="w-1/2 bg-gray-200 rounded-full h-2">
          <div class="bg-blue-600 h-2 rounded-full" style="width:${item.persentase}%"></div>
        </div>
        <span>${item.persentase}%</span>
      </div>`;
  });

  document.getElementById('kesimpulan').textContent = res.kesimpulan;
  document.getElementById('edukasi').innerHTML = res.edukasi;
}

function resetForm() {
  document.getElementById('nama').value = '';
  document.getElementById('umur').value = '';
  document.getElementById('jk').value = '';
  document.getElementsByName('gejala[]').forEach(cb => cb.checked = false);
  document.getElementById('resultCard').classList.add('hidden');
}

function printResult() {
  const printContents = document.getElementById('resultCard').innerHTML;
  const original = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = original;
}
</script>
</body>
</html>
