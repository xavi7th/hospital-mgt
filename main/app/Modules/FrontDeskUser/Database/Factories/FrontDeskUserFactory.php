<?php
namespace App\Modules\FrontDeskUser\Database\Factories;

use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FrontDeskUserFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = FrontDeskUser::class;

  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    return [
      'email' => $this->faker->email(),
      'password' => 'pass',
      'first_name' => $this->faker->firstName(),
      'last_name' => $this->faker->lastName(),
      'phone' => $this->faker->e164PhoneNumber(),
      'avatar_url' =>null,
      'verified_at' => null,
      'is_active' => false,
      'country' => $this->faker->countryCode(),
      'acc_type' => null,
      'acc_type_color' => null,
      'currency' => $this->faker->currencyCode(),
      'btc_wallet' => null,
      'can_withdraw' => false,
      'force_logout' => false,
    ];
  }

  public function active()
  {
    return $this->state(function (array $attributes) {
      return [
        'is_active' => true,
      ];
    });
  }

  public function verified()
  {
    return $this->state(function (array $attributes) {
      return [
        'verified_at' => now()->subDays(3),
      ];
    });
  }

  public function can_withdraw()
  {
    return $this->state(function (array $attributes) {
      return [
        'can_withdraw' => true,
      ];
    });
  }

  public function force_logout()
  {
    return $this->state(function (array $attributes) {
      return [
        'force_logout' => true,
      ];
    });
  }
}
