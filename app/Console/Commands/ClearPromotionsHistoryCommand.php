<?php namespace RentGorilla\Console\Commands;

use Illuminate\Console\Command;
use RentGorilla\Tasks\Daily\ClearPromotionsHistory;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearPromotionsHistoryCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rg:clear-promotions-history';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clears out promotion history greater than 30 days';
    /**
     * @var ClearPromotionsHistory
     */
    protected $clearPromotionsHistory;


    public function __construct(ClearPromotionsHistory $clearPromotionsHistory)
	{
		parent::__construct();

        $this->clearPromotionsHistory = $clearPromotionsHistory;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->clearPromotionsHistory->clear();
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
