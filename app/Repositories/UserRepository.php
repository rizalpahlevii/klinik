<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use Arr;
use Auth;
use Exception;
use Hash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version January 11, 2020, 11:09 am UTC
 */
class UserRepository extends BaseRepository
{
    protected $user;
    protected $role;
    public function __construct(User $user, Role $role)
    {
        $this->role = $role;
        $this->user = $user;
    }
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'username',
        'phone',
        'gender',
        'address',
        'start_working_date'
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
        return User::class;
    }

    public function getRoles()
    {
        return $this->role->get();
    }

    public function getUser($id)
    {
        return $this->user->with('roles')->findOrFail($id);
    }

    public function createUser($data)
    {
        $role = $this->role->findById($data['role_id']);
        $user = $this->user->create(Arr::except($data, ['role_id']));
        $user->assignRole($role);
    }
    public function updateUser($data, $id)
    {
        $role = $this->role->findById($data['role_id']);
        $user = User::find($id);
        $user->update(Arr::except($data, ['role_id']));
        $user->syncRoles($role);
    }
}
