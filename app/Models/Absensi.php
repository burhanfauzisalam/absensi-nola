<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    
    protected $table = 'absensi';
    protected $fillable = ['id_murid', 'id_mapel', 'jam', 'tanggal', 'keterangan'];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_murid' => 'required|exists:murid,id',
            'id_mapel' => 'required|exists:mapel,id',
            'jam' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required|in:Hadir,Ijin,Sakit,Online',
        ]);

        Absensi::create([
            'id_murid' => $request->id_murid,
            'id_mapel' => $request->id_mapel,
            'jam' => $request->jam,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan');
    }

}
