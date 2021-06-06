<?php

namespace App\Queries\Services;

use App\Models\Services\Administration;

class AdministrationDataTable
{
    public function get()
    {
        $query = Administration::with('medic', 'patient')->select('administration_services.*');
        return $query;
    }
}
