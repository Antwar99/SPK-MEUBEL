<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\OwnedByUser;

class Wood extends Model
{
    use HasFactory, OwnedByUser;

    protected $table = 'woods';

    protected $fillable = [
        'kode_kayu',
        'nama_kayu',
      
        'supplier',
        'category_id',
        'created_by'

    ];
    

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }
}
