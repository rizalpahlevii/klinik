<?php

namespace App\Queries;

use App\Models\User;

class UserDataTable
{
    public function get()
    {
        $query = User::with(['roles'])->select('users.*');
        return $query;
    }
}
