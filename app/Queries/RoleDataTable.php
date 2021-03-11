<?php

namespace App\Queries;

use App\Models\Role;
use Illuminate\Database\Query\Builder;

class RoleDataTable
{
    /**
     * @return Role|Builder
     */
    public function get()
    {
        /** @var Role $query */
        $query = Role::query();

        return $query;
    }
}
