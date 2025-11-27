<?php
//
//
//use App\Models\Account;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Tests\TestCase;
//use Mockery;
//
//class AccountApiTest extends TestCase
//{
//    use RefreshDatabase;
//    /**
//     * A basic feature test example.
//     */
//
//    public function tearDown(): void
//    {
//        Mockery::close();
//        parent::tearDown();
//    }
//
//    public function test_get_list_of_accounts(): void
//    {
//        Account::factory()->count(3)->create();
//        $response = $this->get('/api/accounts');
//        $response->assertStatus(200)->assertJsonStructure([
//            '*' => ['id', 'name', 'amount']
//        ])->assertJsonCount(3);
//
//
//        $response->assertStatus(200);
//    }
//}
