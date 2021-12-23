<?php

namespace App\Modules\SuperAdmin\Http\Requests;

use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'email' => ['required', 'email'],
      'password' => ['required', 'string', Password::defaults()],
      'name' => ['required', 'string'],
      'avatar' => ['required', 'image'],
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
    if ($this->hasFile('avatar')) {
      return array_merge((collect(parent::validated())->except('avatar'))->all(), [
        'avatar_url' => compress_image_upload('avatar', 'user-avatars/', 'user-avatars/thumbs/', 1920, true, 100)['thumb_url'],
      ]);
    } else {
      return parent::validated();
    }
  }

  public function createUser($userType)
  {
    $userType::create($this->validated());
  }
}
