<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    // ─── INDEX — List all clients ────────────────────────────────────────────

    /**
     * Show the client list with optional search and industry filter.
     * URL: GET /clients
     */
    public function index(Request $request)
    {
        // Start building the query
        $query = Client::withCount([
            'socialAccounts',   // adds social_accounts_count column
            'posts',            // adds posts_count column
        ]);

        // --- Search by name ---
        // If the user typed something in the search box, filter by it.
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // --- Filter by industry ---
        if ($request->filled('industry')) {
            $query->where('industry', $request->industry);
        }

        // Get results, 12 per page (paginated)
        // ->latest() orders by created_at DESC (newest first)
        $clients = $query->latest()->paginate(12)->withQueryString();
        //                                         ↑ keeps search/filter in pagination links

        return view('clients.index', [
            'clients'    => $clients,
            'industries' => Client::industries(),
            'search'     => $request->search,
            'industry'   => $request->industry,
        ]);
    }

    // ─── CREATE — Show the "Add Client" form ─────────────────────────────────

    /**
     * URL: GET /clients/create
     */
    public function create()
    {
        return view('clients.create', [
            'industries' => Client::industries(),
        ]);
    }

    // ─── STORE — Save new client to DB ───────────────────────────────────────

    /**
     * URL: POST /clients
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming form data
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'industry' => 'nullable|string|max:100',
            'notes'    => 'nullable|string',
            // Logo is optional; if provided must be an image ≤ 2MB
            'logo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2. Handle logo upload
        if ($request->hasFile('logo')) {
            // store() saves the file in storage/app/public/logos/
            // and returns the relative path e.g. "logos/abc123.jpg"
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // 3. Create the client record
        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client "' . $validated['name'] . '" added successfully!');
    }

    // ─── SHOW — Single client profile page ───────────────────────────────────

    /**
     * URL: GET /clients/{client}
     * Shows the client profile with tabs: Analytics / Posts / Inbox / Reports
     */
    public function show(Client $client)
    {
        // Eager-load related data for the profile tabs
        $client->load([
            'socialAccounts',
            'posts'          => fn($q) => $q->latest()->limit(5),
            'reports'        => fn($q) => $q->latest()->limit(5),
        ]);

        // Count stats for the header cards
        $stats = [
            'social_accounts' => $client->socialAccounts->count(),
            'total_posts'     => $client->posts()->count(),
            'scheduled_posts' => $client->posts()->where('status', 'scheduled')->count(),
            'reports'         => $client->reports()->count(),
        ];

        return view('clients.show', compact('client', 'stats'));
    }

    // ─── EDIT — Show the edit form ────────────────────────────────────────────

    /**
     * URL: GET /clients/{client}/edit
     */
    public function edit(Client $client)
    {
        return view('clients.edit', [
            'client'     => $client,
            'industries' => Client::industries(),
        ]);
    }

    // ─── UPDATE — Save changes to existing client ─────────────────────────────

    /**
     * URL: PUT /clients/{client}
     */
    public function update(Request $request, Client $client)
    {
        // 1. Validate
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'industry' => 'nullable|string|max:100',
            'notes'    => 'nullable|string',
            'logo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2. Handle new logo upload
        if ($request->hasFile('logo')) {
            // Delete the OLD logo from storage so we don't fill the disk
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }
            // Store the new one
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // 3. Handle "Remove logo" checkbox
        // If user checked "remove logo" and there's no new upload, clear it
        if ($request->boolean('remove_logo') && !$request->hasFile('logo')) {
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }
            $validated['logo'] = null;
        }

        // 4. Update record
        $client->update($validated);

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client updated successfully!');
    }

    // ─── DESTROY — Delete a client ────────────────────────────────────────────

    /**
     * URL: DELETE /clients/{client}
     */
    public function destroy(Client $client)
    {
        $name = $client->name;

        // Delete the logo file from storage if it exists
        if ($client->logo) {
            Storage::disk('public')->delete($client->logo);
        }

        // Delete the database record
        // Note: If you have foreign key constraints, delete related records first
        // or use onDelete('cascade') in migrations.
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client "' . $name . '" has been deleted.');
    }
}