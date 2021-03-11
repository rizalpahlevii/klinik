<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserController
 */
class UserController extends AppBaseController
{
}
