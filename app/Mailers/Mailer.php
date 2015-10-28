<?php namespace RentGorilla\Mailers;

use Log;

abstract class Mailer {

    public function sendTo($user, $subject, $view, $data = [])
    {

        Log::info('Email sent: ' . $view, ['user_id' => $user->id]);

        return \Mail::queue($view, $data, function ($message) use ($user, $subject) {
            $message->to($user->email, $user->getFullName())->subject($subject);
        });


    }

    public function sendToUserWithReplyTo($user, $subject, $view, $data = [], $email, $name)
    {

        Log::info('Email sent: ' . $view, ['user_id' => $user->id]);

        return \Mail::queue($view, $data, function($message) use ($user, $subject, $email, $name)
        {
            $message->to($user->email, $user->getFullName())->subject($subject)->from($email, $name)->replyTo($email, $name)->sender(config('mail.from.address'), config('mail.from.name'))->returnPath(config('mail.from.address'));
       });

    }

}