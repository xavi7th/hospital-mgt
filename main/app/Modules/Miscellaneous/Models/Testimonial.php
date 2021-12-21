<?php

namespace App\Modules\Miscellaneous\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Miscellaneous\Database\Factories\TestimonialFactory;

class Testimonial extends Model
{
  use HasFactory;
  const DASHBOARD_ROUTE_PREFIX = 'testimonials';
  const ROUTE_NAME_PREFIX = 'testimonials.';

  protected $fillable = ['name', 'city', 'country', 'img', 'testimonial',];

  protected static function newFactory()
  {
    return TestimonialFactory::new();
  }
}
