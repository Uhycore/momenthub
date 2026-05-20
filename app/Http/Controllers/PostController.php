<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    // ── INDEX ──────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $filter = $request->query('filter', 'all'); // all | gallery | editorial

        $query = Post::with('user')->latest('published_at');

        $query = match ($filter) {
            'gallery'   => $query->gallery(),
            'editorial' => $query->editorial(),
            default     => $query,
        };

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->paginate(12)->withQueryString();

        // Featured = post terbaru
        $featured = Post::latest('published_at')->first();

        // Side cards (3 terbaru, exclude featured)
        $sideCards = Post::when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->latest('updated_at')
            ->limit(3)
            ->get();

        // Recent archives (exclude featured)
        $archives = Post::when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->latest('published_at')
            ->limit(8)
            ->get();

        $stats = [
            'total'     => Post::count(),
            'gallery'   => Post::gallery()->count(),
            'editorial' => Post::editorial()->count(),
        ];

        return view('admin.posts.index', compact(
            'posts',
            'featured',
            'sideCards',
            'archives',
            'stats',
            'filter'
        ));
    }

    // ── STORE ──────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body'    => 'nullable|string',
            'type'    => 'required|in:gallery,editorial',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('posts', 'public');
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Postingan berhasil dipublikasikan.');
    }

    // ── UPDATE ─────────────────────────────────────────────────────────

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body'    => 'nullable|string',
            'type'    => 'required|in:gallery,editorial',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')
                ->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Postingan berhasil diperbarui.');
    }

    // ── DESTROY ────────────────────────────────────────────────────────

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Postingan berhasil dihapus.');
    }
}
