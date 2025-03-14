<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard/Index', [
            'organizations_count' => Auth::user()->account
                ->organizations()->count(),
            'contacts_count' => Auth::user()->account
                ->contacts()->count(),
            'leads_count' => Auth::user()->account
                ->leads()->count(),
        ]);
    }
}
