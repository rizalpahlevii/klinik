<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Queries\UserDataTable;
use App\Repositories\UserRepository;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DataTables;
use Flash;

/**
 * Class UserController
 */
class UserController extends AppBaseController
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new UserDataTable())->get())
                ->addColumn(
                    'role',
                    function ($data) {
                        $role = '';
                        foreach ($data->roles as $key => $item) {
                            $separator = ($key + 1) != count($data->roles) ? ' | ' : '';
                            $role .= $item->name . $separator;
                        }
                        return $role;
                    }
                )->make(true);
        }
        return view('users.index');
    }
    public function create()
    {
        $roles = $this->userRepository->getRoles();
        return view('users.create', compact('roles'));
    }
    public function store(CreateUserRequest $request)
    {
        $input = [
            'fullname' => $request->name_form,
            'username' => $request->username_form,
            'phone' => $request->prefix_code . $request->phone_form,
            'address' => $request->address_form,
            'gender' => $request->gender_form,
            'start_working_date' => $request->start_working_date,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_form
        ];
        $this->userRepository->createUser($input);
        Flash::success('Berhasil menyimpan data user baru.');
        return redirect()->route('users.index');
    }
    public function edit($id)
    {
        $user = $this->userRepository->getUser($id);
        $roles = $this->userRepository->getRoles();
        return view('users.edit', compact('roles', 'user'));
    }
    public function update(UpdateUserRequest $request, $id)
    {
        $input = [
            'fullname' => $request->name_form,
            'username' => $request->username_form,
            'phone' => $request->prefix_code . $request->phone_form,
            'address' => $request->address_form,
            'gender' => $request->gender_form,
            'start_working_date' => $request->start_working_date,
            'role_id' => $request->role_form
        ];
        if ($request->password != null) {
            $input['password'] = bcrypt($request->password);
        }
        $this->userRepository->updateUser($input, $id);
        Flash::success('Berhasil mengubah data user.');
        return redirect()->route('users.index');
    }
    public function destroy($id)
    {
        $user = $this->userRepository->getUser($id);
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data pengguna : " . $user->name);
        $user->delete();
        return $this->sendSuccess('User deleted successfully.');
    }
}
