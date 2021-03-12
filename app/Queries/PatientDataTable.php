<?php

namespace App\Queries;

use App\Models\Patient;

class PatientDataTable
{
    /**
     * @param  array  $input
     *
     * @return Patient|Builder
     */
    public function get()
    {
        $query = Patient::select('patients.*');
        return $query;
    }
}
