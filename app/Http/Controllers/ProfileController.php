<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Repositories\ProfileRepository;
use Auth;
use Illuminate\Http\Request;
use Exception;

class ProfileController extends AppBaseController
{
    /** @var  ProfileRepository $profileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param  ChangePasswordRequest  $request
     *
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $input = $request->all();

        try {
            $user = $this->profileRepository->changePassword($input);

            return $this->sendSuccess('Password updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * @param  UpdateUserProfileRequest  $request
     *
     * @return JsonResponse
     */
    public function profileUpdate(UpdateUserProfileRequest $request)
    {
        $input = $request->all();

        try {
            $user = $this->profileRepository->profileUpdate($input);

            return $this->sendResponse($user, 'Profile updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified User.
     *
     * @return JsonResponse
     */
    public function editProfile()
    {
        $user = Auth::user();

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function updateLanguage(Request $request)
    {
        $language = $request->get('language');

        /** @var User $user */
        $user = Auth::user();
        $user->update(['language' => $language]);

        return $this->sendSuccess('Language updated successfully.');
    }
}
