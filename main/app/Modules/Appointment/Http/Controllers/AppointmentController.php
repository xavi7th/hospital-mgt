<?php

namespace App\Modules\Appointment\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Appointment\Models\Appointment;

class AppointmentController extends Controller
{
  public function index(string $date = null)
  {
    // dd($date);
    return inertia('Appointment::AppointmentList', [
      'pending_appointments' => Appointment::with('doctor:id,name', 'patient:id,name','booked_by:id,name')->when(!is_null($date), fn($q)=>$q->whereDate('appointment_date', Carbon::parse($date)->toDateString()))->pending()->paginate(),
      'total_appointment_count' => Appointment::with('doctor:id,name', 'patient:id,name','booked_by:id,name')->when(!is_null($date), fn($q)=>$q->whereDate('appointment_date', Carbon::parse($date)->toDateString()))->pending()->count()
    ])->withViewData([
      'title' => 'Appointments List',
      'meta' =>''
    ]);
  }

  public function store(Request $request, Patient $patient)
  {
    $this->authorize('create', Appointment::class);

    $request->validate([
      'doctor_id' => ['required', 'exists:doctors,id'],
      'appointment_date' => ['required', 'date']
    ],[
      'doctor_id.required' => 'Select the doctor that this appointment is booked for',
    ]);

    $patient->appointments()->create([
      'doctor_id' => $request->doctor_id,
      'front_desk_user_id' => $request->user()->id,
      'appointment_date' => $request->appointment_date,
    ]);

    return redirect()->route('patients.show', $patient)->withFlash(['success' => 'Patient appointment booked. The assigned doctor will see the appointment in his schedule.']);
  }

  public function destroy(Appointment $appointment)
  {
    $this->authorize('delete', $appointment);

    $patient = $appointment->patient;

    $appointment->forceDelete();

    return redirect()->route('patients.show', $patient)->withFlash(['success' => 'Appointment has been cancelled.']);
  }

  public function postForVitals(Appointment $appointment)
  {
    $this->authorize('postForVitals', $appointment);

    $appointment->posted_at = now();
    $appointment->save();

    return back()->withFlash(['success' => 'Patient appointment posted. They can proceed to the nusring unit for their vitals.']);
  }
}
