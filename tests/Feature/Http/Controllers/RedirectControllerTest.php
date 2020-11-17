<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
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
    public function it_creates_a_redirect_for_every_redirect_request(): void
    {
        Carbon::setTestNow('1985-05-20 12:34:56');

        $link = Link::factory()->for(User::factory())->create();

        $this->assertCount(0, $link->redirects);

        $this->get(route('redirect', ['link' => $link->slug]), [
            'User-Agent' => 'Test user-agent; please ignore',
        ]);

        $this->assertCount(1, $link->refresh()->redirects);
        $this->assertDatabaseCount('redirects', 1);
        $this->assertDatabaseHas('redirects', [
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test user-agent; please ignore',
            'created_at' => '1985-05-20 12:34:56',
        ]);

        $this->get(route('redirect', ['link' => $link->slug]));
        $this->get(route('redirect', ['link' => $link->slug]));

        $this->assertCount(3, $link->refresh()->redirects);
        $this->assertDatabaseCount('redirects', 3);
    }
}
