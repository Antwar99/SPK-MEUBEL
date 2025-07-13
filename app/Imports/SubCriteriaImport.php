<?php

namespace App\Imports;

use App\Models\SubCriteria;
use Maatwebsite\Excel\Concerns\ToModel;

class SubCriteriaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SubCriteria([
            //
        ]);
    }
}
