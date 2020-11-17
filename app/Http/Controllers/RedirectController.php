<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RedirectController extends Controller
{
    /** Redirect a link to it's corresponding URL. */
    public function __invoke(Request $request, Link $link): RedirectResponse
    {
        $link->redirects()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect($link->url, Response::HTTP_MOVED_PERMANENTLY);
    }
}
