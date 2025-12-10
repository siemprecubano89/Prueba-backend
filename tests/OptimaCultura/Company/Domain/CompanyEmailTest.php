<?php

namespace Tests\OptimaCultura\Company\Domain;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use OptimaCultura\Company\Domain\ValueObject\CompanyEmail;

final class CompanyEmailTest extends TestCase
{
    /**
     * @group domain
     * @group company
     * @test
     */
    #[Test]
    public function createValidCompanyEmail()
    {
        /**
         * Actions
         */
        $email = new CompanyEmail('contact@example.com');

        /**
         * Assert
         */
        $this->assertEquals('contact@example.com', $email->get());
        $this->assertEquals('contact@example.com', (string) $email);
    }

    /**
     * @group domain
     * @group company
     * @test
     */
    #[Test]
    public function invalidCompanyEmail()
    {
        /**
         * Actions & Assert
         */
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email format');

        new CompanyEmail('invalid-email');
    }
}
