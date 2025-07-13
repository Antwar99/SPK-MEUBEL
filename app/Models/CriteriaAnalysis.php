<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\OwnedByUser;
class CriteriaAnalysis extends Model
{
    use HasFactory, OwnedByUser;

    protected $fillable = ['user_id', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        // one-to-many
        return $this->hasMany(CriteriaAnalysisDetail::class);
    }

    public function priorityValues()
    {
        return $this->hasMany(PriorityValue::class);
    }
}
