<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class MstusersController extends Controller
{
    public function fileabsen(Request $request) {
        $tz = 'Asia/Jakarta';
        $tanggal = new DateTime("now", new DateTimeZone($tz));

        // --- tulis ke file text ---
        $data = $request->employeeid.", (".$request->latitude.",".$request->longitude."), ".
                $request->markas.", ".$tanggal->format("Y-m-d").", ".
                $tanggal->format("H:i:s").", Keterangan";
        $fileName = $tanggal->format("YmdHis") . "_" . $request->employeeid . ".txt";
        File::put(public_path('/absensi/'.$fileName), $data);

        // --- response ---
        return response()->json([
            'id' => $request->employeeid,
            'tanggal' => $tanggal->format("Y-m-d"),
            'jam' => $tanggal->format("H:i:s"),
            'file' => 'absensi/'.$fileName
        ]);
    }

    public function fileabsenjne(Request $request)  {
        $tz = 'Asia/Jakarta';
        $tanggal = new DateTime("now", new DateTimeZone($tz));

        // --- tulis ke file text ---
        $data = $request->employeeid.", (".$request->latitude.",".$request->longitude."), ".
            $request->markas.", ".$tanggal->format("Y-m-d").", ".
            $tanggal->format("H:i:s").", Keterangan";
        $fileName = $tanggal->format("YmdHis") . "_" . $request->employeeid . ".txt";
        File::put(public_path('/absensi/'.$fileName),$data);

        // --- record di tabel attendance sudah ada? ---
        if ($this->AdaAttendance($request->employeeid)) {
            // --- update tabel attendance ---
            $this->updateActualOut($request->employeeid, $tanggal);
        }
        else {
            // --- insert ke tabel attendance ---
            $this->insertAttendance($request->employeeid, $tanggal, $request->markas, $request->latitude,
                $request->longitude);
        }

        // --- response ---
        return response()->json([
            'id' => $request->employeeid,
            'tanggal' => $tanggal->format("Y-m-d"),
            'jam' => $tanggal->format("H:i:s"),
            'file' => 'absensi/'.$fileName
        ]);
    }

    // --- insert data ke tabel Attendance ---
    private function insertAttendance($empId, $tanggal, $markas, $latitude, $longitude)  {
        DB::table('attendance')->insert(
            array(
                'empid' => $empId,
                'attdate' => new DateTime('today'),
                'shiftid' => '1',
                'actualin' => $tanggal,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'markas' => $markas
            )
        );
    }

    private function adaAttendance($empId): bool  {
        $ada = DB::table('attendance')->where('attdate', new DateTime('today'))->get();
        if ($ada->count() > 0) return true;
        return false;
    }

    private function updateActualOut($empId, $tanggal) {
        $affected = DB::table('attendance')
            ->where('attdate', new DateTime('today'))
            ->where('empid', $empId)
            ->update(['actualout' => $tanggal]);
    }

    

}
