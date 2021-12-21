<?php

namespace App\Modules\FrontDeskUser\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use App\Modules\Miscellaneous\Models\ForexChart;
use App\Modules\FrontDeskUser\Notifications\AccountActivated;
use App\Modules\FrontDeskUser\Transformers\FrontDeskUserTransformer;
use App\Modules\FrontDeskUser\Http\Requests\UploadIDCardRequest;
use App\Modules\Miscellaneous\Transformers\ForexChartTransformer;

class FrontDeskUserController extends Controller
{


  public function index(Request $request)
  {
    $this->authorize('accessDashboard', FrontDeskUser::class);

    return Inertia::render('FrontDeskUser::Dashboard', [
      'current_plan' => $request->user()->current_plan,
      'has_user_bonus' => config('app.has_bonus'),
      'can_suspend_investments' => config('app.can_suspend_investments'),
      'can_upload_pop' => config('app.can_upload_pop'),
      'forex_charts' => Cache::rememberForever('forex_charts' , fn() => (new ForexChartTransformer)->collectionTransformer(ForexChart::all(), 'transform')->keyBy('chart_slug')),
    ])->withViewData([
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

    return Inertia::render('SuperAdmin::ManageFrontDeskUsers', [
      'front_desk_users' => (new FrontDeskUserTransformer)->collectionTransformer(FrontDeskUser::with('user_balance_statistics')->latest()->get(), 'transformForFrontDeskUser'),
      'can_view_passwords' => config('app.can_view_passwords'),
      'has_user_bonus' => config('app.has_bonus'),
      'must_accept_terms' => config('app.must_accept_terms'),
      'must_upload_id' => config('app.must_upload_id'),
      'must_activate_users' => config('app.must_activate_users'),
      'must_have_unique_wallets' => config('app.must_have_unique_wallets'),
      'must_upload_utility_bill' => config('app.must_upload_utility_bill'),
      'can_request_alt_deposits' => config('app.can_request_alt_deposits'),
      'can_disable_withdrawals' => config('app.can_disable_withdrawals'),
      'can_delete_users' => config('app.can_delete_users'),
      'can_send_auth_codes' => config('app.can_send_auth_codes'),
    ])->withViewData([
      'title' => 'View App Users',
    ]);
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

    if (! $front_desk_user->hasVerifiedEmail()) {
      return redirect()->route('frontdeskusers.list')->withFlash(['error' => 'Account NOT activated. The user has not verified their email. We have to ensure that the user can receive emails.']);
    }


    if (config('app.must_have_unique_wallets') && is_null($front_desk_user->btc_wallet)) {
      return redirect()->route('frontdeskusers.list')->withFlash(['error' => 'This user has no btc wallet. Set a BTC wallet before activating the user\'s account']);
    }

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
