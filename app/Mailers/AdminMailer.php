<?php namespace RentGorilla\Mailers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Mail\Mailer;
use RentGorilla\User;

class AdminMailer {

    protected $adminEmail;

    protected $mailer;

    public function __construct(Repository $config, Mailer $mailer)
    {
        $this->adminEmail = $config->get('mail.admin');
        $this->mailer = $mailer;
    }


    public function sendToAdmin($subject, $view, $data = [])
    {
        $to = $this->adminEmail;

        $this->mailer->queue($view, $data, function($message) use ($to, $subject)
        {
            $message->to($to)->subject($subject);
        });
    }

    public function sendToAdminWithReplyTo($subject, $view, $data = [], $email, $name)
    {
        $to = $this->adminEmail;

        $this->mailer->queue($view, $data, function($message) use ($to, $subject, $email, $name)
        {
            $message->to($to)->subject($subject)->replyTo($email, $name);
        });
    }


    public function sendContactForm(User $user, $question)
    {
        $view = 'emails.admin.support-request';

        $data = [
            'name' => $user->getFullName(),
            'email' => $user->email,
            'phone' => $user->phone,
            'question' => $question
        ];

        $subject = 'RG Support Request';
        $email = $user->email;
        $name = $user->getFullName();

        $this->sendToAdminWithReplyTo($subject, $view, $data, $email, $name);
    }


}