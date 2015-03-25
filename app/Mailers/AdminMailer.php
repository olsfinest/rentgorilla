<?php namespace RentGorilla\Mailers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Mail\Mailer;

class AdminMailer {

    protected $adminEmail;

    protected $mailer;

    public function __construct(Repository $config, Mailer $mailer)
    {
        $this->adminEmail = $config->get('config.admin_email');
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

/*
    public function sendContactForm(ContactUs $form)
    {
        $view = 'emails.admin.contactForm';

        $data = [
            'name' => $form->name,
            'email' => $form->email,
            'phone' => $form->phone,
            'comments' => $form->message
        ];

        $subject = 'MaritimeMarkets.ca contact form: ' . $form->subject;
        $email = $form->email;
        $name = $form->name;

        $this->sendToAdminWithReplyTo($subject, $view, $data, $email, $name);
    }
*/

}