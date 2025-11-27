<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

class AccountApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_list_of_accounts(): void
    {
        $response = $this->get('/api/accounts');
        $response->assertStatus(200)->assertJsonStructure([
            '*' => ['id', 'name', 'amount']
        ]);


        $response->assertStatus(200);
    }
}
