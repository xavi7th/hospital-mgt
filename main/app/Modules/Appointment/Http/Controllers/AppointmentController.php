<?php

namespace App\Modules\Appointment\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Appointment\Models\Appointment;

class AppointmentController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index(string $date = null)
  {
    return inertia('Appointment::AppointmentList', [
      'appointments' => Appointment::with('doctor', 'patient','booked_by')->when($date, fn($q)=>$q->whereDate('appointment_date', Carbon::parse($date)->toDateString()))->paginate()
    ])->withViewData([
      'title' => 'Appointments List',
      'meta' =>''
    ]);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('appointment::create');
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request, Patient $patient)
  {
    $this->authorize('create', Appointment::class);

    $request->validate([
      'doctor_id' => ['required', 'exists:doctors,id'],
      'appointment_date' => ['required', 'date']
    ]);

    $patient->appointments()->create([
      'doctor_id' => $request->doctor_id,
      'front_desk_user_id' => $request->user()->id,
      'appointment_date' => $request->appointment_date,
    ]);

    return redirect()->route('patients.show', $patient)->withFlash(['success' => 'Patient appointment booked. The assigned doctor will see the appointment in his schedule.']);
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    return view('appointment::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view('appointment::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
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
