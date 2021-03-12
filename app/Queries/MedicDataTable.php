<?php

namespace App\Queries;

use App\Models\Medic;

class MedicDataTable
{
    public function get()
    {
        $query = Medic::select('medics.*');
        return $query;
    }
}
