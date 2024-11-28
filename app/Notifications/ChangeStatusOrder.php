<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeStatusOrder extends Notification
{
    use Queueable;

    public $order;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
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
        return ['database'];
    }

    public function toDatabase()
    {
        if ($this->order->order_status == 'return') {
            $message = "Có yêu cầu hoàn hàng từ người dùng " . $this->order->user->name . " đơn hàng #"  . $this->order->id;
            $url = route('admin.orders.return-order');
            return [
                'message' => $message,
                'url' => $url,
            ];
        } else if ($this->order->order_status == 'processed_and_ready_to_ship') {
            $message = "Đơn hàng #" . $this->order->id . " đã xử lý và sẵn sàng vận chuyển";
        } else if ($this->order->order_status == 'dropped_off') {
            $message = "Đơn hàng #" . $this->order->id . " đã được giao cho đơn vị vận chuyển";
        } else if ($this->order->order_status == 'shipped') {
            $message = "Đơn hàng #" . $this->order->id . " đã vận chuyển";
        } else if ($this->order->order_status == 'delivered') {
            $message = "Đơn hàng #" . $this->order->id . " đã được giao thành công";
        }

        return [
            'message' => $message,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
