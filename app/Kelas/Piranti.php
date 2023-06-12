<?php


namespace App\Kelas;

use Illuminate\Support\Facades\File;

class Piranti
{
    private function angkaAkhirBulan($sBulan, $iTahun = 2001) {
        switch ($sBulan) {
            case "Januari":
            case "Maret":
            case "Mei":
            case "Juli":
            case "Agustus":
            case "Oktober":
            case "Desember": return 31;
            case 2:
                if ($iTahun % 4 == 0) return 29;
                return 28;
            default: return 30;
        }
    }

    // --- merubah angka integer ke ekuivalen 2 digit stringnya ---
    private function angka2($iAngka) {
        if ($iAngka < 10) return "0".strval($iAngka);
        return strval($iAngka);
    }

    private function namaBulanJadiAngka($sBulan)  {
        switch ($sBulan) {
            case "Januari":
                return "01";
            case "January":
                return "01";
            case "Februari":
                return "02";
            case "February":
                return "02";
            case "Maret":
                return "03";
            case "March":
                return "03";
            case "April":
                return "04";
            case "Mei":
                return "05";
            case "May":
                return "05";
            case "Juni":
                return "06";
            case "June":
                return "06";
            case "Juli":
                return "07";
            case "July":
                return "07";
            case "Agustus":
                return "08";
            case "August":
                return "08";
            case "September":
                return "09";
            case "Oktober":
                return "10";
            case "October":
                return "10";
            case "November":
                return "11";
        }
        return "12";
    }

    public function akhirBulan($sBulan, $iTahun)  {
        $iAngka = $this->angkaAkhirBulan($sBulan, $iTahun);
        $sAngka = $this->angka2($iAngka);
        $sAngkaBulan = $this->namaBulanJadiAngka($sBulan);
        return strval(round($iTahun))."-".$sAngkaBulan."-".$sAngka;
    }

    public function awalBulan($sBulan, $iTahun) {
        $sAngkaBulan = $this->namaBulanJadiAngka($sBulan);
        return strval(round($iTahun))."-".$sAngkaBulan."-"."01";
    }

    public function tulisKeFile($data, $fileName) {
        $tz = 'Asia/Jakarta';
        $tanggal = new \DateTime("now", new \DateTimeZone($tz));
        $data = "\n\n".$tanggal->format("Y-m-d H:i:s").": \n".$data;
        // --- tulis ke file text ---
        file_put_contents(public_path('/logs/'.$fileName), $data, FILE_APPEND);
    }
}
