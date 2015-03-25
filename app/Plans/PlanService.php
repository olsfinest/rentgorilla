<?php namespace RentGorilla\Plans;

use RentGorilla\Repositories\PlanRepository;

class PlanService {

    protected $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetchAllPlans()
    {
        return $this->repository->fetchAllPlans();
    }

    public function fetchPlanById($planId)
    {
        return $this->repository->fetchPlanById($planId);
    }

    public function fetchPlansByOwner($owner)
    {
        return $this->repository->fetchPlansByOwner($owner);
    }

    public function fetchPlansByInterval($interval)
    {
        return $this->repository->fetchPlansByInterval($interval);
    }

    public function fetchPlansByOwnerAndInterval($owner, $interval)
    {
        return $this->repository->fetchPlansByOwnerAndInterval($owner, $interval);
    }

    public function plan($planId)
    {
        return $this->fetchPlanById($planId);
    }

}