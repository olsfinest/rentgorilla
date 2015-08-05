<?php namespace RentGorilla\Mailers;

use Log;

abstract class Mailer {

    public function sendTo($user, $subject, $view, $data = [])
    {
        return \Mail::queue($view, $data, function ($message) use ($user, $subject) {
            $message->to($user->email, $user->getFullName())->subject($subject);
        });

        Log::info('Email sent: ' . $view, ['user_id' => $user->id]);
    }

    public function sendToUserWithReplyTo($user, $subject, $view, $data = [], $email, $name)
    {

        return \Mail::queue($view, $data, function($message) use ($user, $subject, $email, $name)
        {
            $message->to($user->email, $user->getFullName())->subject($subject)->replyTo($email, $name);
        });

        Log::info('Email sent: ' . $view, ['user_id' => $user->id]);
    }

}