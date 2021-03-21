<?php

namespace App\Queries\Services;

use App\Models\Services\FamilyPlanning;

class FamilyPlanningDataTable
{
    public function get()
    {
        $query = FamilyPlanning::with('medic', 'patient')->select('family_planning_services.*');
        return $query;
    }
}
