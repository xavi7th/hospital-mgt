<?php

namespace App\Modules\Patient\Http\Requests;

use App\Modules\Patient\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'email' => ['nullable', 'email', 'unique:patients,email'],
      'phone' => ['required', 'string', 'unique:patients,phone'],
      'name' => ['required', 'string', 'max:70'],
      'avatar' => ['required', 'image'],
      'date_of_birth' => ['required', 'date'],
      'next_of_kin' => ['required', 'string', 'max:70'],
      'next_of_kin_phone' => ['required', 'string'],
    ];
  }

  public function messages()
  {
    return [
      'avatar.required' => 'The patient\'s image is required',
      'avatar.image' => 'The patient\'s image must be an image file',
    ];
  }


  public function validated(): array
  {
    if ($this->hasFile('avatar')) {
      return array_merge((collect(parent::validated())->except('avatar'))->all(), [
        'avatar_url' => compress_image_upload('avatar', 'patient-avatars/', 'patient-avatars/thumbs/', 1920, true, 200)['thumb_url'],
      ]);
    } else {
      return parent::validated();
    }
  }

  public function createPatientRecord(): Patient
  {
    return Patient::create($this->validated());
  }

}
