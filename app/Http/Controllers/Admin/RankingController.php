<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RanksExport;
use App\Http\Controllers\Controller;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\CriteriaAnalysis;
use App\Models\CriteriaAnalysisDetail;
use Maatwebsite\Excel\Facades\Excel;




class RankingController extends Controller
{
    public function index()
    {

        if (auth()->user()->level === 'ADMIN' || auth()->user()->level === 'USER') {
            $criteriaAnalysis = CriteriaAnalysis::with('user')->with(['details' => function ($query) {
                $query->join('criterias', 'criteria_analysis_details.criteria_id_second', '=', 'criterias.id')
                    ->select('criteria_analysis_details.*', 'criterias.name as criteria_name')
                    ->orderBy('criterias.id');
            }])
                ->get();
        }

        $availableCriterias = Criteria::all()->pluck('id');
        $isAnyAlternative   = Alternative::checkAlternativeByCriterias($availableCriterias);
        $isAbleToRank       = false;

        if ($isAnyAlternative) {
            $isAbleToRank = true;
        }

        return view('pages.admin.rank.data', [
            'title'             => 'Rangking Bahan Baku Kayu',
            'criteria_analysis' => $criteriaAnalysis,
            'isAbleToRank'      => $isAbleToRank,
        ]);
    }

  public function show(CriteriaAnalysis $criteriaAnalysis)
{
    $criteriaAnalysis->load('priorityValues');

    $criterias = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
    $criteriaIds = $criterias->pluck('id');
    $alternatives = Alternative::getAlternativesByCriteria($criteriaIds);
    $dividers = Alternative::getDividerByCriteria($criterias);

    // Ambil semua data kriteria dan index berdasarkan ID
    $allCriterias = Criteria::all()->keyBy('id');

    // Tambahkan kode_kriteria ke setiap divider
    foreach ($dividers as $index => $divider) {
        $criteriaId = $divider['criteria_id'] ?? $criterias[$index]['id'] ?? null;

        if ($criteriaId && isset($allCriterias[$criteriaId])) {
            $dividers[$index]['code'] = $allCriterias[$criteriaId]->kode ?? 'C' . ($index + 1);
        } else {
            $dividers[$index]['code'] = 'C' . ($index + 1); // fallback
        }
    }

    $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);

    return view('pages.admin.rank.detail', [
        'title' => 'Normalisasi Tabel Bahan Baku Kayu',
        'dividers' => $dividers,
        'normalizations' => $normalizations,
        'criteriaAnalysis' => $criteriaAnalysis,
    ]);
}

    private function _hitungNormalisasi($dividers, $alternatives)
    {
        $normalisasi = [];

        foreach ($alternatives as $alternative) {
            $normalisasiAngka = [];

          foreach ($alternative['alternative_val'] as $key => $val) {
    $divider = $dividers[$key]['divider_value'];
    $kategori = $dividers[$key]['kategori'];

    if ($val == 0 || $divider == 0) {
        $result = 0;
    } elseif ($kategori === 'benefit') {
        $result = round($val / $divider, 6);
    } elseif ($kategori === 'cost') {
        $result = round($divider / $val, 6);
    } else {
        $result = 0;
    }

    array_push($normalisasiAngka, $result);
}


          array_push($normalisasi, [
                'wood_id'         => $alternative['wood_id'],
                'wood_name'       => strtoupper($alternative['wood_name']),
                'category_name'   => $alternative['category_name'],
                'criteria_name'   => $alternative['criteria_name'],
                'criteria_id'     => $alternative['criteria_id'],
                'alternative_val' => $alternative['alternative_val'],
                'results'         => $normalisasiAngka
            ]);

        }

        // Menambahkan orderby berdasarkan nama bahan baku kayu (wood_name) secara naik (ascending)
       $normalisasi = collect($normalisasi)
    ->sortBy([
        ['category_name', 'asc'],
        ['wood_name', 'asc'],
        ['criteria_id', 'asc'],
    ])
    ->values()
    ->all();


        return $normalisasi;
    }

 public function final(CriteriaAnalysis $criteriaAnalysis)
{
    // Pastikan data priorityValues dimuat dulu
    $criteriaAnalysis->load('priorityValues');

    // Cek apakah priorityValues tersedia
    if (!$criteriaAnalysis->priorityValues || $criteriaAnalysis->priorityValues->isEmpty()) {
        return back()->withError('Priority values belum tersedia.')->withInput();
    }

    $criterias      = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
    $criteriaIds    = $criterias->pluck('id');
    $alternatives   = Alternative::getAlternativesByCriteria($criteriaIds);
    $dividers       = Alternative::getDividerByCriteria($criterias);

    $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);

    try {
        $ranking = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);
    } catch (\Exception $exception) {
        return back()->withError($exception->getMessage())->withInput();
    }


    return view('pages.admin.rank.final', [
        'title'             => 'Ranking Bahan Baku Kayu',
        'criteria_analysis' => $criteriaAnalysis,
        'dividers'          => $dividers,
        'criterias'         => Criteria::all(),
        'normalizations'    => $normalizations,
        'ranks'             => $ranking
    ]);

}


    private function _finalRanking($priorityValues, $normalizations)
    {
        foreach ($normalizations as $keyNorm => $normal) {
            foreach ($normal['results'] as $keyVal => $value) {
                $importanceVal = $priorityValues[$keyVal]->value;

                // Operasi penjumlahan dari perkalian matriks ternormalisasi dan prioritas
                $result = $importanceVal * $value;

                if (array_key_exists('rank_result', $normalizations[$keyNorm])) {
                    $normalizations[$keyNorm]['rank_result'] += $result;
                } else {
                    $normalizations[$keyNorm]['rank_result'] = $result;
                }
            }
        }

        usort($normalizations, function ($a, $b) {
            return $b['rank_result'] <=> $a['rank_result'];
        });

        return $normalizations;
    }

   public function detailr(CriteriaAnalysis $criteriaAnalysis)
{
    // Load relasi priorityValues terlebih dahulu
    $criteriaAnalysis->load('priorityValues');

    // Cek apakah priorityValues tersedia
    if (!$criteriaAnalysis->priorityValues || $criteriaAnalysis->priorityValues->isEmpty()) {
        return back()->withError('Priority values belum tersedia.')->withInput();
    }

    $criterias      = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
    $criteriaIds    = $criterias->pluck('id');
    $alternatives   = Alternative::getAlternativesByCriteria($criteriaIds);
    $dividers       = Alternative::getDividerByCriteria($criterias);

    $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);

    try {
        $ranking = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);
    } catch (\Exception $exception) {
        return back()->withError($exception->getMessage())->withInput();
    }

    $title = 'Perhitungan SAW';

    return view('pages.admin.rank.detailr', [
        'criteriaAnalysis'  => $criteriaAnalysis,
        'dividers'          => $dividers,
        'normalizations'    => $normalizations,
        'ranking'           => $ranking,
        'title'             => $title
    ]);
}

    // export
    public function export(CriteriaAnalysis $criteriaAnalysis)
    {
        $criterias = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
        $criteriaIds = $criterias->pluck('id');
        $alternatives = Alternative::getAlternativesByCriteria($criteriaIds);
        $dividers = Alternative::getDividerByCriteria($criterias);

        $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);
        $ranking = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);

        $export = new RanksExport($ranking, $normalizations);

        $fileName = 'Rangking Bahan Baku Kayu.xlsx';

        return Excel::download($export, $fileName);
    }
}
