<?php

namespace App\Queries\Services;

use App\Models\Services\Inpatient;

class InpatientDataTable
{
    public function get()
    {
        $query = Inpatient::with('medic', 'patient')->select('inpatient_services.*');
        return $query;
    }
}
