<?php

namespace Tests\OptimaCultura\Company\Routes;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewCompanyRouteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @group route
     * @group access-interface
     * @test
     */
    #[Test]
    public function postCreateNewCompanyRoute()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();
        $testCompany = [
            'name'    => $faker->company,
            'email'   => $faker->companyEmail,
            'address' => $faker->address,
            'status'  => 'inactive',
        ];

        /**
         * Actions
         */
        $response = $this->json('POST', '/api/company', [
            'name'    => $testCompany['name'],
            'email'   => $testCompany['email'],
            'address' => $testCompany['address'],
        ]);

        /**
         * Asserts
         */
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name'    => $testCompany['name'],
                'email'   => $testCompany['email'],
                'address' => $testCompany['address'],
                'status'  => 'inactive',
            ]);
    }
}
