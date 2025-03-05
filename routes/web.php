<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiViewController;

use App\Models\Murid;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/absensi', [AbsensiViewController::class, 'index'])->name('absensi.index');
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
