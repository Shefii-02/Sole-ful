<?php

namespace App;
use App\Jobs\Email;
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


    public static function sendOrderNotification($order){
        self::email(new Email([
            'emailClass' => 'DefaultMail',
            'to' => $order->billingAddress->email,
            'bccStatus' => false,
            'subject' => 'Thank you for Order',
            'contents' => view('email.customerOrderNotification')->withOrder($order)->render(),
        ]));

        self::email(new Email([
            'emailClass' => 'DefaultMail',
            'to' => env('DEV_EMAIL'),
            'bccStatus' => false,
            'subject' => 'Received new Order',
            'contents' => view('email.adminOrderNotification')->withOrder($order)->render(),
        ]));
    }


    // /**
    //  * Dispatch email job
    //  * @param Email $mail
    //  */
    public static function email(Email $mail){
        !ENV('EMAIL', false) OR dispatch($mail);
    }
}
