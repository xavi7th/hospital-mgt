<?php

namespace App\Modules\Patient\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Http\Requests\CreatePatientRequest;

class PatientController extends Controller
{
    public function index()
    {
      $this->authorize('viewAny', Patient::class);

      return Inertia::render('Patient::PatientList', [
        'patients' => Patient::all()
      ])->withViewData([
        'title' => 'List of Patients',
        'meta' =>''
      ]);
    }

    public function store(CreatePatientRequest $request)
    {
      $patient = $request->createPatientRecord();

      return redirect()->route('patients.show')->withFlash(['success' => 'Patient record created. You can now schedule appointments for this patient.']);
    }

    public function show($id)
    {
        return view('patient::show');
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
