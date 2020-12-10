<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Create a new DashboardController. */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    /** Handle the incoming request. */
    public function __invoke(Request $request): View
    {
        return view('dashboard', [
            'links' => $request->user()->links()->simplePaginate(10),
        ]);
    }
}
