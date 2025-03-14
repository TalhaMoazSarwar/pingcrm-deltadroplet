<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LeadsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Leads/Index', [
            'filters' => Request::all('search', 'trashed'),
            'leads' => Auth::user()->account->leads()
                ->orderBy('created_at')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($lead) => [
                    'id' => $lead->id,
                    'title' => $lead->title,
                    'organization' => $lead->organization->only('name'),
                    'contact' => $lead->contact->only('first_name'),
                    'status' => str($lead->status)->headline(),
                    'deleted_at' => $lead->deleted_at,
                ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Leads/Create', [
            'organizations' => Auth::user()->account
                ->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'contacts' => Auth::user()->account
                ->contacts()
                ->orderBy('first_name')
                ->get()
                ->map
                ->only('id', 'first_name'),
        ]);
    }

    public function store(): RedirectResponse
    {
        Auth::user()->account->leads()->create(
            Request::validate([
                'title' => ['required', 'string'],
                'organization_id' => ['required', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'contact_id' => ['required', Rule::exists('contacts', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'status' => ['required', 'string', 'in:new,contacted'],
            ])
        );

        return Redirect::route('leads')->with('success', 'Lead created.');
    }

    public function edit(Lead $lead): Response
    {
        return Inertia::render('Leads/Edit', [
            'lead' => [
                'id' => $lead->id,
                'title' => $lead->title,
                'organization_id' => $lead->organization_id,
                'contact_id' => $lead->contact_id,
                'status' => $lead->status,
                'deleted_at' => $lead->deleted_at,
            ],
            'organizations' => Auth::user()->account
                ->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'contacts' => Auth::user()->account
                ->contacts()
                ->orderBy('first_name')
                ->get()
                ->map
                ->only('id', 'first_name'),
        ]);
    }

    public function update(Lead $lead): RedirectResponse
    {
        $lead->update(
            Request::validate([
                'title' => ['required', 'string'],
                'organization_id' => ['required', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'contact_id' => ['required', Rule::exists('contacts', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'status' => ['required', 'string', 'in:new,contacted'],
            ])
        );

        return Redirect::back()->with('success', 'Lead updated.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return Redirect::back()->with('success', 'Lead deleted.');
    }

    public function restore(Lead $lead): RedirectResponse
    {
        $lead->restore();

        return Redirect::back()->with('success', 'Lead restored.');
    }
}
