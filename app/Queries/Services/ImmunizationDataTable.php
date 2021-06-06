<?php

namespace App\Queries\Services;

use App\Models\Services\Immunization;

class ImmunizationDataTable
{
    public function get()
    {
        $query = Immunization::with('medic', 'patient')->select('immunization_services.*');
        return $query;
    }
}
