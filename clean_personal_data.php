<?php
// clean_personal_data.php

$inputFile  = __DIR__ . '/personal_data.csv';
$outputFile = __DIR__ . '/personal_data_clean.csv';

function normalizeDate($value) {
    $value = trim($value);
    if ($value === '') {
        return null;
    }

    // kalau sudah format YYYY-MM-DD, biarin aja
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
        return $value;
    }

    // format MM-DD-YYYY
    $date = DateTime::createFromFormat('m-d-Y', $value);
    if ($date !== false) {
        return $date->format('Y-m-d');
    }

    // format DD-MM-YYYY
    $date = DateTime::createFromFormat('d-m-Y', $value);
    if ($date !== false) {
        return $date->format('Y-m-d');
    }

    return $value; // biarin aja kalau gagal parse
}

if (!file_exists($inputFile)) {
    die("File $inputFile tidak ditemukan.\n");
}

$in  = fopen($inputFile, 'r');
$out = fopen($outputFile, 'w');

if (!$in || !$out) {
    die("Gagal membuka file input/output.\n");
}

// --- ambil header ---
$header = fgetcsv($in);
fputcsv($out, $header);

// --- proses baris data ---
while (($row = fgetcsv($in)) !== false) {
    $cleanedRow = [];
    foreach ($row as $val) {
        // hapus semua tanda kutip tunggal & ganda
        $clean = str_replace(["'", '"'], '', $val);

        // hapus spasi
        $clean = trim($clean);

        // kalau kosong → NULL
        if ($clean === '' || strtoupper($clean) === 'NULL') {
            $cleanedRow[] = null;
            continue;
        }

        // coba parse tanggal
        $maybeDate = normalizeDate($clean);
        $cleanedRow[] = $maybeDate;
    }
    fputcsv($out, $cleanedRow);
}

fclose($in);
fclose($out);

echo "Selesai! Hasil tersimpan di $outputFile\n";
