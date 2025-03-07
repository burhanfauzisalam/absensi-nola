<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;
    
    protected $table = 'murid';
    protected $fillable = ['nama', 'kelas', 'email'];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_murid');
    }
}
