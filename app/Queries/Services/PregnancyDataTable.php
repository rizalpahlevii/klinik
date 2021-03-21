<?php

namespace App\Queries\Services;

use App\Models\Services\Pregnancy;

class PregnancyDataTable
{
    public function get()
    {
        $query = Pregnancy::with('medic', 'patient')->select('pregnancy_services.*');
        return $query;
    }
}
