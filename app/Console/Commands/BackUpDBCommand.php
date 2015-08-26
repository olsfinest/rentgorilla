<?php

namespace RentGorilla\Console\Commands;

use Illuminate\Console\Command;
use Log;

class BackUpDBCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rg:backup-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a db backup and saves to DropBox';


    public function fire() {

        Log::info('Running ' . $this->getName());

        $date = date('Y-m-d');

        $filename = $date . '.sql';

        $this->call('db:backup', ['--database' => 'mysql', '--destination' => 'dropbox', '--destinationPath' => $filename, '--compression' => 'gzip']);
    }
}
