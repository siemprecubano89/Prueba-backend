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
use OptimaCultura\Company\Application\CompanyStatusUpdater;
use Tests\OptimaCultura\Company\Infrastructure\CompanyRepositoryFake;

final class UpdateCompanyStatusTest extends TestCase
{
    /**
     * @group application
     * @group company
     * @test
     */
    #[Test]
    public function updateCompanyStatusToActive()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();
        $repository = new CompanyRepositoryFake();
        $companyId = Str::uuid();

        // Create a company with inactive status
        $company = new Company(
            new CompanyId($companyId),
            new CompanyName($faker->company),
            new CompanyEmail($faker->companyEmail),
            new CompanyAddress($faker->address),
            CompanyStatus::disabled()
        );

        $repository->create($company);

        /**
         * Actions
         */
        $updater = new CompanyStatusUpdater($repository);
        $updater->handle($companyId, 'active');

        /**
         * Assert
         */
        $updatedCompany = $repository->findById(new CompanyId($companyId));
        $this->assertNotNull($updatedCompany);
        $this->assertEquals('active', $updatedCompany->status()->name());
        $this->assertEquals(1, $updatedCompany->status()->code());
    }

    /**
     * @group application
     * @group company
     * @test
     */
    #[Test]
    public function updateCompanyStatusToInactive()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();
        $repository = new CompanyRepositoryFake();
        $companyId = Str::uuid();

        // Create a company with active status
        $company = new Company(
            new CompanyId($companyId),
            new CompanyName($faker->company),
            new CompanyEmail($faker->companyEmail),
            new CompanyAddress($faker->address),
            CompanyStatus::enabled()
        );

        $repository->create($company);

        /**
         * Actions
         */
        $updater = new CompanyStatusUpdater($repository);
        $updater->handle($companyId, 'inactive');

        /**
         * Assert
         */
        $updatedCompany = $repository->findById(new CompanyId($companyId));
        $this->assertNotNull($updatedCompany);
        $this->assertEquals('inactive', $updatedCompany->status()->name());
        $this->assertEquals(2, $updatedCompany->status()->code());
    }

    /**
     * @group application
     * @group company
     * @test
     */
    #[Test]
    public function updateNonExistentCompany()
    {
        /**
         * Preparing
         */
        $repository = new CompanyRepositoryFake();
        $nonExistentId = Str::uuid();

        /**
         * Actions & Assert
         */
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Company not found with id: {$nonExistentId}");

        $updater = new CompanyStatusUpdater($repository);
        $updater->handle($nonExistentId, 'active');
    }
}
