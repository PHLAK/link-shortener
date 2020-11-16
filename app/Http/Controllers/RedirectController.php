<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class RedirectController extends Controller
{
    /** Redirect a link to it's corresponding URL. */
    public function __invoke(Link $link): RedirectResponse
    {
        $link->incrementHits();

        return redirect($link->url, Response::HTTP_MOVED_PERMANENTLY);
    }
}
