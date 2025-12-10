<?php

namespace Tests\OptimaCultura\Company\Infrastructure;

use OptimaCultura\Company\Domain\Company;
use OptimaCultura\Company\Domain\CompanyRepositoryInterface;
use OptimaCultura\Company\Domain\ValueObject\CompanyId;

class CompanyRepositoryFake implements CompanyRepositoryInterface
{
    public bool $callMethodCreate = false;
    public bool $callMethodFindAll = false;
    public bool $callMethodFindById = false;
    public bool $callMethodUpdate = false;

    private array $companies = [];

    /**
     * @inheritdoc
     */
    public function create(Company $company): void
    {
        $this->callMethodCreate = true;
        $this->companies[$company->id()->get()] = $company;
    }

    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        $this->callMethodFindAll = true;
        return array_values($this->companies);
    }

    /**
     * @inheritdoc
     */
    public function findById(CompanyId $id): ?Company
    {
        $this->callMethodFindById = true;
        return $this->companies[$id->get()] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function update(Company $company): void
    {
        $this->callMethodUpdate = true;
        $this->companies[$company->id()->get()] = $company;
    }
}
