<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DestroyLinkRequest;
use App\Http\Requests\Api\ShowLinkRequest;
use App\Http\Requests\Api\StoreLinkRequest;
use App\Http\Requests\Api\UpdateLinkRequest;
use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class LinkController extends ApiController
{
    /** Create a new LinkController. */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /** Display a listing of links. */
    public function index(ShowLinkRequest $request): Collection
    {
        return $request->user()->links;
    }

    /** Store a newly created link in storage. */
    public function store(StoreLinkRequest $request): Link
    {
        return $request->user()->links()->create($request->validated());
    }

    /** Display the specified link. */
    public function show(ShowLinkRequest $request, Link $link): Link
    {
        return $link;
    }

    /** Update the specified link in storage. */
    public function update(UpdateLinkRequest $request, Link $link): Link
    {
        $link->update($request->validated());

        return $link;
    }

    /** Remove the specified link from storage. */
    public function destroy(DestroyLinkRequest $request, Link $link): Response
    {
        $link->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
