<?php

namespace App\classes\Notifications;

use App\classes\Notifications\Interfaces\StatementNotificationSystem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotificationSystem extends Notification implements StatementNotificationSystem
{
    use Queueable;

    protected $message;

    /**
     * добавить текст для уведомления
     * @param string $message
     * @return void
     */
    public function setMessageText(string $message){
        $this->message = $message;
    }

    /**
     *  Геттер для сообщения уведомления
     * @return mixed
     */
    public function getMessage(){
        return $this->message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content($this->message);
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
