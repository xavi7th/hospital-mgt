<?php

namespace App\Modules\Miscellaneous\Traits;

use ReflectionClass;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This trait implements a way to delete all dependent relations once the model is deleted
 *
 * Each class that implements this traist must have this method
 *
 * public static function boot()
 * {
 *   parent::boot();
 *
 *   static::deleting(function (self $wth_req){
 *     $wth_req->deleteAllRelationships();
 *   });
 * }
 */
trait DeletesRelationships
{
  use SoftDeletes;

  public function deleteAllRelationships(): void
  {
    $reflector = new ReflectionClass($this);
    $relations = [];
    foreach ($reflector->getMethods() as $reflectionMethod) {
        $returnType = $reflectionMethod->getReturnType();
        if ($returnType) {
            if (in_array(class_basename($returnType->getName()), ['HasOne', 'HasMany', 'BelongsToMany', 'MorphToMany', 'MorphTo'])) {
                $relations[] = $reflectionMethod;
            }
        }
    }
    // ray($relations);

    try {
      $current_relation = (object)[];
      collect($relations)->each(function ($relation, $key) use(&$current_relation) {
        $current_relation = $relation;
        $this->{$relation->name}()->forceDelete();
      });
    } catch (\Throwable $th) {
      if ($th instanceof QueryException && $th->getCode() == 23000) {

        $relation = $this->{$current_relation->name};

        /**
         * Force trigger the Eloquent Event by calling delete in the Eloquent isntance
         *
         * ? If the relationship has other relationships, calling delete on the query builder will cause am integrity failure. As a backup trigger the eloquent delete
         */
        if ($relation instanceof Collection) {
          $relation->each->forceDelete();
        }
        else{
          $relation->forceDelete();
        }

      }
    }
  }
}
