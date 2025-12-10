<?php

namespace OptimaCultura\Company\Application;

use OptimaCultura\Company\Domain\Company;
use OptimaCultura\Company\Domain\CompanyRepositoryInterface;
use OptimaCultura\Company\Domain\ValueObject\CompanyId;
use OptimaCultura\Company\Domain\ValueObject\CompanyStatus;
use OptimaCultura\Shared\Domain\Interfaces\ServiceInterface;

class CompanyStatusUpdater implements ServiceInterface
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
     * Update company status
     */
    public function handle(string $id, string $statusName): void
    {
        $companyId = new CompanyId($id);

        // Find the company
        $company = $this->repository->findById($companyId);

        if (!$company) {
            throw new \Exception("Company not found with id: {$id}");
        }

        // Create new company instance with new status
        $updatedCompany = new Company(
            $company->id(),
            $company->name(),
            $company->email(),
            $company->address(),
            CompanyStatus::fromName($statusName)
        );

        // Update in repository
        $this->repository->update($updatedCompany);
    }
}
