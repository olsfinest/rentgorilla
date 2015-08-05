<?php namespace RentGorilla\Console\Commands;

use Illuminate\Console\Command;
use RentGorilla\User;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Log;

class CreateNewUserCommand extends Command {

    public $email;
    public $first_name;
    public $last_name;
    public $password;
    public $is_admin;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rg:create-user';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a new user';

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
        $this->prompt();
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

    private function validateInput()
    {
        if(empty($this->email)) {
            $this->error('Email cannot be empty');
            return $this->prompt();
        }

        if ( ! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email is invalid');
            $this->email = null;
            return $this->prompt();
        }


        if(User::where('email', $this->email)->first()) {
            $this->error('Email already exists in database');
            $this->email = null;
            return $this->prompt();
        }

        if(empty($this->first_name)) {
            $this->error('First name cannot be empty');
            return $this->prompt();
        }

        if(empty($this->last_name)) {
            $this->error('Last name cannot be empty');
            return $this->prompt();
        }

        if(empty($this->password)) {
            $this->error('Password cannot be empty');
            return $this->prompt();
        }

        if(empty($this->is_admin) || ( ! ($this->is_admin === 'y' || $this->is_admin === 'n'))) {
            $this->error('Is admin must be either y or n');
            $this->is_admin = null;
            return $this->prompt();
        }

        $this->saveUser();
    }

    private function prompt()
    {

        if( ! $this->email) {
            $this->email = $this->ask('Email address:');
        }

        if( ! $this->first_name) {
            $this->first_name = $this->ask('First name:');
        }

        if( ! $this->last_name) {
            $this->last_name = $this->ask('Last name:');
        }

        if( ! $this->password) {
            $this->password = $this->ask('Password:');
        }

       if( ! $this->is_admin) {
             $this->is_admin = $this->ask('Is this user an admin [y|n]:');
        }

        $this->validateInput();
    }

    private function saveUser()
    {
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->confirmed = 1;
        $user->confirmation = str_random(40);
        $user->is_admin = $this->is_admin === 'y' ? 1 : 0;
        $user->provider = 'email';
        $user->save();

        Log::info('New user created', ['id' => $user->id]);

        $this->info('New user created!');

    }

}
