<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'type',
        'image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ─────────────────────────────────────

    public function scopeGallery($query)
    {
        return $query->where('type', 'gallery');
    }

    public function scopeEditorial($query)
    {
        return $query->where('type', 'editorial');
    }

    // ── Accessors ──────────────────────────────────

    /** Label tipe untuk display */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'gallery'   => 'Gallery Upload',
            'editorial' => 'Editorial Post',
            default     => ucfirst($this->type),
        };
    }

    /** Waktu relatif sejak publish */
    public function getTimeAgoAttribute(): string
    {
        return $this->published_at?->diffForHumans() ?? '-';
    }

    /** URL gambar */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : null;
    }

    // ── Boot ───────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Post $post) {
            // Auto-generate slug
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            // Selalu published saat dibuat
            $post->published_at = now();
        });

        static::updating(function (Post $post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
