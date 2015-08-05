<?php namespace RentGorilla\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use RentGorilla\User;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Log;
use DB;

class MigrateRAUsersCommand extends Command {

    private $starttime;
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rg:migrate-ra-users';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pulls RentAntigonish.ca users live from the web.';

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
        $this->startTimer();

		$users = file('http://rentantigonish.ca/getusers.php?key=LvCAh5ptd9CJk3D2');

        $userCount = count($users);

        $inserts = [];

        for ($i = 0; $i < $userCount; $i++) {

            $temp = explode("\t", $users[$i]);

            $inserts[] = [
                'email' => $temp[0],
                'first_name' => $temp[1],
                'last_name' => $temp[2],
                'trial_ends_at' => $this->getTrialEndsAt(trim($temp[3])),
                'password' => bcrypt(str_random(10)),
                'confirmed' => 1,
                'confirmation' => str_random(40),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('users')->insert($inserts);

        $message = $userCount . ' users have been live imported from RentAntigonish.ca!';

        Log::info($message);

        $this->info("\n");
        $this->info($message);
        $this->info("(" . $this->getTimer() . " seconds)");
        $this->info("\n");
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
//            ['key', InputArgument::REQUIRED, 'The key for RentAntigonish getusers.php'],
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

    private function startTimer()
    {
        $mtime = microtime();
        $mtime = explode(" ", $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $this->starttime = $mtime;
    }

    private function getTimer()
    {
        $mtime = microtime();
        $mtime = explode(" ",$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = ($endtime - $this->starttime);
        return $totaltime;
    }

    private function getTrialEndsAt($trial)
    {
        return $trial ?: null;
    }

}
