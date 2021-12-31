<?php

namespace App\Modules\CaseNote\Http\Requests;

use App\Modules\CaseNote\Models\CaseNote;
use Illuminate\Foundation\Http\FormRequest;

class CreateCaseNoteRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'patient_symptoms' => ['required', 'string'],
      'diagnosis' => ['required', 'string'],
      'prescriptions' => ['required', 'string'],
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  public function validated(): array
  {
    return array_merge(parent::validated(), [
      'appointment_id' => $this->appointment->id,
      'doctor_id' => $this->user()->id,
    ]);
  }

  public function createCaseNote()
  {
    CaseNote::create($this->validated());
  }
}
