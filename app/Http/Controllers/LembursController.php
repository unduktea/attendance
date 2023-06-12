<?php

namespace App\Http\Controllers;

use App\Kelas\Piranti;
use Illuminate\Http\Request;
use App\Models\Lemburs;
use Illuminate\Support\Facades\DB;
use DateTime;

class LembursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = 200;
        $results = Lemburs::all();
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
        $sesuatu = new Lemburs();
        $sesuatu->empid = $request->empid;
        $sesuatu->tanggal = $request->tanggal;
        $sesuatu->shift = $request->shift;
        $sesuatu->over_before = $request->over_before;
        $sesuatu->over_after = $request->over_after;
        $sesuatu->break_before = $request->break_before;
        $sesuatu->break_after = $request->break_after;
        $sesuatu->kompensation = $request->kompensation;
        $sesuatu->reason = $request->reason;
        $sesuatu->status = $request->status;
        if ($sesuatu->save()){
            $pesan = "Sukses insert data lemburs";
        }
        else {
            $pesan = "Gagal insert data lemburs";
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
        $result = Lemburs::where("id", "=", $id)->first();
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
        $sesuatu = Lemburs::find($id);
        // --- ada recordnya ---
        if ($sesuatu != null) {
            $sesuatu->id = $request->id;
            $sesuatu->empid = $request->empid;
            $sesuatu->tanggal = $request->tanggal;
            $sesuatu->shift = $request->shift;
            $sesuatu->over_before = $request->over_before;
            $sesuatu->over_after = $request->over_after;
            $sesuatu->break_before = $request->break_before;
            $sesuatu->break_after = $request->break_after;
            $sesuatu->kompensation = $request->kompensation;
            $sesuatu->reason = $request->reason;
            $sesuatu->status = $request->status;
            if ($sesuatu->save()){
                $pesan = "Sukses update data lemburs";
            }
            else {
                $pesan = "Gagal update data lemburs";
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
        $sesuatu = Lemburs::find($id);
        if ($sesuatu == null) $status = 404;
        if ($sesuatu->delete()) {
            $pesan = "Sukses delete data lemburs";
        }
        else {
            $pesan = "Gagal delete data lemburs";
        };

        // --- response ---
        return response()->json([
            'id' => $id,
            'pesan' => $pesan
        ], $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    public function listPakeId(Request $request) {
        $status = 200;
        $piranti = new Piranti();
        $sAkhir = $piranti->akhirBulan($request->bulan, $request->tahun);
        $sAwal = $piranti->awalBulan($request->bulan, $request->tahun);

        $sesuatu = DB::table('lemburs')
            ->select('id', 'EmpId', 'tanggal', 'shift', 'over_before', 'over_after',
                'break_before', 'break_after', 'kompensation', 'reason', 'status')
            ->where('EmpId', '=', $request->empid)
            ->where('tanggal', '>=', $sAwal)
            ->where('tanggal', '<=', $sAkhir);
        $results = $sesuatu->get();
        if (count($results) == 0) $status = 404;
        $json = json_encode($results);
        unset($results);
        return response($json, $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

}
