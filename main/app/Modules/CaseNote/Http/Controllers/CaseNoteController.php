<?php

namespace App\Modules\CaseNote\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\CaseNote\Http\Requests\CreateCaseNoteRequest;
use App\Modules\CaseNote\Models\CaseNote;

class CaseNoteController extends Controller
{
  public function index(Request $request, Appointment $appointment)
  {
    $this->authorize('viewAny', CaseNote::class);

    return inertia('CaseNote::ViewCaseNotes', [
      'appointment' => $appointment->load(['patient', 'vital_signs.nurse', 'case_notes.doctor']),
    ])->withViewData([
      'title' => 'Appointments List',
      'meta' =>''
    ]);
  }

  public function store(CreateCaseNoteRequest $request, Appointment $appointment)
  {
    $this->authorize('chartPatientSymptoms', Patient::class);

    $request->createCaseNote();

    return redirect()->route('casenotes.index', $appointment)->withFlash(['success' => 'Case Note updated!']);
  }

  public function show($id)
  {
    return view('casenote::show');
  }
}
