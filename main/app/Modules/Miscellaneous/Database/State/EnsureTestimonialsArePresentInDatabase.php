<?php

namespace App\Modules\Miscellaneous\Database\State;

use App\Modules\Miscellaneous\Models\Testimonial;
use App\Modules\Miscellaneous\Database\Seeders\TestimonialTableSeeder;

class EnsureTestimonialsArePresentInDatabase
{
  public function __invoke()
  {
    if ($this->has_testimonials()) {
      return;
    }
    (new TestimonialTableSeeder())->run();
  }

  public function has_testimonials(): bool
  {
    return Testimonial::count() > 0;
  }
}
