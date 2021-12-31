<?php

namespace App\Modules\CaseNote\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\CaseNote\Http\Requests\CreateCaseNoteRequest;

class CaseNoteController extends Controller
{
  public function index(Request $request, Appointment $appointment)
  {
    return inertia('CaseNote::ViewCaseNotes', [
      'appointment' => $appointment->load(['patient']),
      'case_notes' => $appointment->case_notes
    ])->withViewData([
      'title' => 'Appointments List',
      'meta' =>''
    ]);
  }

  public function store(CreateCaseNoteRequest $request, Appointment $appointment)
  {
    $this->authorize('chartPatientSymptoms', Patient::class);

    $request->createCaseNote();

    return redirect()->route('appointments.case_notes', $appointment)->withFlash(['success' => 'Case Note updated!']);
  }

  public function show($id)
  {
    return view('casenote::show');
  }
}
