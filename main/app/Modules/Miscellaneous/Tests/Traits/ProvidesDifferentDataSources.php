<?php

namespace App\Modules\Miscellaneous\Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\SuperAdmin\Models\SuperAdmin;


/**
 * Does the necessary steps to enable the smooth gerenration of products
 */
trait ProvidesDifferentDataSources
{
  use WithFaker;

  public function provideDifferentUserTypesWithoutAccountant()
  {
    return $this->provideDifferentUserTypes(['accountant', 'frontdeskuser']);
  }

  public function provideDifferentUserTypesWithoutDispatchAdmin()
  {
    return $this->provideDifferentUserTypes(['dispatchadmin', 'frontdeskuser']);
  }

  public function provideDifferentUserTypesWithoutCallCenterRep()
  {
    return $this->provideDifferentUserTypes(['callcenterrep', 'frontdeskuser']);
  }

  public function provideDifferentUserTypesWithoutDispatchAdminStockKeeperAndWalkInRep()
  {
    return $this->provideDifferentUserTypes(['dispatchadmin', 'stockkeeper', 'walkinrep', 'frontdeskuser']);
  }

  public function provideDifferentUserTypesWithoutSuperAdmin()
  {
    return $this->provideDifferentUserTypes(['superadmin', 'frontdeskuser']);
  }

  public function provideDifferentUserTypesWithoutSuperAdminAndAccountant()
  {
    return $this->provideDifferentUserTypes(['superadmin', 'accountant', 'frontdeskuser']);
  }

  public function provideDifferentUserTypesWithAllUsers()
  {
    return $this->provideDifferentUserTypes(['frontdeskuser']);
  }


  /**
   * Add as trait to the test class thus
   *
   * use ProvidesDifferentDataSources
   *
   *
   * And then use like this
   *
   * /**
   *  *  @dataProvider provideDifferentUserTypesWithoutCallCenterRep
   *  *\/
   *  public function test_other_users_can_not_view_list_of_customers_that_have_purchased_items_in_the_past_month($dataSource)
   *  {
   *    [$location, $user] = $dataSource();
   *  }
   *
   */
  protected function provideDifferentUserTypes(array $typesToSkip = [])
  {
    /**
     * @key salesrep is a handle for the test to refer to that pasrticular dataset
     * @fn() is required because data providers are fired before the test class is initialised. The application and the IOC is bootstrapped when the calss is initialised ao factories and other stuffs like that fail and trigger not found errors
     * @factoryOffice branch is required because the data is fired and cached before the test is initialised. When the test is initialised the database is refreshed so we need to re fire the office location factory for each dataset otherwise there will be no location in the DB
     * @factoryUser is the main thin we are needing as we see grabbed from the method using destructuring
     */
    return collect([
      'superadmin' => [
        fn () => ['Lagos', SuperAdmin::factory()->create(['id' => 4])],
      ],
    ])->reject(fn ($val, $key) => in_array($key, $typesToSkip))->all();
  }


  /**
   * * Add as trait to the test class thus
   *
   * use ProvidesDifferentDataSources
   *
   * And then use like this
   *
   *  /**
   *  @dataProvider provideInvalidDataToPurchaseBTC
   *  *\/
   *  public function an_accessory_cannot_be_created_with_invalid_data($getInvalidData, $form_field, $expected_error)
   *  {
   *    $this->actingAs($this->stock_keeper, $this->getAuthGuard($this->stock_keeper))->post(route('productaccessories.create'), $getInvalidData())
   *     ->assertSessionHasErrors([$form_field => $expected_error])
   *  }
   */
  public function provideInvalidDataToPurchaseBTC()
  {
    return [
      'required_email_field' => [
        fn () => [
          'email' => null,
        ],
        'email',
        'The email field is required.'
      ],
      'email_email_field' => [
        fn () => [
          'email' => 'tthfjhgh',
        ],
        'email',
        'The email must be a valid email address.'
      ],
      'full_name_required_field' => [
        fn () => [
          'full_name' => null,
        ],
        'full_name',
        'The full name field is required.'
      ],
      'full_name_string_required_field' => [
        fn () => [
          'full_name' => '',
        ],
        'full_name',
        'The full name field is required.'
      ],
      'full_name_must_be_string' => [
        fn () => [
          'full_name' => 10000,
        ],
        'full_name',
        'The full name must be a string.'
      ],
      'full_name_must_be_string_string_number' => [
        fn () => [
          'full_name' => '10000',
        ],
        'full_name',
        'The full name must be a string.'
      ],
      'usd_amount_required_field' => [
        fn () => [
          'usd_amount' => null,
        ],
        'usd_amount',
        'The purchase amount field is required.'
      ],
      'usd_amount_numeric_field' => [
        fn () => [
          'usd_amount' => 'rtjygkhj',
        ],
        'usd_amount',
        'The purchase amount must be a number.'
      ],
      'btc_amount_required_field' => [
        fn () => [
          'btc_amount' => null,
        ],
        'btc_amount',
        'Oops! There was a conversion error. Try again later.'
      ],
      'btc_amount_numeric_field' => [
        fn () => [
          'btc_amount' => 'rtjygkhj',
        ],
        'btc_amount',
        'Oops! There was a conversion error. Try again later.'
      ],
      'btc_wallet_required_field' => [
        fn () => [
          'btc_wallet' => null,
        ],
        'btc_wallet',
        'The btc wallet field is required.'
      ],
      'mobile_number_required_field' => [
        fn () => [
          'mobile_number' => null,
        ],
        'mobile_number',
        'The mobile number field is required.'
      ],
    ];
  }
}
