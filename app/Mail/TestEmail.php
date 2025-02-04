<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable

{

    use Queueable, SerializesModels;
    public $content;
    /**

     * Create a new message instance.

     *

     * @return void

     */

    public function __construct()

    {

        //
        $this->content = null;

    }

    /**

     * Build the message.

     *

     * @return $this

     */

    public function build()

    {

        return $this->view('email.base');

    }

}