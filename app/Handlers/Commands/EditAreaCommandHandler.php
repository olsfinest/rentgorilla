<?php

namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\EditAreaCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\AreasRepository;

class EditAreaCommandHandler
{

    public $repository;

    public function __construct(AreasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the command.
     *
     * @param  EditAreaCommand  $command
     * @return void
     */
    public function handle(EditAreaCommand $command)
    {
        $this->repository->edit($command->id, $command->name, $command->province);
    }
}
