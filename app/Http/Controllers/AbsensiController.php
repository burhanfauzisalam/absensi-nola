<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Murid;
use App\Models\Mapel;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with(['murid', 'mapel'])->get();
        return response()->json($absensi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_murid' => 'required|exists:murid,id',
            'id_mapel' => 'required|exists:mapel,id',
            'keterangan' => 'required|in:Offline,Ijin,Sakit,Online,Alfa',
        ]);

        Absensi::create([
            'id_murid' => $request->id_murid,
            'id_mapel' => $request->id_mapel,
            'jam' => $request->jam ?? now()->format('H:i'),
            'tanggal' => $request->tanggal ?? now()->format('Y-m-d'),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan');
    }

}
