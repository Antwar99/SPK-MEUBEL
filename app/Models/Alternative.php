<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\OwnedByUser;
class Alternative extends Model
{
    use HasFactory, OwnedByUser;

    protected $fillable = [
        'wood_id',
        'criteria_id',
        'category_id', // jika memang masih digunakan
        'alternative_value',
        'created_by'
    ];

    public function criteria()
{
    return $this->belongsTo(Criteria::class, 'criteria_id', 'id')
                ->withDefault(); // optional untuk cegah null
}


    public function wood()
    {
        return $this->belongsTo(Wood::class, 'wood_id');
    }

    // RELASI CATEGORY DIHAPUS karena melalui wood
    // public function category() {}

    public static function getDividerByCriteria($criterias)
    {
        $dividers = [];

        foreach ($criterias as $criteria) {
            $divider = $criteria->kategori === 'BENEFIT'
                ? static::where('criteria_id', $criteria->id)->max('alternative_value')
                : static::where('criteria_id', $criteria->id)->min('alternative_value');

            $dividers[] = [
                'criteria_id'   => $criteria->id,
                'name'          => $criteria->name,
                'kategori'      => $criteria->kategori,
                'divider_value' => floatval($divider),
            ];
        }

        return $dividers;
    }

    public static function getAlternativesByCriteria($criterias)
    {
        // Load wood dan wood->category (karena category milik wood, bukan langsung alternative)
        $results = static::with(['criteria', 'wood.category'])
            ->whereIn('criteria_id', $criterias)
            ->get();

        if (!$results->count()) {
            return [];
        }

        $finalRes = [];

        foreach ($results as $result) {
            $index = array_search($result->wood_id, array_column($finalRes, 'wood_id'));

            if ($index !== false) {
                $finalRes[$index]['criteria_id'][]     = $result->criteria->id;
                $finalRes[$index]['criteria_name'][]   = $result->criteria->name;
                $finalRes[$index]['alternative_val'][] = $result->alternative_value;
            } else {
                $finalRes[] = [
                    'wood_id'         => $result->wood_id,
                    'wood_name'       => optional($result->wood)->nama_kayu ?? '-',
                    'category_id'     => optional($result->wood->category)->category_id ?? null,
                    'category_name'   => optional($result->wood->category)->category_name?? '-',
                    'criteria_id'     => [$result->criteria->id],
                    'criteria_name'   => [$result->criteria->name],
                    'alternative_val' => [$result->alternative_value],
                ];
            }
        }

        return $finalRes;
    }

    public static function checkAlternativeByCriterias($criterias)
    {
        foreach ($criterias as $criteria) {
            if (static::where('criteria_id', $criteria)->count() === 0) {
                return false;
            }
        }

        return true;
    }
}
