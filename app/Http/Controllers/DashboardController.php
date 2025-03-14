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
            'stats' => [
                'Organizations' => Auth::user()->account
                    ->organizations()->count(),
                'Contacts' => Auth::user()->account
                    ->contacts()->count(),
                'Leads' => Auth::user()->account
                    ->leads()->count(),
            ]
        ]);
    }
}
