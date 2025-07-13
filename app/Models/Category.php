<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\OwnedByUser;

class Category extends Model
{
    use HasFactory, Sluggable, OwnedByUser;

    // protected $guarded = ['id'];

    protected $fillable = [
        'category_name',  // Ganti kelas_name menjadi category_name
        'slug'    ,        // Slug untuk category_name
        'created_by'
    ];

    public function woods()  // Ganti relasi ke woods
    {
        return $this->hasMany(Wood::class, 'category_id');  // Ganti relasi dari Student menjadi Wood
    }

    public function getRouteKeyName()
    {
        return 'slug';  // Menggunakan slug sebagai key untuk routing
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'category_name'  // Slug dihasilkan berdasarkan category_name
            ]
        ];
    }
}
