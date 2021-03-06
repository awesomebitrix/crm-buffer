<?php namespace App\Traits;

use App\Interfaces\Repositories\RequestRepository;

/**
 * Trait for that what uses request repository
 * @package App\Traits
 */
trait UseRequestRepository
{
    /**
     * @var RequestRepository
     */
    private $repository;

    /**
     * Set request repository
     *
     * @param RequestRepository $repository
     *
     * @return self
     */
    public function setRequestRepository(RequestRepository $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get request repository
     *
     * @return RequestRepository
     */
    public function getRequestRepository(): RequestRepository
    {
        return $this->repository;
    }
}