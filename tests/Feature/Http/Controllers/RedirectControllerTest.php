<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class RedirectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_redirects_a_link_to_a_url(): void
    {
        $link = Link::factory()->for(User::factory())->create([
            'url' => 'https://example.test/foo/bar',
        ]);

        $response = $this->get(route('redirect', ['link' => $link->slug]));

        $response
            ->assertStatus(Response::HTTP_MOVED_PERMANENTLY)
            ->assertRedirect('https://example.test/foo/bar');
    }

    /** @test */
    public function it_returns_a_not_found_response_for_an_invalid_link(): void
    {
        $response = $this->get(route('redirect', ['link' => '404']));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_increments_hits_for_every_request(): void
    {
        $link = Link::factory()->for(User::factory())->create([
            'url' => 'https://example.test/foo/bar',
        ]);

        $this->assertEquals(0, $link->hits);

        $this->get(route('redirect', ['link' => $link->slug]));
        $this->get(route('redirect', ['link' => $link->slug]));
        $this->get(route('redirect', ['link' => $link->slug]));

        $this->assertEquals(3, $link->refresh()->hits);

        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'hits' => 3,
        ]);
    }
}
