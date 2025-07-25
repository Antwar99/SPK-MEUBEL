<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\OwnedByUser;
use App\Models\SubCriteria;


class Criteria extends Model
{
   
    use HasFactory, Sluggable, OwnedByUser;
     protected $table = 'criterias';

    protected $fillable = ['kode','name','bobot', 'kategori', 'slug', 'keterangan',  'created_by'];
    // protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
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
                'source' => 'name'
            ]
        ];
    }
    public function subcriterias()
{
    return $this->hasMany(SubCriteria::class, 'criteria_kode', 'kode');
}

public function priority()
{
    return $this->hasOne(PriorityValue::class, 'criteria_id');
}

public static function booted()
{
    static::retrieved(function ($model) {
        logger('Model Criteria pakai tabel: ' . $model->getTable());
    });
}


}
