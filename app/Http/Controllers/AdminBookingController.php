<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBookingController extends Controller
{
    // ── HELPER ────────────────────────────────────────────────────────

    private function calcBilledHours(string $start, string $end): int
    {
        $minutes = Carbon::parse($start)->diffInMinutes(Carbon::parse($end));
        return (int) ceil($minutes / 60);
    }

    // ── INDEX ──────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $status    = $request->query('status', 'all');
        $dateRange = $request->query('range', '30');

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
            'confirmed'  => Booking::confirmed()->count(),
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
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'notes'      => 'nullable|string|max:500',
            'drive_link' => 'nullable|url|max:500',
        ]);

        // Cek konflik tanggal jika status confirmed atau tanggal berubah
        $oldStart = $booking->start_date->format('Y-m-d H:i:s');
        $oldEnd   = $booking->end_date->format('Y-m-d H:i:s');

        $dateChanged = $validated['start_date'] !== $oldStart
            || $validated['end_date']   !== $oldEnd;

        if ($validated['status'] === 'confirmed' || $dateChanged) {
            $conflict = Booking::where('package_id', $booking->package_id)
                ->whereNot('status', 'rejected')
                ->where('id', '!=', $booking->id)
                ->where('start_date', '<=', $validated['end_date'])
                ->where('end_date', '>=', $validated['start_date'])
                ->exists();

            if ($conflict) {
                return redirect()->route('admin.bookings.index')
                    ->with('error', 'Tidak bisa disimpan — waktu bentrok dengan pesanan lain.');
            }
        }

        // Recalculate total jika tanggal berubah
        $updateData = [
            'status'     => $validated['status'],
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'notes'      => $validated['notes'] ?? $booking->notes,
            'drive_link' => array_key_exists('drive_link', $validated)
                ? $validated['drive_link']
                : $booking->drive_link,
        ];

        if ($dateChanged) {
            $billedHours             = $this->calcBilledHours($validated['start_date'], $validated['end_date']);
            $updateData['total_price'] = $billedHours * $booking->package->price;
        }

        $booking->update($updateData);

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
