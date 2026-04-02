@extends('layout.app')

@push('styles')
<style>
    .forum-wrap {
        max-width: 1120px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
        display: grid;
        grid-template-columns: 230px minmax(0,1fr);
        gap: 1.5rem;
        align-items: start;
    }
    .sidebar { display: flex; flex-direction: column; gap: 1rem; position: sticky; top: 74px; }
    .sidebar-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .sidebar-head { padding: 14px 16px 10px; border-bottom: 1px solid var(--border); }
    .sidebar-head h4 {
        font-family: var(--font-serif);
        font-size: 13px;
        font-weight: 400;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: 0.09em;
    }
    .sidebar-body { padding: 6px 0; }
    .sidebar-item {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 16px; font-size: 13px; color: var(--text-2);
        text-decoration: none; font-weight: 400;
        transition: background .1s, color .1s;
        border-left: 2px solid transparent;
    }
    .sidebar-item:hover { background: var(--surface-2); color: var(--text); }
    .sidebar-item.active { color: var(--text); font-weight: 700; border-left-color: var(--text); background: var(--surface-2); }
    .sidebar-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--border-md); flex-shrink: 0; }
    .sidebar-item.active .sidebar-dot { background: var(--text); }

    /* ── THREAD DETAIL ── */
    .thread-detail { display: flex; flex-direction: column; gap: 1rem; }

    .thread-detail-header {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px 24px;
    }
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--text-3); text-decoration: none;
        margin-bottom: 14px; transition: color .12s;
    }
    .back-link:hover { color: var(--text-2); }
    .back-link svg { width: 13px; height: 13px; }

    .thread-detail-title {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        color: var(--text);
        margin-bottom: 12px;
        line-height: 1.35;
    }
    .thread-detail-meta {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .th-avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: var(--surface-2);
        border: 1px solid var(--border-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 10px; font-weight: 700; color: var(--text-2); flex-shrink: 0;
    }
    .meta-author { font-size: 13px; font-weight: 700; color: var(--text); }
    .meta-time { font-size: 12px; color: var(--text-3); }
    .meta-sep { color: var(--border-md); }

    .tag {
        display: inline-block; font-size: 10px; font-weight: 700;
        letter-spacing: 0.08em; text-transform: uppercase;
        padding: 2px 8px; border-radius: 3px;
    }
    .tag-blue { background: var(--blue-bg); color: var(--blue-text); }
    .tag-green { background: var(--green-bg); color: var(--green-text); }
    .tag-amber { background: var(--amber-bg); color: var(--amber-text); }
    .tag-red { background: var(--red-bg); color: var(--red-text); }
    .resolved-badge {
        font-size: 10px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
        background: var(--green-bg); color: var(--green-text);
        padding: 2px 7px; border-radius: 3px;
    }

    /* OP POST */
    .op-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        border-left: 3px solid var(--text);
        padding: 20px 24px;
    }
    .op-body {
        font-size: 14px;
        line-height: 1.7;
        color: var(--text);
        white-space: pre-line;
        margin-bottom: 14px;
    }
    .op-footer {
        display: flex; align-items: center; gap: 10px;
        padding-top: 12px; border-top: 1px solid var(--border);
    }

    /* REPLIES */
    .replies-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 4px;
    }
    .replies-header h3 {
        font-family: var(--font-serif);
        font-size: 15px; font-weight: 400; color: var(--text-2);
    }
    .reply-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 20px;
        transition: border-color .15s;
    }
    .reply-card:hover { border-color: var(--border-md); }
    .reply-card.best-answer { border-left: 3px solid var(--green); }

    .reply-header {
        display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px;
    }
    .reply-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--surface-2);
        border: 1px solid var(--border-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: var(--text-2); flex-shrink: 0;
    }
    .reply-meta { flex: 1; }
    .reply-author { font-size: 13px; font-weight: 700; color: var(--text); }
    .reply-time { font-size: 11px; color: var(--text-3); margin-top: 1px; }
    .reply-body { font-size: 14px; line-height: 1.65; color: var(--text); white-space: pre-line; }
    .reply-footer {
        display: flex; align-items: center; gap: 8px;
        margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--border);
    }
    .reply-action-btn {
        display: flex; align-items: center; gap: 5px;
        font-size: 12px; color: var(--text-3); cursor: pointer;
        font-weight: 700; letter-spacing: 0.02em;
        border: none; background: none;
        font-family: var(--font-sans);
        padding: 4px 8px; border-radius: var(--radius-sm);
        transition: background .1s, color .1s;
    }
    .reply-action-btn:hover { background: var(--surface-2); color: var(--text-2); }
    .reply-action-btn.liked { color: var(--red); }
    .reply-action-btn svg { width: 13px; height: 13px; }
    .best-answer-badge {
        margin-left: auto;
        font-size: 10px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
        background: var(--green-bg); color: var(--green-text);
        padding: 2px 7px; border-radius: 3px;
    }

    /* ACTION BTNS */
    .btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 8px 18px; border-radius: var(--radius-sm);
        font-family: var(--font-sans); font-size: 13px; font-weight: 700;
        cursor: pointer; text-decoration: none;
        transition: opacity .15s, background .15s; border: none;
    }
    .btn-primary { background: var(--text); color: var(--surface); }
    .btn-primary:hover { opacity: 0.82; }
    .btn-ghost {
        background: transparent; color: var(--text-2);
        border: 1px solid var(--border-md);
    }
    .btn-ghost:hover { background: var(--surface-2); color: var(--text); }

    /* COMPOSE REPLY */
    .compose-reply {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 20px;
    }
    .compose-reply h4 {
        font-family: var(--font-serif);
        font-size: 15px; font-weight: 400; margin-bottom: 12px; color: var(--text-2);
    }
    .compose-reply-row {
        display: flex; gap: 10px; align-items: flex-start;
    }
    .compose-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--surface-2);
        border: 1px solid var(--border-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: var(--text-2); flex-shrink: 0;
    }
    .field-textarea {
        width: 100%;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 9px 13px;
        font-family: var(--font-sans); font-size: 13px; color: var(--text);
        outline: none; resize: none; line-height: 1.55;
        transition: border-color .15s;
    }
    .field-textarea:focus { border-color: var(--border-md); background: var(--surface); }
    .field-textarea::placeholder { color: var(--text-3); }

    .empty-state {
        text-align: center; padding: 2rem 1rem; color: var(--text-3);
    }
    .empty-state p { font-size: 13px; }

    @media (max-width: 900px) {
        .forum-wrap { grid-template-columns: 1fr; }
        .sidebar { display: none; }
    }
</style>
@endpush

@section('content')
<div class="forum-wrap">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">
        <div class="sidebar-card">
            <div class="sidebar-head"><h4>Catégories</h4></div>
            <div class="sidebar-body">
                <a href="{{ route('forum.index') }}" class="sidebar-item">
                    <span class="sidebar-dot"></span> Tous les sujets
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('forum.index', ['category' => $cat->slug]) }}" class="sidebar-item {{ $thread->category_id === $cat->id ? 'active' : '' }}">
                    <span class="sidebar-dot"></span> {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="sidebar-card">
            <div class="sidebar-head"><h4>Info fil</h4></div>
            <div class="sidebar-body" style="padding: 12px 16px;">
                <div style="font-size:12px;color:var(--text-3);line-height:1.8;">
                    <div><strong style="color:var(--text-2);">{{ $thread->replies_count ?? $replies->total() }}</strong> réponse{{ ($thread->replies_count ?? 0) > 1 ? 's' : '' }}</div>
                    <div><strong style="color:var(--text-2);">{{ $thread->views_count ?? 0 }}</strong> vue{{ ($thread->views_count ?? 0) > 1 ? 's' : '' }}</div>
                    <div>Créé {{ $thread->created_at->diffForHumans() }}</div>
                </div>
                @auth
                @if(Auth::id() === $thread->user_id)
                <div style="margin-top:12px;">
                    <form method="POST" action="{{ route('forum.destroy', $thread) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-ghost" style="width:100%;justify-content:center;font-size:12px;"
                            onclick="return confirm('Supprimer cette discussion ?')">
                            Supprimer la discussion
                        </button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
        </div>
    </aside>

    {{-- ── THREAD CONTENT ── --}}
    <div class="thread-detail">

        {{-- Header --}}
        <div class="thread-detail-header">
            <a href="{{ route('forum.index') }}" class="back-link">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <path d="M10 12L6 8l4-4"/>
                </svg>
                Retour au forum
            </a>
            <div class="thread-detail-title">{{ $thread->title }}</div>
            <div class="thread-detail-meta">
                <div class="th-avatar">{{ strtoupper(substr($thread->user->name, 0, 2)) }}</div>
                <span class="meta-author">{{ $thread->user->name }}</span>
                <span class="meta-sep">·</span>
                <span class="meta-time">{{ $thread->created_at->translatedFormat('d M Y, H:i') }}</span>
                @if($thread->category)
                    @php
                        $tClass = match($thread->category->slug ?? '') {
                            'inscriptions' => 'tag-blue',
                            'certifications', 'releves' => 'tag-green',
                            'pvr', 'rattrapages' => 'tag-amber',
                            default => 'tag-blue',
                        };
                    @endphp
                    <span class="meta-sep">·</span>
                    <span class="tag {{ $tClass }}">{{ $thread->category->name }}</span>
                @endif
                @if($thread->is_resolved ?? false)
                    <span class="resolved-badge">Résolu</span>
                @endif
            </div>
        </div>

        {{-- Original post --}}
        <div class="op-card">
            <div class="op-body">{{ $thread->body }}</div>
            <div class="op-footer">
                <button class="reply-action-btn {{ $thread->user_liked ?? false ? 'liked' : '' }}"
                        id="like-thread-btn"
                        onclick="likeThread({{ $thread->id }})">
                    <svg viewBox="0 0 16 16" fill="{{ $thread->user_liked ?? false ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.3">
                        <path d="M8 13s-6-4-6-8a4 4 0 0 1 6-3.46A4 4 0 0 1 14 5c0 4-6 8-6 8z"/>
                    </svg>
                    <span id="thread-likes-count">{{ $thread->likes_count ?? 0 }}</span> j'aime
                </button>
                @auth
                @if(Auth::id() === $thread->user_id && !($thread->is_resolved ?? false))
                <form method="POST" action="{{ route('forum.resolve', $thread) }}" style="margin-left:auto;">
                    @csrf
                    <button type="submit" class="btn btn-ghost" style="padding:5px 12px;font-size:12px;">
                        Marquer comme résolu
                    </button>
                </form>
                @endif
                @endauth
            </div>
        </div>

        {{-- Replies --}}
        <div class="replies-header">
            <h3>{{ $replies->total() }} réponse{{ $replies->total() > 1 ? 's' : '' }}</h3>
        </div>

        @forelse($replies as $reply)
        <div class="reply-card {{ $reply->is_best_answer ?? false ? 'best-answer' : '' }}" id="reply-{{ $reply->id }}">
            <div class="reply-header">
                <div class="reply-avatar">
                    {{ strtoupper(substr($reply->user->name, 0, 2)) }}
                </div>
                <div class="reply-meta">
                    <div class="reply-author">{{ $reply->user->name }}</div>
                    <div class="reply-time">{{ $reply->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <div class="reply-body">{{ $reply->body }}</div>
            <div class="reply-footer">
                <button class="reply-action-btn {{ $reply->user_liked ?? false ? 'liked' : '' }}"
                        id="like-reply-{{ $reply->id }}"
                        onclick="likeReply({{ $reply->id }})">
                    <svg viewBox="0 0 16 16" fill="{{ $reply->user_liked ?? false ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.3">
                        <path d="M8 13s-6-4-6-8a4 4 0 0 1 6-3.46A4 4 0 0 1 14 5c0 4-6 8-6 8z"/>
                    </svg>
                    <span id="reply-likes-{{ $reply->id }}">{{ $reply->likes_count ?? 0 }}</span>
                </button>
                @auth
                @if(Auth::id() === $thread->user_id && !($thread->is_resolved ?? false))
                <form method="POST" action="{{ route('forum.best-answer', [$thread, $reply]) }}">
                    @csrf
                    <button type="submit" class="reply-action-btn" style="color:var(--green);">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 8l3 3 7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Meilleure réponse
                    </button>
                </form>
                @endif
                @endauth
                @if($reply->is_best_answer ?? false)
                <span class="best-answer-badge">Meilleure réponse</span>
                @endif
                <span style="margin-left:auto;font-size:11px;color:var(--text-3);">#{{ $loop->iteration }}</span>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p>Aucune réponse pour l'instant. Soyez le premier à répondre.</p>
        </div>
        @endforelse

        {{-- Replies pagination --}}
        @if($replies->hasPages())
        <div style="display:flex;justify-content:center;gap:6px;">
            @if(!$replies->onFirstPage())
                <a href="{{ $replies->previousPageUrl() }}" style="padding:6px 12px;border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--text-2);text-decoration:none;">← Précédent</a>
            @endif
            @if($replies->hasMorePages())
                <a href="{{ $replies->nextPageUrl() }}" style="padding:6px 12px;border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--text-2);text-decoration:none;">Suivant →</a>
            @endif
        </div>
        @endif

        {{-- Compose reply --}}
        @auth
        <div class="compose-reply">
            <h4>Votre réponse</h4>
            <form method="POST" action="{{ route('forum.reply', $thread) }}">
                @csrf
                <div class="compose-reply-row">
                    <div class="compose-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div style="flex:1;display:flex;flex-direction:column;gap:8px;">
                        <textarea name="body" class="field-textarea" rows="4"
                                  placeholder="Rédigez une réponse claire et constructive..." required></textarea>
                        <div style="display:flex;justify-content:flex-end;">
                            <button type="submit" class="btn btn-primary">Publier la réponse</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @else
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;text-align:center;">
            <p style="font-size:14px;color:var(--text-2);margin-bottom:12px;">Connectez-vous pour répondre à cette discussion.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
        </div>
        @endauth

    </div>
</div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

async function likeThread(threadId) {
    try {
        const res = await fetch(`/forum/${threadId}/like`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        const btn = document.getElementById('like-thread-btn');
        if (data.liked !== undefined) {
            btn.classList.toggle('liked', data.liked);
            btn.querySelector('svg').setAttribute('fill', data.liked ? 'currentColor' : 'none');
            document.getElementById('thread-likes-count').textContent = data.count;
        }
    } catch(e) { console.error(e); }
}

async function likeReply(replyId) {
    try {
        const res = await fetch(`/forum/reply/${replyId}/like`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        const btn = document.getElementById('like-reply-' + replyId);
        if (data.liked !== undefined) {
            btn.classList.toggle('liked', data.liked);
            btn.querySelector('svg').setAttribute('fill', data.liked ? 'currentColor' : 'none');
            document.getElementById('reply-likes-' + replyId).textContent = data.count;
        }
    } catch(e) { console.error(e); }
}
</script>
@endpush