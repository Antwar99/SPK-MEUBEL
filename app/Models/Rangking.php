<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rangking extends Model
{
    use HasFactory;
}
// app/Models/Rangking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rangking extends Model
{
    protected $table = 'rangking_kayu'; // ganti sesuai nama tabel

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
