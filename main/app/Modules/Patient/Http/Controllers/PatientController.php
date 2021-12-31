<?php

namespace App\Modules\Patient\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Http\Requests\CreatePatientRequest;

class PatientController extends Controller
{
  public function index(Request $request)
  {
    $patients = collect([]);

    if (Gate::allows('viewAny', Patient::class)) {
      $patients = Patient::all();
    }
    elseif (Gate::allows('takePatientsVitals', Patient::class) || Gate::allows('chartPatientSymptoms', Patient::class)) {
      $patients = Patient::with(['appointments' => fn($q) => $q->vitalsTaken()->pending()->posted(), 'appointments.case_notes', 'appointments.doctor', 'appointments.nurse'])->whereHas('appointments', fn($q) => $q->vitalsTaken()->pending()->posted())->get();
    }
    else{
      abort(403, 'You are not allowed to view patient\'s list');
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
      'patient' => $patient->load('appointments.case_notes'),
      'pending_appointment' => $patient->pending_appointment->load(['doctor', 'booked_by'])
    ])->withViewData([
      'title' => 'List of Patients',
      'meta' => ''
    ]);
  }
}
