<?php

namespace App\Notifications;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CouponCreatedNotification extends Notification
{
    use Queueable;

    public $coupon;
    /**
     * Create a new notification instance.
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
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
        if ($this->coupon->discount_type == 'percent') {
            $discount = $this->coupon->discount . '%';
        } else if ($this->coupon->discount_type == 'amount') {
            $discount = number_format($this->coupon->discount) . ' VND';
        }
        return [
            'message' => "Có 1 mã giảm giá mới cho bạn '{$this->coupon->name}' với giá trị {$discount}.",
            'coupon_id' => $this->coupon->id,
            'coupon_name' => $this->coupon->name,
            'coupon_discount' => $this->coupon->discount,
            'coupon_discount_type' => $this->coupon->discount_type,
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
