<?php namespace RentGorilla\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
        'RentGorilla\Console\Commands\Inspire',
        'RentGorilla\Console\Commands\DeactivateRentals',
        'RentGorilla\Console\Commands\ProcessPromotionQueue',
		'RentGorilla\Console\Commands\AwardAchievements',
        'RentGorilla\Console\Commands\ClearPromotionsHistoryCommand',
        'RentGorilla\Console\Commands\PropertyReportCommand',
        'RentGorilla\Console\Commands\MigrateRAUsersCommand',
        'RentGorilla\Console\Commands\CreateNewUserCommand',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{

        $schedule->command('rg:property-report')
            ->monthly();

        $schedule->command('rg:clear-promotions-history')
            ->dailyAt('00:00');

        $schedule->command('rg:deactivate-rentals')
            ->dailyAt('00:01');

        $schedule->command('rg:process-promotion-queue')
            ->dailyAt('01:00');

        $schedule->command('rg:award-achievements')
            ->dailyAt('02:00');
	}

}
