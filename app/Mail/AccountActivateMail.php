<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivateMail extends Mailable {

    use Queueable, SerializesModels;

    private $name;
    private $link;

    public function __construct(string $name, string $link) {
        $this->name = $name;
        $this->link = $link;
    }

    public function build() {
        return $this
            ->subject('Account activate')
            ->markdown('mail.activate', [
                'name' => $this->name,
                'link' => $this->link
            ]);
    }
}
