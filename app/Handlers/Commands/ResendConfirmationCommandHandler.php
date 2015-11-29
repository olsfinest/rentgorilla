<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ResendConfirmationCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Repositories\UserRepository;

class ResendConfirmationCommandHandler
{
    /**
     * @var UserRepository
     */
    protected $repository;
    /**
     * @var UserMailer
     */
    protected $mailer;


    public function __construct(UserRepository $repository, UserMailer $mailer)
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
    }

    /**
     * Handle the command.
     *
     * @param  ResendConfirmationCommand  $command
     * @return void
     */
    public function handle(ResendConfirmationCommand $command)
    {
        $user = $this->repository->getUserByAttribute('email', $command->email);

        $user = $this->repository->reconfirm($user);

        $this->mailer->sendConfirmation($user);

        return $user;
    }
}
