<?php

namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\CreateAreaCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\AreasRepository;

class CreateAreaCommandHandler
{

    /**
     * @var AreasRepository
     */
    private $repository;

    public function __construct(AreasRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the command.
     *
     * @param  CreateAreaCommand  $command
     * @return void
     */
    public function handle(CreateAreaCommand $command)
    {
        $this->repository->create($command->name, $command->province);
    }
}
