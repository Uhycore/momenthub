<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookingController extends Controller
{
    // ── CHECK AVAILABILITY (AJAX) ─────────────────────────────────────

    public function checkAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'booking_id' => 'nullable|integer',
        ]);


        $conflict = Booking::hasConflict(
            $validated['package_id'],
            $validated['start_date'],
            $validated['end_date'],
            excludeId: $request->booking_id ?? null
        );

        if ($conflict) {
            return response()->json([
                'available' => false,
                'message'   => 'Tanggal tersebut sudah terbooking. Silakan pilih tanggal lain.',
            ]);
        }

        $package = Package::findOrFail($validated['package_id']);

        return response()->json([
            'available' => true,
            'message'   => 'Tanggal tersedia! Silakan lengkapi form dan konfirmasi pesanan.',
            'package'   => [
                'name'            => $package->name,
                'formatted_price' => $package->formatted_price,
            ],
        ]);
    }

    // ── STORE ─────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'package_id'    => 'required|exists:packages,id',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'notes'         => 'nullable|string|max:500',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        // Double-check availability di server
        if (Booking::hasConflict($validated['package_id'], $validated['start_date'], $validated['end_date'])) {
            return back()
                ->withInput()
                ->with('error', 'Tanggal sudah tidak tersedia. Silakan pilih tanggal lain.');
        }

        $package = Package::findOrFail($validated['package_id']);

        // Upload bukti pembayaran jika ada
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')
                ->store('bookings/payment-proofs', 'public');
        }

        Booking::create([
            'user_id'       => Auth::id(),
            'package_id'    => $validated['package_id'],
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
            'notes'         => $validated['notes'] ?? null,
            'payment_proof' => $paymentProofPath,
            'status'        => 'pending',
            'total_price'   => $package->price,
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Pesanan berhasil dikirim! Tim kami akan mengonfirmasi segera.');
    }

    public function userIndex(Request $request): View
    {
        $filter = $request->query('filter', 'all');

        $query = Booking::with('package')
            ->where('user_id', Auth::id())
            ->latest('created_at');

        $query = match ($filter) {
            'diproses'   => $query->whereIn('status', ['confirmed', 'editing', 'completed']),
            'selesai'    => $query->where('status', 'done'),
            'dibatalkan' => $query->where('status', 'rejected'),
            default      => $query,
        };

        $bookings = $query->paginate(10)->withQueryString();

        return view('user.booking', compact('bookings', 'filter'));
    }

    public function userUpdate(Request $request, Booking $booking): RedirectResponse
    {
        // Pastikan hanya milik user sendiri
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless(in_array($booking->status, ['pending', 'confirmed']), 403);

        $validated = $request->validate([
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'notes'         => 'nullable|string|max:500',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        // Cek konflik — exclude diri sendiri
        if (
            $validated['start_date'] !== $booking->start_date->toDateString() ||
            $validated['end_date']   !== $booking->end_date->toDateString()
        ) {
            if (Booking::hasConflict(
                $booking->package_id,
                $validated['start_date'],
                $validated['end_date'],
                excludeId: $booking->id
            )) {
                return back()->with('error', 'Tanggal bentrok dengan pesanan lain. Pilih tanggal lain.');
            }
        }

        $updateData = [
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'notes'      => $validated['notes'] ?? $booking->notes,
        ];

        if ($request->hasFile('payment_proof')) {
            // Hapus yang lama
            if ($booking->payment_proof) {
                Storage::disk('public')->delete($booking->payment_proof);
            }
            $updateData['payment_proof'] = $request->file('payment_proof')
                ->store('bookings/payment-proofs', 'public');
        }

        $booking->update($updateData);

        return redirect()->route('user.bookings')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function userCancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'pending', 403);

        $booking->update(['status' => 'rejected']);

        return redirect()->route('user.bookings')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
