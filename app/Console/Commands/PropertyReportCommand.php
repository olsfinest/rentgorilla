<?php namespace RentGorilla\Console\Commands;

use Illuminate\Console\Command;
use RentGorilla\Mailers\UserMailer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PropertyReportCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rg:property-report';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sends a property report to all users';
    /**
     * @var UserMailer
     */
    protected $mailer;

    /**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(UserMailer $mailer)
	{
		parent::__construct();
        $this->mailer = $mailer;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->mailer->sendReportToAllUsers();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}

}
