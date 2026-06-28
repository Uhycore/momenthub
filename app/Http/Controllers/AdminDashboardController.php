<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $now       = Carbon::now();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // ── Pendapatan ────────────────────────────────────────────────
        // Total pendapatan dari booking yang done/completed/confirmed
        $pendapatan = Booking::whereIn('status', ['done', 'completed', 'confirmed'])
            ->sum('total_price');

        // Pendapatan bulan ini vs bulan lalu untuk persentase naik/turun
        $pendapatanBulanIni = Booking::whereIn('status', ['done', 'completed', 'confirmed'])
            ->where('created_at', '>=', $thisMonth)
            ->sum('total_price');

        $pendapatanBulanLalu = Booking::whereIn('status', ['done', 'completed', 'confirmed'])
            ->whereBetween('created_at', [$lastMonth, $lastMonthEnd])
            ->sum('total_price');

        $pendapatanPct = $pendapatanBulanLalu > 0
            ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : null;

        // ── Pemesanan ─────────────────────────────────────────────────
        $pemesananAktif = Booking::whereIn('status', ['pending', 'confirmed', 'editing', 'completed'])->count();
        $pemesananBaru  = Booking::where('status', 'pending')
            ->where('created_at', '>=', $now->copy()->subDays(7))
            ->count();

        // ── Postingan ─────────────────────────────────────────────────
        $totalPostingan = Post::count();

        // ── Tabel pemesanan terbaru (5 terakhir) ──────────────────────
        $pemesananTerbaru = Booking::with(['user', 'package'])
            ->latest()
            ->take(5)
            ->get();

        // ── Postingan terbaru (5 terakhir) ───────────────────────────
        $postinganTerbaru = Post::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'pendapatan',
            'pendapatanPct',
            'pemesananAktif',
            'pemesananBaru',
            'totalPostingan',
            'pemesananTerbaru',
            'postinganTerbaru',
        ));
    }
}
