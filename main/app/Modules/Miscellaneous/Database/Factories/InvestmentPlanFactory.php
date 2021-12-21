<?php

namespace App\Modules\Miscellaneous\Database\Factories;

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Container\Container;
use App\Modules\UserTransaction\Models\UserTransaction;

class InvestmentPlanFactory
{

  protected $faker;
  protected $seeds;

  public function __construct()
  {
    $this->faker = Container::getInstance()->make(Faker::class);
    $this->seeds = collect($this->definition());
  }

  /**
   * Define the data state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      [
        'name' => Str::title(UserTransaction::GOLD_PLAN . ' Plan'),
        'description' => '15 Trades/Day',
        'amount_html' => '<p class="uk-text-small uk-text-uppercase">Mergeable<span class="uk-label uk-border-pill uk-text-small uk-margin-small-left">USD 5,000</span></p>',
        'minimum_investment_amount' => UserTransaction::INVESTMENT_AMOUNTS[UserTransaction::GOLD_PLAN]/10,
        'maximum_investment_amount' => UserTransaction::INVESTMENT_AMOUNTS[UserTransaction::GOLD_PLAN],
        'features' => [
          'Validity of Plans = 7 days',
          'EFx trading Robot',
        ]
      ],
      [
        'name' => Str::title(UserTransaction::DIAMOND_PLAN . ' Plan'),
        'description' => '35 Trades/Day',
        'amount_html' => '<p class="uk-text-small uk-text-uppercase">MINIMUM FUNDING<span class="uk-label uk-border-pill uk-text-small uk-margin-small-left">USD 15,000</span></p>',
        'minimum_investment_amount' => UserTransaction::INVESTMENT_AMOUNTS[UserTransaction::DIAMOND_PLAN]/3,
        'maximum_investment_amount' => UserTransaction::INVESTMENT_AMOUNTS[UserTransaction::DIAMOND_PLAN],
        'features' => [
          'Validity of Plans = 7 days',
          'EFx trading Robot',
        ]
      ],
      [
        'name' => Str::title(UserTransaction::URANIUM_PLAN . ' Plan'),
        'description' => 'Unlimited Trades/Day',
        'amount_html' => '<p class="uk-text-small uk-text-uppercase">MINIMUM FUNDING<span class="uk-label uk-border-pill uk-text-small uk-margin-small-left">USD 30,000</span></p>',
        'minimum_investment_amount' => UserTransaction::INVESTMENT_AMOUNTS[UserTransaction::URANIUM_PLAN] - 35000,
        'maximum_investment_amount' => UserTransaction::INVESTMENT_AMOUNTS[UserTransaction::URANIUM_PLAN],
        'features' => [
          'Validity of Plans = 7 days',
          'EFx trading Robot',
        ]
      ],
      [
        'name' => Str::title(UserTransaction::CUSTOM_PLAN . ' Plan'),
        'description' => 'Custom Trades/Day',
        'amount_html' => '<span class="uk-label uk-border-pill uk-text-small">Contact Support for funding directives</span>',
        'minimum_investment_amount' => 100,
        'maximum_investment_amount' => 1000000,
        'features' => [
          'Validity of Plans = Custom duration',
          'EFx trading Robot',
        ]
      ],
    ];
  }

  public function make()
  {
    return $this->seeds;
  }

}
