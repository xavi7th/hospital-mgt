<?php

namespace App\Modules\FrontDeskUser\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class AccountActivated extends Notification implements ShouldQueue
{
  use Queueable;

  public function __construct()
  {
    $this->afterCommit = true;
  }

  public function via()
  {
    return ['mail'];
  }

  public function toMail(FrontDeskUser $front_desk_user)
  {
    return (new MailMessage)
      ->subject(config('app.name') . ' Account Activated!')
      ->greeting('Hello ' . $front_desk_user->first_name . '!')
      ->line('You are getting thie email because you or someone created an account on ' . config('app.name') . '.')
      ->line('We have gone through the details you provided us and we are glad to inform you that your account has just been activated.')
      ->line('You can now login to your account using the button below.')
      ->action('Login', route('auth.login'))
      ->line('Once again, welcome to ' . config('app.name') . '. We look forward to a mutually profitable relationship with you going forward.')
      ->salutation(new HtmlString('Regards, <br> The accounts team.'));
  }

}
