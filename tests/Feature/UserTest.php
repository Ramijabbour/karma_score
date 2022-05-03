<?php

namespace Tests\Feature;

use App\Models\RankedUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api()
    {
        $response = $this->withoutExceptionHandling()->get('/api/v1/user/1/karma-position');
        $response->assertStatus(200);
    }
}
