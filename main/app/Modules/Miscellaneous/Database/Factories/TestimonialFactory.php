<?php

namespace App\Modules\Miscellaneous\Database\Factories;

use Illuminate\Support\Facades\Storage;
use App\Modules\Miscellaneous\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Testimonial::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    Storage::makeDirectory('public/testimonial_images/', 0777);

    return [
      'name' => $this->faker->name(),
      'city' => $this->faker->city(),
      'country' => $this->faker->randomElement(['USA', 'UK', 'Brazil', 'Portugal', 'Argentina', 'Kenya', $this->faker->country()]),
      'img' => '/storage/testimonial_images/' . $this->faker->file(resource_path('img/team/'), public_path('storage/testimonial_images/'), false),
      'testimonial' => $this->faker->unique()->randomElement([
        "Very fast payouts and the profit margins are somewhat unbelievable. I've altogether made a little over $5000 in less than no time",
        "So many amazing things about them but I just love the support team the best. Always almost instantenous and curteous replies all the time, Good job guys.",
        "I love to have extra money. If I have time, I invest by myself, but sometimes you won't have time for your family and friends especially when you are on holidays. It is sooo great to come back rested, tanned etc and with extra money in your accounts. Good work guys.",
        "This is a realistic program for anyone looking for a site to invest with. Paid to me regularly. Good and quick profit. I used this website many times and I can recommend it to anyone. Keep up the good work.",
        "Very fast payouts and the profit margins are somewhat unbelievable. I've altogether made a little over $5000 in less than no time",
        "Great work guys and I can confirm that I rode at least 300 of those pips of profits which your trading signals spotted over the last 5 days. It was great for my account. I just need to know how on earth you guys manage it?",
        "Actually I think your service is brilliant. By waiting a bit longer according to the forecast I saved an extra 10% on the exchange of my funds. The support team is also nice and fast in the answers",
        "Good Signals. They deliver quality signals. The more patient you are the more likely you are going to grow your account over time. Your service is excellent and I certainly agree with your views on what actually moves the markets",
        "When you talk about trade comparison with great results and reputation. You look no further cause its all covered till the point of withdrawing your earnings Nothing beats that...",
        "This is the real definition of being top notch. I literally watched my account blossom into what it is today in just under 30 days and I believe that there is more to come!",
        "The " . config('app.name') . " team provided me with good strategies to be able to increase my investment and earning potentials and secure my profits when i asked them about it."
      ]),
    ];
  }
}
