<?php

namespace OptimaCultura\Company\Infrastructure;

use App\Models\Company as ModelsCompany;
use OptimaCultura\Company\Domain\ValueObject\CompanyAddress;
use OptimaCultura\Company\Domain\ValueObject\CompanyEmail;
use OptimaCultura\Company\Domain\ValueObject\CompanyId;
use OptimaCultura\Company\Domain\ValueObject\CompanyName;
use OptimaCultura\Company\Domain\ValueObject\CompanyStatus;
use OptimaCultura\Company\Domain\Company;
use OptimaCultura\Company\Domain\CompanyRepositoryInterface;

class CompanyRepositoryEloquent implements CompanyRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(Company $company): void
    {
        ModelsCompany::Create([
            'id' => $company->id(),
            'name' => $company->name(),
            'email' => $company->email(),
            'address' => $company->address(),
            'status' => $company->status()->code(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $eloquentCompanies = ModelsCompany::all();

        return $eloquentCompanies->map(function ($eloquentCompany) {
            return new Company(
                new CompanyId($eloquentCompany->id),
                new CompanyName($eloquentCompany->name),
                new CompanyEmail($eloquentCompany->email),
                new CompanyAddress($eloquentCompany->address),
                CompanyStatus::create($eloquentCompany->status)
            );
        })->toArray();
    }

    /**
     * @inheritDoc
     */
    public function findById(CompanyId $id): ?Company
    {
        $eloquentCompany = ModelsCompany::find($id->get());

        if (!$eloquentCompany) {
            return null;
        }

        return new Company(
            new CompanyId($eloquentCompany->id),
            new CompanyName($eloquentCompany->name),
            new CompanyEmail($eloquentCompany->email),
            new CompanyAddress($eloquentCompany->address),
            CompanyStatus::create($eloquentCompany->status)
        );
    }

    /**
     * @inheritDoc
     */
    public function update(Company $company): void
    {
        ModelsCompany::where('id', $company->id()->get())
            ->update([
                'name'    => $company->name()->get(),
                'email'   => $company->email()->get(),
                'address' => $company->address()->get(),
                'status'  => $company->status()->code(),
            ]);
    }
}
