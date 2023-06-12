<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cutis;
use Illuminate\Support\Facades\DB;
use App\Kelas\Piranti;

class CutisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = 200;
        $results = Cutis::all();
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
        $sesuatu = new Cutis();
        $sesuatu->empid = $request->empid;
        $sesuatu->tgl_mulai = $request->tgl_mulai;
        $sesuatu->tgl_selesai = $request->tgl_selesai;
        $sesuatu->alasan = $request->alasan;
        $sesuatu->acc1 = $request->acc1;
        $sesuatu->acc2 = $request->acc2;
        $sesuatu->acc3 = $request->acc3;
        $sesuatu->disetujui1 = $request->disetujui1;
        $sesuatu->disetujui2 = $request->disetujui2;
        $sesuatu->disetujui3 = $request->disetujui3;
        $sesuatu->status = $request->status;
        if ($sesuatu->save()){
            $pesan = "Sukses insert data cuti";
        }
        else {
            $pesan = "Gagal insert data cuti";
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
        $result = Cutis::where("id", "=", $id)->first();
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
        $sesuatu = Cutis::find($id);
        // --- ada recordnya ---
        if ($sesuatu != null) {
            $sesuatu->id = $request->id;
            $sesuatu->empid = $request->empid;
            $sesuatu->tgl_mulai = $request->tgl_mulai;
            $sesuatu->tgl_selesai = $request->tgl_selesai;
            $sesuatu->alasan = $request->alasan;
            $sesuatu->acc1 = $request->acc1;
            $sesuatu->acc2 = $request->acc2;
            $sesuatu->acc3 = $request->acc3;
            $sesuatu->disetujui1 = $request->disetujui1;
            $sesuatu->disetujui2 = $request->disetujui2;
            $sesuatu->disetujui3 = $request->disetujui3;
            $sesuatu->status = $request->status;
            if ($sesuatu->save()){
                $pesan = "Sukses update data cutis";
            }
            else {
                $pesan = "Gagal update data cutis";
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
        $sesuatu = Cutis::find($id);
        if ($sesuatu == null) $status = 404;
        if ($sesuatu->delete()) {
            $pesan = "Sukses delete data cutis";
        }
        else {
            $pesan = "Gagal delete data cutis";
        };

        // --- response ---
        return response()->json([
            'id' => $id,
            'pesan' => $pesan
        ], $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    public function list(Request $request) {
        $status = 200;
        $piranti = new Piranti();
        $sAkhir = $piranti->akhirBulan($request->bulan, $request->tahun).' 23:59';
        $sAwal = $piranti->awalBulan($request->bulan, $request->tahun);

        $sesuatu = DB::table('cutis')
            ->select('id', 'empid', 'tgl_mulai', 'tgl_selesai', 'alasan', 'status')
            ->where('empid', '=', $request->empid)
            ->where('tgl_mulai', '>=', $sAwal)
            ->where('tgl_mulai', '<=', $sAkhir);
        $results = $sesuatu->get();
        if (count($results) == 0) $status = 404;
        $json = json_encode($results);
        unset($results);
        return response($json, $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }
}
