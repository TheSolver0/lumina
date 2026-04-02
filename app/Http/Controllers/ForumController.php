<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $categories = ForumCategory::withCount('threads')->orderBy('sort_order')->get();

        $query = ForumThread::with(['user', 'category', 'latestReply.user'])
            ->withCount(['replies', 'likes'])
            ->orderByDesc('is_pinned');

        // Filtrer par catégorie
        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Trier
        match($request->sort) {
            'popular'    => $query->orderByDesc('likes_count')->orderByDesc('replies_count'),
            'unanswered' => $query->having('replies_count', 0)->orderByDesc('id'),
            default      => $query->orderByDesc('created_at'),
        };

        $threads = $query->paginate(20)->withQueryString();
        $totalThreads = ForumThread::count();

        return view('forum.index', compact('threads', 'categories', 'totalThreads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'nullable|string',
            'category_id' => 'nullable|exists:forum_categories,id',
        ]);

        ForumThread::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'body'        => $request->body,
        ]);

        return redirect()->route('forum.index')->with('success', 'Discussion créée avec succès !');
    }

    public function show(ForumThread $thread)
    {
        $thread->increment('views_count');

        $thread->load(['user', 'category']);
        $thread->loadCount(['likes']);
        $thread->user_liked = $thread->likes()->where('user_id', Auth::id())->exists();

        $categories = ForumCategory::orderBy('sort_order')->get();

        $replies = ForumReply::with('user')
            ->withCount('likes')
            ->where('thread_id', $thread->id)
            ->orderBy('is_best_answer', 'desc')
            ->orderBy('created_at')
            ->paginate(20);

        // Ajouter user_liked sur chaque réponse
        $replies->getCollection()->transform(function ($reply) {
            $reply->user_liked = $reply->likes()->where('user_id', Auth::id())->exists();
            return $reply;
        });

        return view('forum.show', compact('thread', 'replies', 'categories'));
    }

    public function reply(Request $request, ForumThread $thread)
    {
        $request->validate(['body' => 'required|string']);

        ForumReply::create([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
            'body'      => $request->body,
        ]);

        return redirect()->route('forum.show', $thread)->with('success', 'Réponse publiée !');
    }

    public function destroy(ForumThread $thread)
    {
        abort_unless(Auth::id() === $thread->user_id, 403);
        $thread->replies()->delete();
        $thread->delete();
        return redirect()->route('forum.index')->with('success', 'Discussion supprimée.');
    }

    public function like(ForumThread $thread)
    {
        $like = $thread->likes()->where('user_id', Auth::id());
        if ($like->exists()) {
            $like->delete();
            $liked = false;
        } else {
            $thread->likes()->create(['user_id' => Auth::id()]);
            $liked = true;
        }
        return response()->json(['liked' => $liked, 'count' => $thread->likes()->count()]);
    }

    public function likeReply(ForumReply $reply)
    {
        $like = $reply->likes()->where('user_id', Auth::id());
        if ($like->exists()) {
            $like->delete();
            $liked = false;
        } else {
            $reply->likes()->create(['user_id' => Auth::id()]);
            $liked = true;
        }
        return response()->json(['liked' => $liked, 'count' => $reply->likes()->count()]);
    }

    public function markBestAnswer(ForumThread $thread, ForumReply $reply)
    {
        abort_unless(Auth::id() === $thread->user_id, 403);
        // Enlever l'ancienne meilleure réponse
        $thread->replies()->update(['is_best_answer' => false]);
        $reply->update(['is_best_answer' => true]);
        $thread->update(['is_resolved' => true]);
        return redirect()->route('forum.show', $thread)->with('success', 'Meilleure réponse marquée !');
    }

    public function resolve(ForumThread $thread)
    {
        abort_unless(Auth::id() === $thread->user_id, 403);
        $thread->update(['is_resolved' => true]);
        return back()->with('success', 'Discussion marquée comme résolue.');
    }
}

