<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emp;

class EmpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = 200;
        $results = Emp::all();
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
        $sesuatu = new Emp();
        $sesuatu->empid = $request->empid;
        $sesuatu->empname = $request->empname;
        $sesuatu->gender = $request->gender;
        $sesuatu->birthdate = $request->birthdate;
        $sesuatu->placeofbirth = $request->placeofbirth;
        $sesuatu->atasan1 = $request->atasan1;
        $sesuatu->atasan2 = $request->atasan2;
        $sesuatu->atasan3 = $request->atasan3;
        if ($sesuatu->save()){
            $pesan = "Sukses insert data emp";
        }
        else {
            $pesan = "Gagal insert data emp";
        }

        // --- response ---
        return response() -> json([
            'empid' => $request->empid,
            'pesan' => $pesan
        ], 201)->header('Access-Control-Allow-Origin', '*')->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = 200;
        $result = Emp::where("empid", "=", $id)->first();
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
        $sesuatu = Emp::where("empid", "=", $id)->first();
        // --- ada recordnya ---
        if ($sesuatu != null) {
            $sesuatu->empname = $request->empname;
            $sesuatu->gender = $request->gender;
            $sesuatu->birthdate = $request->birthdate;
            $sesuatu->placeofbirth = $request->placeofbirth;
            $sesuatu->atasan1 = $request->atasan1;
            $sesuatu->atasan2 = $request->atasan2;
            $sesuatu->atasan3 = $request->atasan3;
            if ($sesuatu->save()){
                $pesan = "Sukses update data emp";
            }
            else {
                $pesan = "Gagal update data emp";
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
        ], $status)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = 200;
        $pesan = "kosong";
        $sesuatu = Emp::where("empid", "=", $id)->first();
        if ($sesuatu == null) $status = 404;
        if ($sesuatu->delete()) {
            $pesan = "Sukses delete data emp";
        }
        else {
            $pesan = "Gagal delete data emp";
        };

        // --- response ---
        return response()->json([
            'empid' => $id,
            'pesan' => $pesan
        ], $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }
}
