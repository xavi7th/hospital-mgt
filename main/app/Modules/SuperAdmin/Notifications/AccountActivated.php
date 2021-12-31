<?php

namespace App\Modules\SuperAdmin\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
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

  public function toMail(User $user)
  {
    return (new MailMessage)
      ->subject(config('app.name') . ' Account Activated!')
      ->greeting('Hello ' . $user->first_name . '!')
      ->line('Your ' . config('app.name') . ' account has been created and activated.')
      ->line('You can login to your account using the link below.')
      ->action('Login', route('auth.login'))
      ->line('Contact your admin for login details.')
      ->salutation(new HtmlString('Regards, <br> The accounts team.'));
  }

}
