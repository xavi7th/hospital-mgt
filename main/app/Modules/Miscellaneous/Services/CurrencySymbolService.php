<?php

namespace App\Modules\Miscellaneous\Services;

class CurrencySymbolService
{
  public function resolve(float $amount, $currencyName = 'USD') : string
  {
    return (function () use ($currencyName) {
      switch ($currencyName) {
        case 'USD':
          return '$';
          break;
        case 'GBP':
          return '£';
          break;
        case 'EUR':
          return '€';
          break;
        case 'CAD':
          return 'C$';
          break;
        case 'JPY':
          return '¥';
          break;
        case 'BTC':
          return '₿';
          break;

        default:
          return $currencyName ?? 'N/A';
          break;
      }
    })() . $amount;
  }
}
