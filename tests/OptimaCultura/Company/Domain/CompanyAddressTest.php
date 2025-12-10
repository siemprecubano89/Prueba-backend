<?php

namespace Tests\OptimaCultura\Company\Domain;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use OptimaCultura\Company\Domain\ValueObject\CompanyAddress;

final class CompanyAddressTest extends TestCase
{
    /**
     * @group domain
     * @group company
     * @test
     */
    #[Test]
    public function createValidCompanyAddress()
    {
        /**
         * Actions
         */
        $address = new CompanyAddress('123 Main St, City, Country');

        /**
         * Assert
         */
        $this->assertEquals('123 Main St, City, Country', $address->get());
        $this->assertEquals('123 Main St, City, Country', (string) $address);
    }

    /**
     * @group domain
     * @group company
     * @test
     */
    #[Test]
    public function emptyCompanyAddress()
    {
        /**
         * Actions & Assert
         */
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Address cannot be empty');

        new CompanyAddress('');
    }

    /**
     * @group domain
     * @group company
     * @test
     */
    #[Test]
    public function tooLongCompanyAddress()
    {
        /**
         * Actions & Assert
         */
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Address is too long');

        $longAddress = str_repeat('a', 501);
        new CompanyAddress($longAddress);
    }
}
