<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    // ── INDEX ──────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $filter = $request->query('filter', 'all'); // all | active | inactive

        $query = Package::orderBy('sort_order')->orderBy('price');

        $query = match ($filter) {
            'active'   => $query->active(),
            'inactive' => $query->inactive(),
            default    => $query,
        };

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $packages = $query->paginate(10)->withQueryString();

        $stats = [
            'total'    => Package::count(),
            'active'   => Package::active()->count(),
            'inactive' => Package::inactive()->count(),
        ];

        return view('admin.price.index', compact('packages', 'stats', 'filter'));
    }

    // ── STORE ──────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'price'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'duration'    => 'required|integer|min:1|max:24',
            'photo_count' => 'required|integer|min:1',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? Package::max('sort_order') + 1;

        Package::create($validated);

        return redirect()->route('admin.price.index')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    // ── UPDATE ─────────────────────────────────────────────────────────

    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'price'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'duration'    => 'required|integer|min:1|max:24',
            'photo_count' => 'required|integer|min:1',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $package->update($validated);

        return redirect()->route('admin.price.index')
            ->with('success', 'Paket berhasil diperbarui.');
    }

    // ── TOGGLE AKTIF ───────────────────────────────────────────────────

    public function toggle(Package $package): RedirectResponse
    {
        $package->update(['is_active' => !$package->is_active]);

        return back()->with('success', 'Status paket diperbarui.');
    }

    // ── DESTROY ────────────────────────────────────────────────────────

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('admin.price.index')
            ->with('success', 'Paket berhasil dihapus.');
    }
}
