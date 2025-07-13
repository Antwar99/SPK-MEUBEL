<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Criteria;
use App\Traits\OwnedByUser;

class SubCriteria extends Model
{
    use HasFactory, OwnedByUser;
protected $table = 'sub_criteria';


    protected $fillable = [
        'criteria_kode',
        'name',
        'level',
        'value',
        'created_by'
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_kode', 'kode');
    }
}
