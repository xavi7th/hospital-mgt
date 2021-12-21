<?php

namespace App\Modules\Miscellaneous\Database\Seeders;

use App\Modules\Miscellaneous\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Testimonial::factory()->count(7)->create();
    }
}
