* ------------ DATA GEJALA ------------ */
const GEJALA = [
  { kode: "G1", nama: "Pandangan mata sering kabur" },
  { kode: "G2", nama: "Jantung terasa berdebar-debar" },
  { kode: "G3", nama: "Sakit kepala" },
  { kode: "G4", nama: "Sulit berkonsentrasi" },
  { kode: "G5", nama: "Nyeri dada" },
  { kode: "G6", nama: "Sesak napas" },
  { kode: "G7", nama: "Mudah lelah" },
  { kode: "G8", nama: "Telinga berdenging" },
  { kode: "G9", nama: "Mimisan" },
  { kode: "G10", nama: "Mual dan muntah" }
];

const BPA = {
  G1: { Primer:0.5, Sekunder:0.2, Pulmonal:0.1, Maligna:0.1 },
  G2: { Primer:0.4, Sekunder:0.3, Pulmonal:0.1, Maligna:0.1 },
  G3: { Primer:0.6, Sekunder:0.1, Pulmonal:0.1, Maligna:0.1 },
  G4: { Primer:0.5, Sekunder:0.2, Pulmonal:0.1, Maligna:0.1 },
  G5: { Primer:0.3, Sekunder:0.3, Pulmonal:0.2, Maligna:0.1 },
  G6: { Primer:0.2, Sekunder:0.2, Pulmonal:0.4, Maligna:0.1 },
  G7: { Primer:0.4, Sekunder:0.2, Pulmonal:0.2, Maligna:0.1 },
  G8: { Primer:0.3, Sekunder:0.3, Pulmonal:0.1, Maligna:0.2 },
  G9: { Primer:0.2, Sekunder:0.2, Pulmonal:0.1, Maligna:0.4 },
  G10:{ Primer:0.2, Sekunder:0.3, Pulmonal:0.1, Maligna:0.3 }
};

const EDU = {
  Primer: [
    "Hipertensi primer biasanya disebabkan oleh faktor genetik dan gaya hidup.",
    "Saran: Kurangi konsumsi garam, jaga berat badan ideal, dan olahraga teratur."
  ],
  Sekunder: [
    "Hipertensi sekunder timbul akibat penyakit lain seperti gangguan ginjal atau hormon.",
    "Saran: Segera periksa ke dokter untuk mencari penyebab pastinya."
  ],
  Pulmonal: [
    "Hipertensi pulmonal terjadi karena tekanan tinggi pada pembuluh darah paru.",
    "Saran: Konsultasikan ke spesialis paru atau jantung."
  ],
  Maligna: [
    "Hipertensi maligna merupakan kondisi gawat darurat medis.",
    "Saran: Segera cari pertolongan medis untuk penanganan cepat."
  ]
};

/* ------------ Render Gejala ------------ */
function renderGejala() {
  const container = document.getElementById('gejalaContainer');
  if (!container) return;
  container.innerHTML = '';
  GEJALA.forEach(g => {
    const el = document.createElement('label');
    el.className = "p-3 border rounded flex items-start gap-2 hover:bg-blue-50 transition";
    el.innerHTML = <input type="checkbox" value="${g.kode}" class="mt-1 accent-blue-600"> <div><strong>${g.kode}</strong> — ${g.nama}</div>;
    container.appendChild(el);
  });
}

/* ------------ LOGIN ------------ */
function login() {
  const u = document.getElementById('username').value.trim();
  const p = document.getElementById('password').value.trim();
  const err = document.getElementById('err');

  if (u === 'admin' && p === 'admin123') {
    localStorage.setItem('role','admin');
    window.location.href = 'admin.html';
    return;
  }
  if (u === 'user' && p === 'user123') {
    localStorage.setItem('role','user');
    window.location.href = 'konsultasi.html';
    return;
  }
  if (err) {
    err.textContent = "Username atau password salah!";
    err.classList.remove('hidden');
  }
}

/* ------------ FUNGSI DEMPSTER-SHAFER ------------ */
function massFromKode(kode) {
  const g = BPA[kode];
  const sum = g.Primer + g.Sekunder + g.Pulmonal + g.Maligna;
  const theta = Math.max(0, +(1 - sum).toFixed(6));
  return { Primer:g.Primer, Sekunder:g.Sekunder, Pulmonal:g.Pulmonal, Maligna:g.Maligna, Theta:theta };
}
function intersect(a,b) {
  if (a === 'Theta') return b;
  if (b === 'Theta') return a;
  if (a === b) return a;
  return null;
}
function combineMass(m1, m2) {
  const result = { Primer:0, Sekunder:0, Pulmonal:0, Maligna:0, Theta:0 };
  let K = 0;
  for (let A in m1) for (let B in m2) {
    const prod = (m1[A]||0) * (m2[B]||0);
    const I = intersect(A,B);
    if (I === null) K += prod;
    else result[I] += prod;
  }
  const denom = 1 - K;
  for (let k in result) result[k] = +(result[k] / denom).toFixed(6);
  return result;
}
function combineList(masses) {
  if (!masses.length) return null;
  return masses.reduce((a,b)=>combineMass(a,b));
}

/* ------------ Diagnosa ------------ */
function processDiagnosis() {
  const checkboxes = [...document.querySelectorAll('#gejalaContainer input[type=checkbox]')];
  const selected = checkboxes.filter(c => c.checked).map(c => c.value);
  const msg = document.getElementById('warningMsg');
  const resultCard = document.getElementById('resultCard');
  const bars = document.getElementById('resultBars');
  const loading = document.getElementById('loadingAnim');

  if (selected.length < 3) {
    msg.textContent = "⚠ Pilih minimal 3 gejala untuk hasil diagnosis yang akurat.";
    msg.classList.remove('hidden');
    return;
  }
  msg.classList.add('hidden');
  resultCard.classList.add('hidden');
  loading.classList.remove('hidden');

  setTimeout(() => {
    const masses = selected.map(k => massFromKode(k));
    const mFinal = combineList(masses);
    const hypo = ['Primer','Sekunder','Pulmonal','Maligna'];
    const percents = {};
    hypo.forEach(h => percents[h] = +( (mFinal[h]||0) * 100 ).toFixed(2));

    bars.innerHTML = '';
    hypo.forEach(h => {
      const pct = percents[h];
      bars.innerHTML += `
        <div class="flex items-center gap-3">
          <div class="w-32 font-semibold">${h}</div>
          <div class="flex-1 bg-gray-100 rounded h-4 overflow-hidden">
            <div style="width:${pct}%" class="bg-blue-600 h-4"></div>
          </div>
          <div class="w-16 text-right font-semibold">${pct}%</div>
        </div>
      `;
    });

    let top = hypo[0];
    hypo.forEach(h => { if (percents[h] > percents[top]) top = h; });

    document.getElementById('kesimpulan').textContent = ${top} (keyakinan ${percents[top].toFixed(2)}%);
    const eduDiv = document.getElementById('edukasi');
    eduDiv.innerHTML = EDU[top].map(t => <p>${t}</p>).join('');

    loading.classList.add('hidden');
    resultCard.classList.remove('hidden');
    resultCard.classList.add('animate-fadeIn');
  }, 2000);
}

/* ------------ Saat Halaman Dimuat ------------ */
window.addEventListener('load', () => renderGejala());