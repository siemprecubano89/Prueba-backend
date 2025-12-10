<?php

namespace Tests\OptimaCultura\Company\Application;

use Tests\TestCase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use OptimaCultura\Company\Domain\Company;
use OptimaCultura\Company\Domain\ValueObject\CompanyId;
use OptimaCultura\Company\Domain\ValueObject\CompanyName;
use OptimaCultura\Company\Domain\ValueObject\CompanyEmail;
use OptimaCultura\Company\Domain\ValueObject\CompanyAddress;
use OptimaCultura\Company\Domain\ValueObject\CompanyStatus;
use OptimaCultura\Company\Application\CompanyLister;
use Tests\OptimaCultura\Company\Infrastructure\CompanyRepositoryFake;

final class ListCompaniesTest extends TestCase
{
    /**
     * @group application
     * @group company
     * @test
     */
    #[Test]
    public function listAllCompanies()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();
        $repository = new CompanyRepositoryFake();

        // Create some companies in the repository
        $company1 = new Company(
            new CompanyId(Str::uuid()),
            new CompanyName($faker->company),
            new CompanyEmail($faker->companyEmail),
            new CompanyAddress($faker->address),
            CompanyStatus::disabled()
        );

        $company2 = new Company(
            new CompanyId(Str::uuid()),
            new CompanyName($faker->company),
            new CompanyEmail($faker->companyEmail),
            new CompanyAddress($faker->address),
            CompanyStatus::enabled()
        );

        $repository->create($company1);
        $repository->create($company2);

        /**
         * Actions
         */
        $lister = new CompanyLister($repository);
        $companies = $lister->handle();

        /**
         * Assert
         */
        $this->assertIsArray($companies);
        $this->assertCount(2, $companies);
        $this->assertInstanceOf(Company::class, $companies[0]);
        $this->assertInstanceOf(Company::class, $companies[1]);
    }

    /**
     * @group application
     * @group company
     * @test
     */
    #[Test]
    public function listEmptyCompanies()
    {
        /**
         * Preparing
         */
        $repository = new CompanyRepositoryFake();

        /**
         * Actions
         */
        $lister = new CompanyLister($repository);
        $companies = $lister->handle();

        /**
         * Assert
         */
        $this->assertIsArray($companies);
        $this->assertCount(0, $companies);
    }
}
