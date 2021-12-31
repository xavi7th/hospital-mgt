<?php

namespace App\Modules\Doctor\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\SuperAdmin\Transformers\StaffTransformer;
use App\Modules\SuperAdmin\Notifications\AccountActivated;
use App\Modules\SuperAdmin\Http\Requests\CreateUserRequest;

class DoctorController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize('accessDashboard', Doctor::class);

    return Inertia::render('Doctor::Dashboard', [
      'appointments' => $request->user()->appointments()->with(['nurse', 'patient', 'case_notes'])->pending()->postedToday()->vitalsTaken()->get()
    ])->withViewData([
      'title' => 'Welcome',
      'metaDesc' => ''
    ]);
  }

  public function getAllDoctors(Request $request)
  {
    $this->authorize('viewAny', Doctor::class);

    return Inertia::render('SuperAdmin::ManageUsers', [
      'doctors' => (new StaffTransformer)->collectionTransformer(Doctor::latest()->get(), 'transform'),
    ])->withViewData([
      'title' => 'View App Users',
    ]);
  }

  public function store(CreateUserRequest $request)
  {
    $this->authorize('create', Doctor::class);

    $request->createUser(Doctor::class);

    return redirect()->route('doctors.index')->withFlash(['success' => 'Doctor account created. Activate the account so the user can login.']);
  }

  public function suspend(Request $request, Doctor $doctor)
  {
    $this->authorize('suspend', $doctor);

    $doctor->is_active = false;
    $doctor->save();

    return redirect()->route('doctors.index')->withFlash(['success' => 'User account has been suspend and they can no longer login.']);
  }

  public function unsuspend(Request $request, Doctor $doctor)
  {
    $this->authorize('suspend', $doctor);

    $doctor->is_active = true;
    $doctor->save();

    return redirect()->route('doctors.index')->withFlash(['success' => 'User account has been restored and they can login once again.']);
  }

  public function activate(Request $request, Doctor $doctor)
  {

    $this->authorize('activate', $doctor);

    $doctor->account_activated_at = now();
    $doctor->save();

    $doctor->notify(new AccountActivated);

    return redirect()->route('doctors.index')->withFlash(['success' => 'User account has been activated and they have received a notification mail.']);
  }

  public function delete(Request $request, Doctor $doctor)
  {
    $this->authorize('delete', $doctor);

    $doctor->forceDelete();
    return redirect()->route('doctors.index')->withFlash(['success' => 'User account and all their records deleted.']);
  }
}
