<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/** @covers \App\Http\Controllers\Api\LinkController */
class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_links_for_a_user(): void
    {
        $user = User::factory()->has(Link::factory()->count(3))->create();
        User::factory()->has(Link::factory()->count(2))->create();

        Sanctum::actingAs($user, ['read']);

        $response = $this->json('GET', route('link.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3)
            ->assertJsonStructure([['id', 'slug', 'title', 'url']]);
    }

    /** @test */
    public function it_can_fetch_an_individual_link(): void
    {
        $link = Link::factory()->for(User::factory())->create([
            'slug' => 'test-slug-please-ignore',
            'title' => 'Test link; please ignore',
            'url' => 'https://example.test/foo/bar',
        ]);

        Sanctum::actingAs($link->user, ['read']);

        $response = $this->json('GET', route('link.show', ['link' => $link]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $link->id,
                'slug' => 'test-slug-please-ignore',
                'title' => 'Test link; please ignore',
                'url' => 'https://example.test/foo/bar',
                'user_id' => $link->user->id,
            ]);
    }

    /** @test */
    public function it_can_create_a_new_link(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['create']);

        $response = $this->json('POST', route('link.store'), [
            'slug' => 'test-slug-please-ignore',
            'title' => 'Test link; please ignore',
            'url' => 'https://example.test/foo/bar',
        ]);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'slug' => 'test-slug-please-ignore',
                'title' => 'Test link; please ignore',
                'url' => 'https://example.test/foo/bar',
                'user_id' => $user->id,
            ]);
    }

    /** @test */
    public function it_can_update_a_link(): void
    {
        $link = Link::factory()->for(User::factory())->create([
            'url' => 'https://example.test/foo/bar',
        ]);

        Sanctum::actingAs($link->user, ['update']);

        $response = $this->json('PATCH', route('link.update', ['link' => $link]), [
            'slug' => 'another-slug-please-ignore',
            'title' => 'Test link; please ignore',
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'slug' => 'another-slug-please-ignore',
                'title' => 'Test link; please ignore',
                'url' => 'https://example.test/foo/bar',
                'user_id' => $link->user->id,
            ]);
    }

    /** @test */
    public function it_can_delete_a_link(): void
    {
        $link = Link::factory()->for(User::factory())->create([
            'slug' => 'test-slug-please-ignore',
            'title' => 'Test link; please ignore',
            'url' => 'https://example.test/foo/bar',
        ]);

        Sanctum::actingAs($link->user, ['delete']);

        $response = $this->json('DELETE', route('link.destroy', ['link' => $link]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted($link);
    }

    /** @test */
    public function it_cannot_fetch_a_link_that_belongs_to_another_user(): void
    {
        $link = Link::factory()->for(User::factory())->create();

        $user = User::factory()->create();
        $token = $user->createToken('Test token; please ignore', ['*']);

        $response = $this->json('GET', route('link.show', ['link' => $link]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function a_user_can_not_update_a_link_that_belongs_to_another_user(): void
    {
        $link = Link::factory()->for(User::factory())->create([
            'slug' => 'test-slug-please-ignore',
            'title' => 'Test link; please ignore',
            'url' => 'https://example.test/foo/bar',
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('Test token; please ignore', ['*']);

        $response = $this->json('PATCH', route('link.update', ['link' => $link]), [
            'slug' => 'another-slug-please-ignore',
            'title' => 'Test link; please ignore',
        ], ['Bearer' => $token->plainTextToken]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertDatabaseHas('links', [
            'slug' => 'test-slug-please-ignore',
            'title' => 'Test link; please ignore',
        ]);
    }

    /** @test */
    public function a_user_can_not_delete_a_link_that_belongs_to_another_user(): void
    {
        $link = Link::factory()->for(User::factory())->create([
            'slug' => 'test-slug-please-ignore',
            'title' => 'Test link; please ignore',
            'url' => 'https://example.test/foo/bar',
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('Test token; please ignore', ['*']);

        $response = $this->json('DELETE', route('link.update', ['link' => $link]), [], [
            'Bearer' => $token->plainTextToken,
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertDatabaseHas('links', [
            'slug' => 'test-slug-please-ignore',
            'title' => 'Test link; please ignore',
        ]);
    }
}
