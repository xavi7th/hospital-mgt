<?php

namespace App\Modules\Miscellaneous\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as RouteObject;
use Illuminate\Support\Traits\Conditionable;

class MenuService
{
  use Conditionable;

  private $user;
  private $is_heirarchical = false;

  public function setUser(?User $user): self
  {
    $this->user = $user;
    return $this;
  }

  public function setHeirarchical(bool $is_heirarchical): self
  {
    $this->is_heirarchical = $is_heirarchical;
    return $this;
  }

  public function getRoutes(): array
  {
    if (!$this->user) {
      return $this->getPublicRoutes();
    } else {
      return $this->getUserRoutes();
    }
  }

  private function getPublicRoutes()
  {
    $routes =  collect(Route::getRoutes()->getRoutesByName())->filter(function ($value, $key) {
      return in_array('GET', $value->methods())  &&  Str::startsWith($value->getName(), ['app.', 'auth']) && isset($value->defaults['menu']) && !$value->defaults['menu']['nav_skip'];
    }) ->map(function (RouteObject $route) {
      return (object)[
        'uri' => $route->uri(),
        // 'method' => $route->methods()[0],
        'name' => $route->getName(),
        'nav_skip' => $route->defaults['menu']['nav_skip'] ?? false,
        'icon' => $route->defaults['menu']['icon'] ?? null,
        'menu_name' => $route->defaults['menu']['name'],
        'sort_order' =>  $route->defaults['menu']['sort_order'],
        'group' => ($route->defaults['menu']['group'] ?? $route->defaults['menu']['name']),
        'group_sort' => ($route->defaults['menu']['group_order'] ?? null),
      ];
    })
    ->sortBy([
      ['sort_order', 'asc'],
      ['group_sort', 'asc']
    ])
    ->when(! $this->is_heirarchical, fn($v) => $v->groupBy('menu_name'))
    ->when($this->is_heirarchical, fn($v) => $v->groupBy('group'));

    return $routes->toArray();

    // return $this->is_heirarchical ? $this->getHeirachicalRoutes($routes) : $routes->values()->toArray();
  }

  public function getAllRoutes(): array
  {
    if (!$this->user) {
      return $this->getPublicRoutes();
    } else {
      return $this->getAllUserRoutes();
    }
  }

  public function getRoutesUsingMiddleware(): array
  {
    if (!$this->user) {
      return $this->getPublicRoutes();
    } else {
      return $this->getUserRoutesViaMiddleware();
    }
  }

  private function getUserRoutes(): array
  {
    // dd(
    //   collect(Route::getRoutes()->getRoutesByMethod()['GET'])
    // );
    $routes =  collect(Route::getRoutes()
    ->getRoutesByMethod()['GET'])->filter(function ($value, $key) {
      return isset($value->defaults['menu']) && !$value->defaults['menu']['nav_skip'] && !is_null($value->defaults['menu']['authorization']) && Gate::forUser($this->user)->allows(Str::before($value->defaults['menu']['authorization'], ','), Str::after($value->defaults['menu']['authorization'], ','));
    })
    ->map(function (RouteObject $route) {
      return (object)[
        'uri' => $route->uri(),
        'name' => $route->getName(),
        'nav_skip' => $route->defaults['menu']['nav_skip'] ?? false,
        'icon' => $route->defaults['menu']['icon'] ?? null,
        'menu_name' => $route->defaults['menu']['name'],
        'sort_order' =>  $route->defaults['menu']['sort_order'],
        'group' => ($route->defaults['menu']['group'] ?? $route->defaults['menu']['name']),
        'group_sort' => ($route->defaults['menu']['group_order'] ?? null),
      ];
    })
    ->sortBy([
      ['sort_order', 'asc'],
      ['group_sort', 'asc']
    ])
    ->when(! $this->is_heirarchical, fn($v) => $v->groupBy('menu_name'))
    ->when($this->is_heirarchical, fn($v) => $v->groupBy('group'));

    return $routes->toArray();
  }

  private function getUserRoutesViaMiddleware(): array
  {
    $routes = collect(Route::getRoutes()->getRoutesByMethod()['GET'])
      ->filter(function ($value, $key) {
        return isset($value->defaults['menu']) && !$value->defaults['menu']['nav_skip'] && Gate::allows(Str::of(collect($value->middleware())->first(fn ($v) => Str::contains($v, 'can:')))->after('can:')->before(',')->__toString(), Str::of(collect($value->middleware())->first(fn ($v) => Str::contains($v, 'can:')))->after('can:')->after(',')->__toString());
      })
      ->map(function (RouteObject $route) {
        return (object)[
          'uri' => $route->uri(),
          'name' => $route->getName(),
          'nav_skip' => $route->defaults['menu']['nav_skip'] ?? false,
          'icon' => $route->defaults['menu']['icon'] ?? null,
          'menu_name' => $route->defaults['menu']['name']
        ];
      });

    return $this->is_heirarchical ? $this->getHeirachicalRoutes($routes) : $routes->values()->toArray();
  }

  private function getAllUserRoutes(): array
  {
    $routes = collect(Route::getRoutes()->getRoutesByName())
      ->filter(function ($value, $key) {
        return isset($value->defaults['menu']) && !$value->defaults['menu']['nav_skip'] && Gate::allows(Str::before($value->defaults['menu']['authorization'], ','), Str::after($value->defaults['menu']['authorization'], ','));
      })
      ->map(function (RouteObject $route) {
        return (object)[
          'uri' => $route->uri(),
          'method' => $route->methods()[0],
          'name' => $route->getName(),
          'nav_skip' => $route->defaults['menu']['nav_skip'] ?? false,
          'icon' => $route->defaults['menu']['icon'] ?? null,
          'menu_name' => $route->defaults['menu']['name']
        ];
      });

    return $this->is_heirarchical ? $this->getHeirachicalRoutes($routes) : $routes->values()->toArray();
  }

  private function getHeirachicalRoutes(&$routes): array
  {
    $tmp = $routes;
    $routes = [];
    /**
     * * Group them based on the route url prefix into arrays
     * eg all company-bank-accounts/* get lumped into one array
     */
    $tmp->map(function ($route) use (&$routes) {
      // return $routes[$route->icon][] = $route;
      return $routes[Str::of($route->uri)->before('/')->replace('-', ' ')->title()->__toString()][] = $route;
    });
    return $routes;
  }
}
