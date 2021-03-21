<?php

namespace App\Queries\Services;

use App\Models\Services\General;

class GeneralDataTable
{
    public function get()
    {
        $query = General::with('medic', 'patient')->select('general_services.*');
        return $query;
    }
}
