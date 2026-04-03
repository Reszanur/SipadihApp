<?php
// ds_functions.php
// Fungsi combineDempster yang mengolah massa pada focal elements sederhana:
// focal elements: 'HP', 'HS', 'HPul', 'HM', 'U'
// catatan: implementasi ini menganggap focal elements adalah singletons + U (uncertainty)

function combineDempster(array $m1, array $m2, array $frame): array
{
    // pastikan semua key ada
    foreach ($frame as $f) {
        if (!isset($m1[$f])) $m1[$f] = 0.0;
        if (!isset($m2[$f])) $m2[$f] = 0.0;
    }
    if (!isset($m1['U'])) $m1['U'] = 0.0;
    if (!isset($m2['U'])) $m2['U'] = 0.0;

    $result = [];
    $conflict = 0.0;

    // iterasi semua pasangan focal element
    $keys1 = array_keys($m1);
    $keys2 = array_keys($m2);

    foreach ($keys1 as $A) {
        foreach ($keys2 as $B) {
            $v1 = (float) $m1[$A];
            $v2 = (float) $m2[$B];
            if ($v1 == 0.0 || $v2 == 0.0) continue;

            $intersection = intersectSets($A, $B, $frame);

            if ($intersection === null) {
                // konflik
                $conflict += $v1 * $v2;
            } else {
                if (!isset($result[$intersection])) $result[$intersection] = 0.0;
                $result[$intersection] += $v1 * $v2;
            }
        }
    }

    $K = 1.0 - $conflict;
    if ($K <= 0) {
        // total konflik. fallback: kembalikan m1 (atau m2) yang distandarkan
        // untuk menghindari pembagian oleh nol, kita gabungkan secara sederhana: ambil m1 proporsional
        $norm = [];
        $sum = array_sum($m1);
        if ($sum == 0) $sum = 1.0;
        foreach ($m1 as $k => $v) $norm[$k] = $v / $sum;
        return $norm;
    }

    // normalisasi result dengan faktor 1/(1-conflict)
    foreach ($result as $k => $v) {
        $result[$k] = $v / $K;
    }

    // Pastikan semua focal element ada di hasil (termasuk 'U')
    foreach ($frame as $f) {
        if (!isset($result[$f])) $result[$f] = 0.0;
    }
    if (!isset($result['U'])) $result['U'] = 0.0;

    // kecilkan error pembulatan
    foreach ($result as $k => $v) {
        $result[$k] = max(0.0, (float)$v);
    }

    return $result;
}

function intersectSets(string $A, string $B, array $frame): ?string
{
    // jika salah satu adalah uncertainty 'U', intersection adalah yang lain
    if ($A === 'U' && $B === 'U') return 'U';
    if ($A === 'U' && in_array($B, $frame)) return $B;
    if ($B === 'U' && in_array($A, $frame)) return $A;

    // jika sama singleton
    if ($A === $B && in_array($A, $frame)) return $A;

    // konflik (dua singleton berbeda)
    return null;
}
