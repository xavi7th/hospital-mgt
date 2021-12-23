<?php

namespace App\Modules\FrontDeskUser\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use App\Modules\FrontDeskUser\Notifications\AccountActivated;
use App\Modules\FrontDeskUser\Transformers\FrontDeskUserTransformer;
use App\Modules\SuperAdmin\Http\Requests\CreateUserRequest;

class FrontDeskUserController extends Controller
{

  public function index(Request $request)
  {
    $this->authorize('accessDashboard', FrontDeskUser::class);

    return Inertia::render('FrontDeskUser::Dashboard')->withViewData([
      'title' => 'Welcome',
      'metaDesc' => ''
    ]);
  }

  public function profile(Request $request)
  {
    $this->authorize('updateProfile', FrontDeskUser::class);

    return Inertia::render('FrontDeskUser::UserProfile', [
      'can_update_profile' => config('app.can_update_profile'),
    ])->withViewData([
      'title' => 'My Profile',
      'metaDesc' => ''
    ]);
  }

  public function updateAvatar(Request $request)
  {
    $this->authorize('updateProfile', FrontDeskUser::class);

    $request->user()->avatar_url = compress_image_upload('avatar', 'user-avatars/', 'user-avatars/thumbs/', 1920, true, 200)['thumb_url'];
    $request->user()->save();

    return redirect()->route('frontdeskusers.profile')->withFlash(['success' => 'Profile image updated.']);
  }


  public function getAllFrontDeskUsers(Request $request)
  {
    $this->authorize('viewAny', FrontDeskUser::class);

    return Inertia::render('SuperAdmin::ManageUsers', [
      'front_desk_users' => (new FrontDeskUserTransformer)->collectionTransformer(FrontDeskUser::latest()->get(), 'transformForFrontDeskUser'),
    ])->withViewData([
      'title' => 'View App Users',
    ]);
  }

  public function createFrontDeskUser(CreateUserRequest $request)
  {
    $this->authorize('create', FrontDeskUser::class);

    $request->createUser(FrontDeskUser::class);

    return redirect()->route('frontdeskusers.list')->withFlash(['success' => 'Front Desk User account created. Activate the account so the user can login.']);
  }

  public function suspendFrontDeskUser(Request $request, FrontDeskUser $front_desk_user)
  {
    $this->authorize('suspend', $front_desk_user);

    $front_desk_user->is_active = false;
    $front_desk_user->save();

    return redirect()->route('frontdeskusers.list')->withFlash(['success' => 'User account has been suspend and they can no longer login.']);
  }

  public function unsuspendFrontDeskUser(Request $request, FrontDeskUser $front_desk_user)
  {
    $this->authorize('unsuspend', $front_desk_user);

    $front_desk_user->is_active = true;
    $front_desk_user->save();

    return redirect()->route('frontdeskusers.list')->withFlash(['success' => 'User account has been restored and they can login once again.']);
  }

  public function activateFrontDeskUserAccount(Request $request, FrontDeskUser $front_desk_user)
  {
    $this->authorize('activate', $front_desk_user);

    $front_desk_user->account_activated_at = now();
    $front_desk_user->save();

    $front_desk_user->notify(new AccountActivated);

    return redirect()->route('frontdeskusers.list')->withFlash(['success' => 'User account has been activated and they have received a notification mail.']);
  }

  public function deleteFrontDeskUserAccount(Request $request, FrontDeskUser $front_desk_user)
  {
    $this->authorize('delete', $front_desk_user);

    $front_desk_user->forceDelete();
    return redirect()->route('frontdeskusers.list')->withFlash(['success' => 'User account and all their records deleted.']);
  }
}
