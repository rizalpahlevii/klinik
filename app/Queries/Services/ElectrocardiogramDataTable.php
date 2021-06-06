<?php

namespace App\Queries\Services;

use App\Models\Services\Electrocardiogram;

class ElectrocardiogramDataTable
{
    public function get()
    {
        $query = Electrocardiogram::with('medic', 'patient')->select('electrocardiogram_services.*');
        return $query;
    }
}
