<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiViewController;
use App\Http\Controllers\AuthController;
use App\Models\Murid;
use Illuminate\Http\Request;
use App\Middleware\AuthCheck;

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware(AuthCheck::class);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(AuthCheck::class)->group(function () {
    Route::get('/absensi', [AbsensiViewController::class, 'index'])->name('absensi.index');
});

// Route login tanpa middleware agar tidak masuk dalam loop
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::post('/absensi', [AbsensiViewController::class, 'store'])->name('absensi.store');


Route::get('/autocomplete/murid', function (Request $request) {
    $search = $request->input('term');
    $murid = Murid::where('nama', 'LIKE', "%{$search}%")
                  ->select('id', 'nama', 'kelas')
                  ->get();

    $response = $murid->map(function($m) {
        return [
            'value' => $m->id, // ID murid
            'label' => "{$m->nama} ({$m->kelas})" // Nama + Kelas
        ];
    });

    return response()->json($response);
})->name('autocomplete.murid');
