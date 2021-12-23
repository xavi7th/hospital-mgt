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

  public function transformForFrontDeskUser(FrontDeskUser $user)
  {
    return [
      'id' => (int)$user->id,
      'name' => (string)$user->name,
      'email' => (string)$user->email,
      'avatar_url' => (string)$user->avatar_url,
      'is_active' => (bool)$user->is_active,
      'is_suspended' => (bool)! $user->is_active,
      'is_activated' => (bool)$user->isAccountActivated(),
    ];
  }
}
