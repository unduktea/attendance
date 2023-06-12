<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yuser;

class YuserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $status = 200;
        $results = Yuser::all();
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
        $sesuatu = new Yuser();
        $sesuatu->empid = $request->empid;
        $sesuatu->password = $request->password;
        if ($sesuatu->save()) {
            $pesan = "Sukses insert data yuser";
        }
        else {
            $pesan = "Gagal insert data yuser";
        }

        // --- response ---
        return response() -> json([
            'empid' => $request->empid,
            'pesan' => $pesan
        ], 201)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = 200;
        $result = Yuser::where("empid", "=", $id)->first();
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
        $sesuatu = Yuser::where("empid", "=", $id)->first();
        // --- ada recordnya ---
        if ($sesuatu != null) {
            $sesuatu->password = $request->password;
            if ($sesuatu->save()){
                $pesan = "Sukses update data yuser";
            }
            else {
                $pesan = "Gagal update data yuser";
            }
        }
        // --- tidak ada recordnya ---
        else {
            $status = 404;
            $pesan = "Data yang dimaksud tidak ditemukan!";
        }
        // --- response ---
        return response()->json([
            'empid' => $id,
            'pesan' => $pesan
        ], $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = 200;
        $pesan = "kosong";
        $sesuatu = Yuser::where("empid", "=", $id)->first();
        if ($sesuatu == null) $status = 404;
        if ($sesuatu->delete()) {
            $pesan = "Sukses delete data yuser";
        }
        else {
            $pesan = "Gagal delete data yuser";
        };

        // --- response ---
        return response()->json([
            'empid' => $id,
            'pesan' => $pesan
        ], $status)->header('Access-Control-Allow-Origin', '*')
            ->header('Content-Type', 'application/json');
    }
}
