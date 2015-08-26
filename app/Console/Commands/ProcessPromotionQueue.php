<?php namespace RentGorilla\Console\Commands;

use Illuminate\Console\Command;
use RentGorilla\Promotions\PromotionManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Log;

class ProcessPromotionQueue extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rg:process-promotion-queue';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove expired promotions';
    /**
     * @var PromotionManager
     */
    protected $promotionManager;


	public function __construct(PromotionManager $promotionManager)
	{
		parent::__construct();
        $this->promotionManager = $promotionManager;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        Log::info('Running ' . $this->getName());

        $this->promotionManager->processPromotionQueue();
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
