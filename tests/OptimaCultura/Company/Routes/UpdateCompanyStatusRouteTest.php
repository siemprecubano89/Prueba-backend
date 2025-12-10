<?php

namespace Tests\OptimaCultura\Company\Routes;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCompanyStatusRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group route
     * @group access-interface
     * @test
     */
    #[Test]
    public function patchUpdateCompanyStatusToActive()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();

        // Create a company first
        $createResponse = $this->json('POST', '/api/company', [
            'name'    => $faker->company,
            'email'   => $faker->companyEmail,
            'address' => $faker->address,
        ]);

        $companyId = $createResponse->json('id');

        /**
         * Actions
         */
        $response = $this->json('PATCH', "/api/company/{$companyId}/status", [
            'status' => 'active',
        ]);

        /**
         * Asserts
         */
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Company status updated successfully'
            ]);

        // Verify the status was actually updated
        $this->assertDatabaseHas('companies', [
            'id' => $companyId,
            'status' => 1, // 1 = active
        ]);
    }

    /**
     * @group route
     * @group access-interface
     * @test
     */
    #[Test]
    public function patchUpdateCompanyStatusToInactive()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();

        // Create a company
        $createResponse = $this->json('POST', '/api/company', [
            'name'    => $faker->company,
            'email'   => $faker->companyEmail,
            'address' => $faker->address,
        ]);

        $companyId = $createResponse->json('id');

        /**
         * Actions - Update to active first, then to inactive
         */
        $this->json('PATCH', "/api/company/{$companyId}/status", [
            'status' => 'active',
        ]);

        $response = $this->json('PATCH', "/api/company/{$companyId}/status", [
            'status' => 'inactive',
        ]);

        /**
         * Asserts
         */
        $response->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'id' => $companyId,
            'status' => 2, // 2 = inactive
        ]);
    }

    /**
     * @group route
     * @group access-interface
     * @test
     */
    #[Test]
    public function patchUpdateNonExistentCompany()
    {
        /**
         * Actions
         */
        $response = $this->json('PATCH', '/api/company/00000000-0000-0000-0000-000000000000/status', [
            'status' => 'active',
        ]);

        /**
         * Asserts
         */
        $response->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Company not found with id: 00000000-0000-0000-0000-000000000000'
            ]);
    }

    /**
     * @group route
     * @group access-interface
     * @test
     */
    #[Test]
    public function patchUpdateWithInvalidStatus()
    {
        /**
         * Preparing
         */
        $faker = \Faker\Factory::create();

        $createResponse = $this->json('POST', '/api/company', [
            'name'    => $faker->company,
            'email'   => $faker->companyEmail,
            'address' => $faker->address,
        ]);

        $companyId = $createResponse->json('id');

        /**
         * Actions
         */
        $response = $this->json('PATCH', "/api/company/{$companyId}/status", [
            'status' => 'invalid-status',
        ]);

        /**
         * Asserts
         */
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }
}
