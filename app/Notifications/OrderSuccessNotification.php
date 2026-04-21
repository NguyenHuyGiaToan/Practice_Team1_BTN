<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderSuccessNotification extends Notification
{
use Queueable;

    private $data; 

    public function __construct($data)
    {
        $this->data = $data; 
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Đặt hàng thành công")
                    ->view("email_template.don_hang_thanh_cong", ["data" => $this->data]); 
    }
}
