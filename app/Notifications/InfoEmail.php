<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class InfoEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //$notifiable->getKey()

        return (new MailMessage)
                ->subject(Lang::get('We welcome you onboard. Please follow the links to understand the system.'))
                ->action('https://backend.writeme.ai/amember/page/documentation', url('https://backend.writeme.ai/amember/page/documentation'))
                ->line(Lang::get('We are looking forward to hearing from you if you face any problem.').$this->user->verify_code)
                ->line(Lang::get('Please use this link to send us a support ticket:')
                ->action('https://backend.writeme.ai/amember/helpdesk', url('https://backend.writeme.ai/amember/helpdesk'))

            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
