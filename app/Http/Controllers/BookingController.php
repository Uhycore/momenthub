<?php

namespace App\Http\Controllers;

use App\Mail\BookingInvoiceMail;
use App\Models\Booking;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookingController extends Controller
{
    // ── HELPER ────────────────────────────────────────────────────────

    private function calcBilledHours(string $start, string $end): int
    {
        $minutes = Carbon::parse($start)->diffInMinutes(Carbon::parse($end));
        return (int) ceil($minutes / 60);
    }

    // ── CHECK AVAILABILITY (AJAX) ─────────────────────────────────────

    public function checkAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'booking_id' => 'nullable|integer',
        ]);

        if ($validated['end_date'] <= $validated['start_date']) {
            return response()->json([
                'available' => false,
                'message'   => 'Waktu selesai harus setelah waktu mulai.',
            ]);
        }

        $conflict = Booking::where('package_id', $validated['package_id'])
            ->whereNot('status', 'rejected')
            ->where('start_date', '<=', $validated['end_date'])
            ->where('end_date', '>=', $validated['start_date'])
            ->when($request->booking_id, fn($q) => $q->where('id', '!=', $request->booking_id))
            ->first();

        if ($conflict) {
            $from = Carbon::parse($conflict->start_date)->format('d M Y, H:i');
            $to   = Carbon::parse($conflict->end_date)->format('d M Y, H:i');

            return response()->json([
                'available' => false,
                'message'   => "Waktu ini sudah dipesan orang lain ({$from} – {$to} WIB). Silakan pilih waktu lain.",
            ]);
        }

        $package     = Package::findOrFail($validated['package_id']);
        $billedHours = $this->calcBilledHours($validated['start_date'], $validated['end_date']);
        $totalPrice  = $billedHours * $package->price;

        return response()->json([
            'available'       => true,
            'message'         => 'Waktu tersedia! Silakan lengkapi form dan konfirmasi pesanan.',
            'billed_hours'    => $billedHours,
            'total_price'     => $totalPrice,
            'formatted_total' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            'package'         => [
                'name'            => $package->name,
                'price'           => $package->price,
                'formatted_price' => $package->formatted_price,
            ],
        ]);
    }

    // ── STORE ─────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'package_id'    => 'required|exists:packages,id',
            'start_date'    => 'required|date|after_or_equal:now',
            'end_date'      => 'required|date|after:start_date',
            'notes'         => 'nullable|string|max:500',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        if (Booking::where('package_id', $validated['package_id'])
            ->whereNot('status', 'rejected')
            ->where('start_date', '<=', $validated['end_date'])
            ->where('end_date', '>=', $validated['start_date'])
            ->exists()
        ) {
            return back()->withInput()
                ->with('error', 'Waktu sudah tidak tersedia. Silakan pilih waktu lain.');
        }

        $package     = Package::findOrFail($validated['package_id']);
        $billedHours = $this->calcBilledHours($validated['start_date'], $validated['end_date']);
        $totalPrice  = $billedHours * $package->price;

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')
                ->store('bookings/payment-proofs', 'public');
        }

        $booking = Booking::create([
            'user_id'       => Auth::id(),
            'package_id'    => $validated['package_id'],
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
            'notes'         => $validated['notes'] ?? null,
            'payment_proof' => $paymentProofPath,
            'status'        => 'pending',
            'total_price'   => $totalPrice,
        ]);

        // ── Kirim invoice ke email user ──────────────────────────────
        try {
            $booking->load(['user', 'package']);
            Mail::to($booking->user->email)->send(new BookingInvoiceMail($booking));
        } catch (\Throwable $e) {
            // Log error tapi jangan block user
            logger()->error('BookingInvoiceMail failed: ' . $e->getMessage());
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'Pesanan berhasil dikirim! Invoice telah dikirim ke email Anda.');
    }

    // ── USER INDEX ────────────────────────────────────────────────────

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

    // ── USER UPDATE ───────────────────────────────────────────────────

    public function userUpdate(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless(in_array($booking->status, ['pending', 'confirmed']), 403);

        $validated = $request->validate([
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'notes'         => 'nullable|string|max:500',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        $newStart = Carbon::parse($validated['start_date'])->format('Y-m-d H:i');
        $oldStart = $booking->start_date->format('Y-m-d H:i');
        $newEnd   = Carbon::parse($validated['end_date'])->format('Y-m-d H:i');
        $oldEnd   = $booking->end_date->format('Y-m-d H:i');

        $dateChanged = $newStart !== $oldStart || $newEnd !== $oldEnd;

        if ($dateChanged) {
            if (Booking::where('package_id', $booking->package_id)
                ->whereNot('status', 'rejected')
                ->where('start_date', '<=', $validated['end_date'])
                ->where('end_date', '>=', $validated['start_date'])
                ->where('id', '!=', $booking->id)
                ->exists()
            ) {
                return back()->with('error', 'Waktu bentrok dengan pesanan lain. Pilih waktu lain.');
            }
        }

        $billedHours = $this->calcBilledHours($validated['start_date'], $validated['end_date']);
        $totalPrice  = $billedHours * $booking->package->price;

        $updateData = [
            'start_date'  => $validated['start_date'],
            'end_date'    => $validated['end_date'],
            'notes'       => $validated['notes'] ?? $booking->notes,
            'total_price' => $totalPrice,
        ];

        if ($request->hasFile('payment_proof')) {
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

    // ── USER CANCEL ───────────────────────────────────────────────────

    public function userCancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'pending', 403);

        $booking->update(['status' => 'rejected']);

        return redirect()->route('user.bookings')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
