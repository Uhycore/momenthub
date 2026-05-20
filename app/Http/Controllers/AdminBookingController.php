<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBookingController extends Controller
{
    // ── INDEX ──────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $status    = $request->query('status', 'all');
        $dateRange = $request->query('range', '10');

        $query = Booking::with(['user', 'package'])->latest('created_at');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($dateRange !== 'all') {
            $query->where('created_at', '>=', now()->subDays((int) $dateRange));
        }

        $bookings = $query->paginate(10)->withQueryString();

        $stats = [
            'total'      => Booking::count(),
            'pending'    => Booking::pending()->count(),
            'pendapatan' => Booking::whereIn('status', ['confirmed', 'completed', 'editing', 'done'])
                ->sum('total_price'),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats', 'status', 'dateRange'));
    }

    // ── UPDATE ─────────────────────────────────────────────────────────

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status'     => 'required|in:pending,confirmed,rejected,completed,editing,done',
            'notes'      => 'nullable|string|max:500',
            'drive_link' => 'nullable|url|max:500',
        ]);

        // Cek konflik hanya saat confirm
        if ($validated['status'] === 'confirmed') {
            $conflict = Booking::hasConflict(
                $booking->package_id,
                $booking->start_date->toDateString(),
                $booking->end_date->toDateString(),
                excludeId: $booking->id
            );

            if ($conflict) {
                return redirect()->route('admin.bookings.index')
                    ->with('error', 'Tidak bisa dikonfirmasi — tanggal bentrok dengan pesanan confirmed lain.');
            }
        }

        $booking->update([
            'status'     => $validated['status'],
            'notes'      => $validated['notes'] ?? $booking->notes,
            'drive_link' => $validated['drive_link'] ?? $booking->drive_link,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pesanan #ORD-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . ' berhasil diperbarui.');
    }

    // ── DESTROY ────────────────────────────────────────────────────────

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}
