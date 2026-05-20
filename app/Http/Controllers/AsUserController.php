<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AsUserController extends Controller
{
    public function index(): View
    {
        $uid = Auth::id();

        // ── Stats ──────────────────────────────────────────────────────
        $totalBookings  = Booking::where('user_id', $uid)->count();
        $totalDone      = Booking::where('user_id', $uid)->where('status', 'done')->count();
        $totalSpent     = Booking::where('user_id', $uid)
            ->whereIn('status', ['confirmed', 'completed', 'editing', 'done'])
            ->sum('total_price');
        $pendingCount   = Booking::where('user_id', $uid)->where('status', 'pending')->count();

        // ── Sesi mendatang (konfirmasi/pending terdekat) ───────────────
        $nextBooking = Booking::with('package')
            ->where('user_id', $uid)
            ->whereIn('status', ['confirmed', 'pending'])
            ->where('start_date', '>=', today())
            ->orderBy('start_date')
            ->first();

        // ── Galeri siap (done + ada drive_link) ───────────────────────
        $readyGallery = Booking::with('package')
            ->where('user_id', $uid)
            ->where('status', 'done')
            ->whereNotNull('drive_link')
            ->latest('updated_at')
            ->first();

        // ── Tabel status pemesanan (5 terbaru) ────────────────────────
        $recentBookings = Booking::with('package')
            ->where('user_id', $uid)
            ->latest('created_at')
            ->limit(5)
            ->get();

        // ── Kalender (pending + confirmed milik user ini) ─────────────
        $calendarEvents = Booking::with('package')
            // ->where('user_id', $uid)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(fn($b) => [
                'id'      => $b->id,
                'title'   => $b->package->name ?? 'Paket',
                'package' => $b->package->name ?? '-',
                'status'  => $b->status_label,
                'start'   => $b->start_date->toDateString(),
                'end'     => $b->end_date->copy()->addDay()->toDateString(),
                'color'   => match ($b->status) {
                    'confirmed' => '#1a6e38',
                    default     => '#b58900',
                },
            ])->values();

        return view('user.dashboard', compact(
            'totalBookings',
            'totalDone',
            'totalSpent',
            'pendingCount',
            'nextBooking',
            'readyGallery',
            'recentBookings',
            'calendarEvents'
        ));
    }
    
}
