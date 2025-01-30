<?php

namespace App;
use App\Jobs\Email;
use App\Models\{Account, User, Ad, Property, SubscriptionOrder, Ticket};
use Illuminate\Http\Request;

trait Emails{

    public static function sendError(array $content){
        self::email(new Email([
            'emailClass' => 'DefaultMail',
            'to' => env('DEV_EMAIL'),
            'bccStatus' => false,
            'subject' => __("Error occured"),
            'contents' => view('email.exception')->withContent($content)->render(),
        ]));
    }


    /**
     * Dispatch email job
     * @param Email $mail
     */
    public static function email(Email $mail){
        !ENV('EMAIL', false) OR dispatch($mail);
    }
}
