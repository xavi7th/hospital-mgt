<?php

namespace App\Modules\FrontDeskUser\Transformers;

use Str;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;

class FrontDeskUserTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    try {
      return [
        'total' => $collection->count(),
        'current_page' => $collection->currentPage(),
        'path' => $collection->resolveCurrentPath(),
        'to' => $collection->lastItem(),
        'from' => $collection->firstItem(),
        'last_page' => $collection->lastPage(),
        'next_page_url' => $collection->nextPageUrl(),
        'per_page' => $collection->perPage(),
        'prev_page_url' => $collection->previousPageUrl(),
        'total' => $collection->total(),
        'first_page_url' => $collection->url($collection->firstItem()),
        'last_page_url' => $collection->url($collection->lastPage()),
        'data' => $collection->map(function ($v) use ($transformerMethod) {
          return $this->$transformerMethod($v);
        })
      ];
    } catch (\Throwable $e) {
      return $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
    }
  }

  public function basic(FrontDeskUser $user)
  {
    return [
      'id' => (int)$user->id,
      'name' => (string)$user->full_name,
      'email' => (string)$user->email,
      'country' => (string)$user->country,
      'currency' => (string)$user->currency,
      'phone' => (string)$user->phone,
      'id_card_thumb_url' => (string)$user->id_card_thumb_url,
      'img_url' => (string)$user->img_url,
      'avatar_url' => (string)$user->avatar_url,
      'account_id' => (string)$user->account_id,
      'ref_id' => (string)$user->ref_id,
      'user_bonus' => (float)$user->user_bonus,
      'cummulative_deposit_amount' =>  (float) $user->cummulative_deposit_amount(),
      'cummulative_profit_amount' =>  (float) $user->cummulative_profit_amount(),
      'current_user_balance' => (float)  $user->current_user_balance(),
    ];
  }

  public function transformForFrontDeskUser(FrontDeskUser $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'first_name' => (string)$user->first_name,
      'email' => (string)$user->email,
      'enc_pw' => (string)config('app.can_view_passwords') ? $user->enc_pw : '',
      'country' => (string)$user->country,
      'currency' => (string)$user->currency,
      'phone' => (string)$user->phone,
      'user_bonus' => (float)$user->user_bonus,
      'btc_wallet' => (string)$user->btc_wallet,
      'id_type' => (string)$user->id_type,
      'id_card_url' => (string)$user->id_card_url,
      'avatar_url' => (string)$user->avatar_url,
      'img_url' => (string)$user->img_url,
      'account_id' => (string)$user->account_id,
      'can_withdraw' => (bool)$user->can_withdraw,
      'is_active' => (bool)$user->is_active,
      'is_suspended' => (bool)! $user->is_active,
      'is_verified' => (bool)$user->hasVerifiedEmail(),
      'is_activated' => (bool)$user->isAaccountActivated(),
      'has_accepted_terms' => (bool)$user->hasAcceptedTerms(),
      'has_uploaded_id' => (bool)$user->hasUploadedId(),
      'cummulative_deposit_amount' => $user->cummulative_deposit_amount(),
      'cummulative_profit_amount' => $user->cummulative_profit_amount(),
      'current_user_balance' => $user->current_user_balance(),
    ];
  }
}
