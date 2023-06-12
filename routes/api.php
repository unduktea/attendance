<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\EmpController;
use \App\Http\Controllers\AttendanceController;
use \App\Http\Controllers\CutisController;
use \App\Http\Controllers\LembursController;
use \App\Http\Controllers\MstusersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('mstuser/absen', [MstusersController::class, 'fileabsen']);
Route::post('mstuser/absenjne', [MstusersController::class, 'fileabsenjne']);

// --- attendance ---
Route::post('attendance/list', [AttendanceController::class, 'list']);
Route::post('attendance/daftar', [AttendanceController::class, 'daftar']);
Route::get('attendance/{empid}/{attdate}', [AttendanceController::class, 'show']);
Route::post('attendance', [AttendanceController::class, 'store']);

// --- lemburs ---
Route::post('lembur/list', [LembursController::class, 'list']);
Route::post('lembur/daftar', [LembursController::class, 'listPakeId']);
Route::get('lembur/{empid}/{tanggal}/{status}', [LembursController::class, 'show']);
Route::post('lembur', [LembursController::class, 'store']);
Route::post('lembur/alist', [LembursController::class, 'aListLembur']);

// --- cuti ---
Route::post('cuti/adminlist', [CutisController::class, 'adminList']);
Route::post('cuti/list', [CutisController::class, 'list']);
Route::get('cuti/{id}', [CutisController::class, 'show']);
Route::post('cuti', [CutisController::class, 'store']);

// --- emp ---
Route::get('emp/{id}', [EmpController::class, 'show']);
Route::patch('emp/{id}', [EmpController::class, 'update']);
Route::delete('emp/{id}', [EmpController::class, 'destroy']);
Route::get('emp', [EmpController::class, 'index']);
