<?php namespace RentGorilla\Console\Commands;

use Illuminate\Console\Command;
use RentGorilla\Tasks\Daily\DeactivateRentals as Task;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeactivateRentals extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rg:deactivate-rentals';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deactivate rentals when accounts expire';
    /**
     * @var Task
     */
    protected $deactivateRentals;


    public function __construct(Task $deactivateRentals)
	{
		parent::__construct();
	    $this->deactivateRentals = $deactivateRentals;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->deactivateRentals->checkIfAccountExpired();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
