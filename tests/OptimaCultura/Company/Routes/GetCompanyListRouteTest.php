<?php

namespace Tests\OptimaCultura\Company\Routes;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCompanyListRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group route
     * @group access-interface
     * @test
     */
    #[Test]
    public function getCompanyListRoute()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();

        // Create some companies first
        $this->json('POST', '/api/company', [
            'name'    => $faker->company,
            'email'   => $faker->companyEmail,
            'address' => $faker->address,
        ]);

        $this->json('POST', '/api/company', [
            'name'    => $faker->company,
            'email'   => $faker->companyEmail,
            'address' => $faker->address,
        ]);

        /**
         * Actions
         */
        $response = $this->json('GET', '/api/companies');

        /**
         * Asserts
         */
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'address',
                        'status',
                    ]
                ],
                'total'
            ])
            ->assertJsonPath('total', 2);
    }

    /**
     * @group route
     * @group access-interface
     * @test
     */
    #[Test]
    public function getEmptyCompanyList()
    {
        /**
         * Actions
         */
        $response = $this->json('GET', '/api/companies');

        /**
         * Asserts
         */
        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'total' => 0
            ]);
    }
}
