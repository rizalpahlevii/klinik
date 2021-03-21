<?php

namespace App\Queries\Services;

use App\Models\Services\Laboratory;

class LaboratoryDataTable
{
    public function get()
    {
        $query = Laboratory::with('medic', 'patient')->select('laboratory_services.*');
        return $query;
    }
}
