<?php namespace RentGorilla\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AwardAchievements extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rg:award-achievements';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Award achievement points';

    protected $awards = [
        'GreatPhotos',
        'CompleteProfile',
        'LotsOfPhotos',
        'PowerPromoter',
        'RentGorilla',
        'LotsOfFavourites',
        'CurrentListings',
        'MovieStar'
    ];

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		foreach($this->awards as $award) {
            $achievement = app()->make('RentGorilla\Rewards\\' . $award);
            $achievement->checkEligibility();
        }
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
