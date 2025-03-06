<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Mapel;
use App\Models\Absensi;

class AbsensiViewController extends Controller
{
    public function index()
    {
        $murid = Murid::all();
        $mapel = Mapel::all();
        $absensi = Absensi::with(['murid', 'mapel'])
        ->orderBy('tanggal', 'desc') // Urutkan berdasarkan tanggal terbaru
        ->orderBy('jam', 'desc') // Jika tanggal sama, urutkan berdasarkan jam terbaru
        ->get();
        return view('absensi.index', compact('murid', 'mapel', 'absensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_murid' => 'required|exists:murid,id',
            'id_mapel' => 'required|exists:mapel,id',
            'jam' => 'required',
            'tanggal' => 'required|date',
        ]);

        Absensi::create($request->all());

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dicatat.');
    }
}
