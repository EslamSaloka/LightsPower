<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CancelAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$message)
    {
        $this->user     = $user;
        $this->message  = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $messageData     = "مرحبا {{NAME}}";
        $messageData    .= "<br/>";
        $messageData    .= $this->message;
        $message         = str_replace(["{{NAME}}"],[$this->user->username],$messageData);
        return $this->subject(getSettings("system_name",env('APP_NAME')))->markdown('emails.welcome')->with([
            'message' => $message,
            'url'     => url("/dashboard"),
        ]);
    }
}
