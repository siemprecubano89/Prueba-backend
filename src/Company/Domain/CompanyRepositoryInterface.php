<?php

namespace OptimaCultura\Company\Domain;

use OptimaCultura\Company\Domain\ValueObject\CompanyId;

interface CompanyRepositoryInterface
{
    /**
     * Persist a new company instance
     */
    public function create(Company $company): void;

    /**
     * List all companies
     */
    public function findAll(): array;

    /**
     * Find company by id
     */
    public function findById(CompanyId $id): ?Company;

    /**
     * Update company
     */
    public function update(Company $company): void;
}
