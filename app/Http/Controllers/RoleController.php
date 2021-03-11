<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Queries\RoleDataTable;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use DataTables;

class RoleController extends AppBaseController
{
    /** @var  RoleRepository $roleRepository */
    protected $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new RoleDataTable())->get())->make(true);
        }
        return view('roles.index');
    }
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();
        $this->roleRepository->create($input);

        return $this->sendSuccess('Role saved successfully.');
    }

    /**
     * Show the form for editing the specified ItemCategory.
     *
     * @param  ItemCategory  $itemCategory
     *
     * @return JsonResponse
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findById($id);
        return $this->sendResponse($role, 'Role retrieved successfully.');
    }

    /**
     * Update the specified ItemCategory in storage.
     *
     * @param  ItemCategory  $itemCategory
     * @param  UpdateItemCategoryRequest  $request
     *
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->roleRepository->findById($id);
        $input = $request->all();
        $this->roleRepository->update($input, $role->id);

        return $this->sendSuccess('Role updated successfully.');
    }

    /**
     * Remove the specified ItemCategory from storage.
     *
     * @param  ItemCategory  $itemCategory
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Role $role)
    {
        $roleModel = [Role::class];
        $result = canDelete($roleModel, 'role_id', $role->id);
        if ($result) {
            return $this->sendError('Role can\'t be deleted.');
        }
        $this->roleRepository->delete($role->id);

        return $this->sendSuccess('Role deleted successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
}
