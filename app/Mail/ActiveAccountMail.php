<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ActiveAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        
        
        
        
        $messageData     = "تهانينا {{NAME}}";
        $messageData    .= "<br/>";
        $messageData    .= "تم قبول متجرك للانضمام الى عالم لينكر";
        $messageData    .= "<br/>";
        $messageData    .= "يمكنك الان الدخول لحسابك والاشتراك في الباقة";
        $messageData    .= "<br/>";
        $message         = str_replace(["{{NAME}}"],[$this->user->username],$messageData);
        return $this->subject(getSettings("system_name",env('APP_NAME')))->markdown('emails.welcome')->with([
            'message' => $message,
            'url'     => url("/dashboard"),
        ]);
    }
}
