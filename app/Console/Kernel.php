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
        'RentGorilla\Console\Commands\BackUpDBCommand',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{

        $schedule->command('rg:award-achievements')->dailyAt('00:00');

        $schedule->command('rg:clear-promotions-history')
            ->dailyAt('00:05');

        $schedule->command('rg:deactivate-rentals')
            ->dailyAt('00:10');

        $schedule->command('rg:process-promotion-queue')
            ->dailyAt('01:00');

        $schedule->command('auth:clear-resets')
            ->dailyAt('02:30');

        $schedule->command('rg:backup-db')
            ->dailyAt('03:00');

    }

}
