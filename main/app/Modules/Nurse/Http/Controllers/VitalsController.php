<?php

namespace App\Modules\Nurse\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Nurse\Models\Vitals;
use App\Modules\Appointment\Models\Appointment;

class VitalsController extends Controller
{
  // public function index(string $date = null)
  // {
  //   return inertia('Appointment::AppointmentList', [
  //     'appointments' => Appointment::with('doctor', 'patient','booked_by')->when($date, fn($q)=>$q->whereDate('appointment_date', Carbon::parse($date)->toDateString()))->paginate()
  //   ])->withViewData([
  //     'title' => 'Appointments List',
  //     'meta' =>''
  //   ]);
  // }

  public function store(Request $request, Appointment $appointment)
  {
    $this->authorize('create', Vitals::class);

    $request->validate([
      'vitals' => ['required', 'array'],
    ]);

    $appointment->vital_signs()->create([
      'nurse_id' => $request->user()->id,
      'vitals' => $request->vitals,
    ]);

    return redirect()->route($request->user()->dashboardRoute())->withFlash(['success' => 'Patient\'s vitals recorded. They can proceed to see the doctor now.']);
  }
}
