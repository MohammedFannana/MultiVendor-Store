<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];


        // if you want to add options for user to select the way of notifictions
        // $channels = [];
        // if ($notifiable->notification_preferences['order_created']['sms'] ?? false) {
        //     $channels[] = 'vonage';
        // }

        // if ($notifiable->notification_preferences['order_created']['mail'] ?? false) {
        //     $channels[] = 'mail';
        // }

        // if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false) {
        //     $channels[] = 'broadcast';
        // }

        // return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    // if use broadcast build tobroadcast
    // if use vonage use tovonage ...
    public function toMail(object $notifiable): MailMessage
    {
        // billingAddress is function relation ship
        $addr = $this->order->billingAddress;
        return (new MailMessage)
            //use subject to not show OrderCreatedNotification
            // use {} alternative .. conntacnation
            //greeting => hello Message
            //you can add ->line as you want is paragraph
            //you can use ->from() to define who send this message or use .env
            ///////
            //or you can use ->view('define the path of view') and build ,add what you want you can add thw more
            // detaile an information of order if use the view ypu not need line and action and greeting 
            //you build in view file
            ->subject('New Order #' . $this->order->number)
            ->greeting("Hi {$notifiable->name},")
            ->line("A new Order (#{$this->order->number}) created by {$addr->name} from {$addr->country}.")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
        // country_name is function in OrderAddress Model
        // ->line message
    }

    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;

        // is store in data column in database
        return [
            'body'     => "A new Order (#{$this->order->number}) created by {$addr->name} from {$addr->country}.",
            'icon'     => 'fas fa-file',
            'url'      =>  url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }


    public function toBroadcast($notifiable)
    {
        $addr = $this->order->billingAddress;

        // return Object
        return new BroadcastMessage([
            'body'     => "A new Order (#{$this->order->number}) created by {$addr->name} from {$addr->country}.",
            'icon'     => 'fas fa-file',
            'url'      =>  url('/dashboard'),
            'order_id' => $this->order->id,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
