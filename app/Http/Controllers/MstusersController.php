<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;
use Exception;

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
        $pesan = "";
        $mode = "";

        // --- tulis ke file text ---
        $data = $request->employeeid.", (".$request->latitude.",".$request->longitude."), ".
            $request->markas.", ".$tanggal->format("Y-m-d").", ".
            $tanggal->format("H:i:s").", Keterangan";
        $fileName = $tanggal->format("YmdHis") . "_" . $request->employeeid . ".txt";
        //File::put(public_path('/absensi/'.$fileName),$data);

        // --- record di tabel attendance sudah ada? ---
        if ($this->AdaAttendance($request->employeeid)) {
            $mode = "update";
            // --- update tabel attendance ---
            $this->updateActualOut($request->employeeid, $tanggal);
        }
        else {
            $mode = "insert";
            // --- insert ke tabel attendance ---
            $pesan = $this->insertAttendance($request->employeeid, $tanggal, $request->markas, $request->latitude,
                    $request->longitude);
        }

        // --- response ---
        return response()->json([
            'id' => $request->employeeid,
            'tanggal' => $tanggal->format("Y-m-d"),
            'jam' => $tanggal->format("H:i:s"),
            'file' => 'absensi/'.$fileName,
            'pesan' => $pesan,
            'mode' => $mode,
        ]);
    }

    // --- insert data ke tabel Attendance ---
    private function insertAttendance($empId, $tanggal, $markas, $latitude, $longitude)  {
        $pesan = "";
        $attendance = new Attendance();
        $attendance->empid = $empId;
        $attendance->attdate = Carbon::today()->toDateString();
        $attendance->shiftid = 1;
        if ($tanggal instanceof \DateTimeInterface) {
            $attendance->actualin = Carbon::instance($tanggal)->toDateTimeString();
        } else {
            $attendance->actualin = Carbon::parse($tanggal)->toDateTimeString();
        }
        $attendance->latitude = $latitude;
        $attendance->longitude = $longitude;
        $attendance->markas = $markas;
        try {
            $attendance->save();
        }
        catch (Exception $e) {
            $pesan = "error insertAttendance: ".$e->getMessage();
        }
        return $pesan;
    }

    private function adaAttendance($empId): bool  {
        $ada = DB::table('attendance')
            ->where('attdate', '=', new DateTime('today'))
            ->where('empid', '=', $empId)
            ->get();
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
