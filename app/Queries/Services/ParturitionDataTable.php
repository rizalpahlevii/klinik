<?php

namespace App\Queries\Services;

use App\Models\Services\Parturition;

class ParturitionDataTable
{
    public function get()
    {
        $query = Parturition::with('medic', 'patient')->select('parturition_services.*');
        return $query;
    }
}
