<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @coversNothing
 */
class IndexTest extends TestCase
{
    public function test_it_can_access_the_index()
    {
        $response = $this->get('/');

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('index');
    }
}
