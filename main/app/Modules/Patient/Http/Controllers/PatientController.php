<?php

namespace App\Modules\Patient\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Http\Requests\CreatePatientRequest;

class PatientController extends Controller
{
  public function index(Request $request)
  {
    $patients = collect([]);

    if ($request->user()->isFrontDeskUser()) {
      $this->authorize('viewAny', Patient::class);
      $patients = Patient::all();
    }
    elseif ($request->user()->isNurse()) {
      $this->authorize('takePatientsVitals', Patient::class);
      $patients = Patient::with(['appointments' => fn($q) => $q->fulfilled()->vitalsTaken()->posted(), 'appointments.case_notes', 'appointments.doctor', 'appointments.posted_by'])->whereHas('appointments', fn($q) => $q->fulfilled()->vitalsTaken()->posted())->get();
    }

    return Inertia::render('Patient::PatientList', [
      'patients' => $patients
    ])->withViewData([
      'title' => 'List of Patients',
      'meta' => ''
    ]);
  }

  public function store(CreatePatientRequest $request)
  {
    $patient = $request->createPatientRecord();

    return redirect()->route('patients.index')->withFlash(['success' => 'Patient record created. You can now schedule appointments for this patient.']);
  }

  public function show(Patient $patient)
  {
    return inertia('FrontDeskUser::PatientDetails', [
      'patient' => $patient->load('appointments.case_note'),
      'pending_appointment' => $patient->pending_appointment->load(['doctor', 'booked_by'])
    ])->withViewData([
      'title' => 'List of Patients',
      'meta' => ''
    ]);
  }

  public function edit($id)
  {
    return view('patient::edit');
  }

  public function update(Request $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    //
  }
}
