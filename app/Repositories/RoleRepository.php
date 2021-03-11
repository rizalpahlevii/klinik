<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }

    public function getRoles()
    {
        $roles = Role::all();
        return $roles;
    }
    public function findById($id)
    {
        return Role::findById($id);
    }
}
