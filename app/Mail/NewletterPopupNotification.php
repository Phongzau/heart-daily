<?php

namespace App\Mail;

use App\Models\NewletterPopup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewletterPopupNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $popup;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(NewletterPopup $popup, $user)
    {
        $this->popup = $popup;
        $this->user = $user;
    }

    /**
     * Build the email message.
     */
    public function build()
    {
        return $this->subject('Thông báo về chương trình ưu đãi mới')
                    ->view('client.page.auth.emails.newletter_popup_notification')
                    ->with([
                        'popupTitle' => $this->popup->title,
                        'popupDescription' => $this->popup->description,
                        'popupImage' => $this->popup->image,
                        'user' => $this->user,
                    ]);
    }
}
