<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'start_date',
        'end_date',
        'status',
        'payment_proof',
        'drive_link',
        'notes',
        'total_price',
    ];

    protected $casts = [
        'start_date'  => 'datetime',
        'end_date'    => 'datetime',
        'total_price' => 'integer',
    ];

    // ── Relationships ──────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    // ── Scopes ─────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ── Static helpers ─────────────────────────────

    public static function hasConflict(
        int $packageId,
        string $startDate,
        string $endDate,
        ?int $excludeId = null
    ): bool {
        return static::where('package_id', $packageId)
            ->where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate)
            ->exists();
    }

    // ── Accessors ──────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'rejected'  => 'Ditolak',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'badge-confirmed',
            'rejected'  => 'badge-rejected',
            default     => 'badge-pending',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof
            ? asset('storage/' . $this->payment_proof)
            : null;
    }

    public function getDurationDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}
