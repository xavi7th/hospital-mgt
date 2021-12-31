<?php

namespace App\Modules\Nurse\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Modules\Nurse\Models\Nurse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\SuperAdmin\Transformers\StaffTransformer;
use App\Modules\SuperAdmin\Notifications\AccountActivated;
use App\Modules\SuperAdmin\Http\Requests\CreateUserRequest;

class NurseController extends Controller
{
  public function index()
  {
    $this->authorize('accessDashboard', Nurse::class);

    return Inertia::render('Nurse::Dashboard', [
      'posted_appointments' => Appointment::with(['doctor', 'patient'])->posted()->vitalsNotTaken()->due()->get()
    ])->withViewData([
      'title' => 'Welcome',
      'metaDesc' => ''
    ]);
  }

  public function getAllNurses(Request $request)
  {
    $this->authorize('viewAny', Nurse::class);

    return Inertia::render('SuperAdmin::ManageUsers', [
      'nurses' => (new StaffTransformer)->collectionTransformer(Nurse::latest()->get(), 'transform'),
    ])->withViewData([
      'title' => 'View App Users',
    ]);
  }

  public function store(CreateUserRequest $request)
  {
    $this->authorize('create', Nurse::class);

    $request->createUser(Nurse::class);

    return redirect()->route('nurses.index')->withFlash(['success' => 'Nurse account created. Activate the account so the user can login.']);
  }

  public function suspend(Request $request, Nurse $nurse)
  {
    $this->authorize('suspend', $nurse);

    $nurse->is_active = false;
    $nurse->save();

    return redirect()->route('nurses.index')->withFlash(['success' => 'User account has been suspend and they can no longer login.']);
  }

  public function unsuspend(Request $request, Nurse $nurse)
  {
    $this->authorize('unsuspend', $nurse);

    $nurse->is_active = true;
    $nurse->save();

    return redirect()->route('nurses.index')->withFlash(['success' => 'User account has been restored and they can login once again.']);
  }

  public function activate(Request $request, Nurse $nurse)
  {

    $this->authorize('activate', $nurse);

    $nurse->account_activated_at = now();
    $nurse->save();

    $nurse->notify(new AccountActivated);

    return redirect()->route('nurses.index')->withFlash(['success' => 'User account has been activated and they have received a notification mail.']);
  }

  public function delete(Request $request, Nurse $nurse)
  {
    $this->authorize('delete', $nurse);

    $nurse->forceDelete();
    return redirect()->route('nurses.index')->withFlash(['success' => 'User account and all their records deleted.']);
  }
}
