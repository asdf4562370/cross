<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SystemMessage extends Notification
{
    use Queueable;

    private $type;
    private $title;
    private $content;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        $this->type = $msg["type"];
        $this->title = $msg["title"];
        $this->content = $msg["content"];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
