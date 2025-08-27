<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = 200;
        $results = Attendance::all();
        if (count($results) == 0) $status = 404;
        $json = json_encode($results);
        unset($results);
        return response($json, $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sesuatu = new Attendance();
        $sesuatu->empid = $request->empid;
        $sesuatu->attdate = $request->attdate;
        $sesuatu->shiftid = $request->shiftid;
        $sesuatu->actualin = $request->actualin;
        $sesuatu->actualout = $request->actualout;
        $sesuatu->late = $request->late;
        $sesuatu->early = $request->early;
        $sesuatu->ottotal = $request->ottotal;
        $sesuatu->notes = $request->notes;
        $sesuatu->latitude = $request->latitude;
        $sesuatu->longitude = $request->longitude;
        $sesuatu->markas = $request->markas;
        $sesuatu->suhu = $request->suhu;
        if ($sesuatu->save()){
            $pesan = "Sukses insert data attendance";
        }
        else {
            $pesan = "Gagal insert data attendance";
        }

        // --- response ---
        return response() -> json([
            'id' => $sesuatu->id,
            'pesan' => $pesan
        ], 201)->header('Access-Control-Allow-Origin', '*')->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = 200;
        $result = Attendance::where("id", "=", $id)->first();
        if ($result == null) $status = 404;
        $json = json_encode($result);
        unset($result);
        return response($json, $status)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $status = 200;
        $sesuatu = Attendance::find($id);
        // --- ada recordnya ---
        if ($sesuatu != null) {
            $sesuatu->empid = $request->empid;
            $sesuatu->attdate = $request->attdate;
            $sesuatu->shiftid = $request->shiftid;
            $sesuatu->actualin = $request->actualin;
            $sesuatu->actualout = $request->actualout;
            $sesuatu->late = $request->late;
            $sesuatu->early = $request->early;
            $sesuatu->ottotal = $request->ottotal;
            $sesuatu->notes = $request->notes;
            $sesuatu->inputdate = $request->inputdate;
            $sesuatu->editdate = $request->editdate;
            $sesuatu->latitude = $request->latitude;
            $sesuatu->longitude = $request->longitude;
            $sesuatu->markas = $request->markas;
            $sesuatu->suhu = $request->suhu;
            if ($sesuatu->save()){
                $pesan = "Sukses update data attendance";
            }
            else {
                $pesan = "Gagal update data attendance";
            }
        }
        // --- tidak ada recordnya ---
        else {
            $status = 404;
            $pesan = "Data yang dimaksud tidak ditemukan!";
        }
        // --- response ---
        return response()->json([
            'id' => $id,
            'pesan' => $pesan
        ], $status)->header('Access-Control-Allow-Origin', '*')->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = 200;
        $pesan = "kosong";
        $sesuatu = Attendance::find($id);
        if ($sesuatu == null) $status = 404;
        if ($sesuatu->delete()) {
            $pesan = "Sukses delete data attendance";
        }
        else {
            $pesan = "Gagal delete data attendance";
        }

        // --- response ---
        return response()->json([
            'id' => $id,
            'pesan' => $pesan
        ], $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    public function list(Request $request)  {
        $status = 200;
        $tglAwal  = $request->filled('tglAwal') ? $request->tglAwal : date("Y-m-01");
        $tglAkhir = $request->filled('tglAkhir') ? $request->tglAkhir : date("Y-m-d");
        $kueri = DB::table("attendance as a")
            ->leftJoin("emp as e", "a.empid", "=", "e.empid")
            ->select('a.empid', 'e.empname', 'e.atasan1', 'a.attdate', 'a.actualin', 'a.actualout',
                'a.late', 'a.early', 'a.ottotal', 'a.latitude', 'a.longitude', 'a.markas', 'a.suhu')
            ->where(function ($q) use ($request) {
                $q->where('a.empid', $request->empId)
                    ->orWhere('e.atasan1', $request->empId);
            })
            ->whereBetween('a.attdate', [$tglAwal, $tglAkhir]);
        //dd($kueri->toRawSql());
        try {
            $results = $kueri->get();
            if ($results->isEmpty()) {
                $status = 404;
            }
        }
        catch (Exception $e) {
            $status = 500;
            Log::error('Query gagal', [
                'sql' => method_exists($kueri, 'toRawSql') ? $kueri->toRawSql() : $kueri->toSql(),
                'error' => $e->getMessage(),
            ]);
            $results = [
                "empid" => $request->empId,
                "tglAwal" => $tglAwal,
                "tglAkhir" => $tglAkhir,
                "pesan" => "error attendanceController.list: ".$e->getMessage(),
            ];
        }
        return response()->json($results, $status)
            ->header('Access-Control-Allow-Origin', '*');
    }                   // --- end of function list ---
}
