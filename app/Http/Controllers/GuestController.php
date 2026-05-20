<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GuestController extends Controller
{

    public function index(): View
    {
        $featuredPosts = Post::latest('published_at')->limit(4)->get();

        $packages = Package::active()
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();

        // ── Semua booking (bukan filter per user) untuk kalender publik ──
        $calendarEvents = Booking::with(['user', 'package'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(fn($b) => [
                'id'      => $b->id,
                // Nama pemesan tampil di bar event
                'title'   => $b->user->name ?? 'Unknown',
                'package' => $b->package->name ?? '-',
                'status'  => $b->status_label,
                'start'   => $b->start_date->toDateString(),
                // FullCalendar end exclusive → +1 hari
                'end'     => $b->end_date->copy()->addDay()->toDateString(),
                'color'   => match ($b->status) {
                    'confirmed' => '#1a6e38',
                    default     => '#b58900',
                },
                'textColor' => '#fff',
            ])
            ->values();

        return view('dashboard', compact('featuredPosts', 'packages', 'calendarEvents'));
    }

    public function gallery(Request $request): View
    {
        $filter = $request->query('filter', 'all');

        $posts = Post::when($filter !== 'all', fn($q) => $q->where('type', $filter))
            ->latest('published_at')
            ->get();

        return view('gallery', compact('posts', 'filter'));
    }

    public function price(): View
    {
        $packages = Package::active()
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();

        return view('price', compact('packages'));
    }
}
