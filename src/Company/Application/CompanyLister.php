<?php

namespace OptimaCultura\Company\Application;

use OptimaCultura\Company\Domain\CompanyRepositoryInterface;
use OptimaCultura\Shared\Domain\Interfaces\ServiceInterface;

class CompanyLister implements ServiceInterface
{
    /**
     * @var CompanyRepositoryInterface $repository
     */
    private CompanyRepositoryInterface $repository;

    /**
     * Create new instance
     */
    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List all companies
     */
    public function handle(): array
    {
        return $this->repository->findAll();
    }
}
