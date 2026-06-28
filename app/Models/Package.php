<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
        'duration',
        'photo_count',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price'       => 'integer',
        'duration'    => 'integer',
        'photo_count' => 'integer',
        'sort_order'  => 'integer',
        'is_active'   => 'boolean',
    ];

    // ── Relationships ──────────────────────────────

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }


    public function getFormattedPricePerHourAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.') . '/jam';
    }

    // ── Scopes ─────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    /**
     * Harga per jam (alias dari price)
     */
    public function getPricePerHourAttribute(): int
    {
        return $this->price;
    }

    // ── Accessors ──────────────────────────────────

    /** Harga format Rupiah: Rp 1.500.000 */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /** Label status */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    /** Durasi label: "2 Jam" / "1 Jam" */
    public function getDurationLabelAttribute(): string
    {
        return $this->duration . ' Jam';
    }
}
