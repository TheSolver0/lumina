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

    /* ── SIDEBAR ── */
    .sidebar { display: flex; flex-direction: column; gap: 1rem; position: sticky; top: 74px; }
    .sidebar-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .sidebar-head {
        padding: 14px 16px 10px;
        border-bottom: 1px solid var(--border);
    }
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
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 16px;
        font-size: 13px;
        color: var(--text-2);
        text-decoration: none;
        font-weight: 400;
        transition: background .1s, color .1s;
        border-left: 2px solid transparent;
        cursor: pointer;
    }
    .sidebar-item:hover { background: var(--surface-2); color: var(--text); }
    .sidebar-item.active {
        color: var(--text);
        font-weight: 700;
        border-left-color: var(--text);
        background: var(--surface-2);
    }
    .sidebar-dot {
        width: 4px; height: 4px;
        border-radius: 50%;
        background: var(--border-md);
        flex-shrink: 0;
    }
    .sidebar-item.active .sidebar-dot { background: var(--text); }
    .cat-count {
        margin-left: auto;
        font-size: 11px;
        color: var(--text-3);
        background: var(--surface-2);
        padding: 1px 7px;
        border-radius: 20px;
        border: 1px solid var(--border);
    }

    /* ── FORUM MAIN ── */
    .forum-main { display: flex; flex-direction: column; gap: 1rem; }

    .forum-header {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .forum-header-left h1 {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        color: var(--text);
        margin-bottom: 3px;
    }
    .forum-header-left p {
        font-size: 13px;
        color: var(--text-3);
    }
    .forum-filter {
        display: flex;
        gap: 6px;
    }
    .filter-btn {
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        font-size: 12px;
        font-weight: 700;
        color: var(--text-3);
        border: 1px solid var(--border);
        background: none;
        font-family: var(--font-sans);
        cursor: pointer;
        transition: all .12s;
        letter-spacing: 0.03em;
    }
    .filter-btn:hover { color: var(--text-2); border-color: var(--border-md); }
    .filter-btn.active { background: var(--text); color: var(--surface); border-color: var(--text); }

    /* New thread composer */
    .thread-composer {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .thread-composer-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: background .1s;
    }
    .thread-composer-header:hover { background: var(--surface-2); }
    .thread-composer-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--surface-2);
        border: 1px solid var(--border-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
        color: var(--text-2);
        flex-shrink: 0;
    }
    .thread-composer-placeholder {
        font-size: 14px;
        color: var(--text-3);
        flex: 1;
    }
    .thread-composer-body {
        display: none;
        padding: 16px 20px;
    }
    .thread-composer-body.open { display: block; }

    /* Thread list */
    .thread-list { display: flex; flex-direction: column; gap: 0; }
    .thread-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 20px;
        margin-bottom: 8px;
        transition: border-color .15s, box-shadow .15s;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }
    .thread-card:hover {
        border-color: var(--border-md);
    }
    .thread-card-top {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 10px;
    }
    .thread-avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: var(--surface-2);
        border: 1px solid var(--border-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700;
        color: var(--text-2);
        flex-shrink: 0;
    }
    .thread-meta { flex: 1; min-width: 0; }
    .thread-author-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 2px;
    }
    .thread-author {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
    }
    .thread-time { font-size: 11px; color: var(--text-3); }
    .thread-title {
        font-family: var(--font-serif);
        font-size: 16px;
        font-weight: 400;
        color: var(--text);
        line-height: 1.4;
        margin-bottom: 6px;
    }
    .thread-excerpt {
        font-size: 13px;
        color: var(--text-2);
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .thread-footer {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid var(--border);
    }
    .thread-stat {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--text-3);
    }
    .thread-stat svg { width: 13px; height: 13px; }
    .thread-stat strong { color: var(--text-2); font-weight: 700; }
    .thread-views { margin-left: auto; font-size: 11px; color: var(--text-3); }

    .pinned-badge {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        background: var(--amber-bg);
        color: var(--amber-text);
        padding: 2px 7px;
        border-radius: 3px;
    }
    .resolved-badge {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        background: var(--green-bg);
        color: var(--green-text);
        padding: 2px 7px;
        border-radius: 3px;
    }

    /* ── THREAD DETAIL VIEW ── */
    .thread-detail { display: flex; flex-direction: column; gap: 1rem; }
    .thread-detail-header {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px 24px;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-3);
        text-decoration: none;
        margin-bottom: 14px;
        transition: color .12s;
    }
    .back-link:hover { color: var(--text-2); }
    .thread-detail-title {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        color: var(--text);
        margin-bottom: 8px;
        line-height: 1.35;
    }
    .thread-detail-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .thread-detail-meta .thread-avatar { width: 28px; height: 28px; font-size: 10px; }
    .thread-detail-meta span { font-size: 13px; color: var(--text-2); }
    .thread-detail-meta .thread-time { font-size: 12px; color: var(--text-3); }

    .reply-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 20px;
    }
    .reply-card.op { border-left: 3px solid var(--text); }
    .reply-header {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
    }
    .reply-body {
        font-size: 14px;
        line-height: 1.65;
        color: var(--text);
        white-space: pre-line;
    }
    .reply-footer {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid var(--border);
    }
    .reply-action {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--text-3);
        cursor: pointer;
        font-weight: 700;
        letter-spacing: 0.02em;
        border: none;
        background: none;
        font-family: var(--font-sans);
        padding: 4px 8px;
        border-radius: var(--radius-sm);
        transition: background .1s, color .1s;
    }
    .reply-action:hover { background: var(--surface-2); color: var(--text-2); }
    .reply-action svg { width: 13px; height: 13px; }
    .reply-num { margin-left: auto; font-size: 11px; color: var(--text-3); }

    /* Compose reply */
    .compose-reply {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 20px;
    }
    .compose-reply h4 {
        font-family: var(--font-serif);
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 12px;
        color: var(--text-2);
    }
    .compose-reply-row {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    /* Tag */
    .tag {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 3px;
    }
    .tag-blue { background: var(--blue-bg); color: var(--blue-text); }
    .tag-green { background: var(--green-bg); color: var(--green-text); }
    .tag-amber { background: var(--amber-bg); color: var(--amber-text); }
    .tag-red { background: var(--red-bg); color: var(--red-text); }

    /* Fields */
    .field-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-2);
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .field-input, .field-textarea, .composer-select {
        width: 100%;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 9px 13px;
        font-family: var(--font-sans);
        font-size: 13px;
        color: var(--text);
        outline: none;
        transition: border-color .15s;
        appearance: none;
    }
    .field-input:focus, .field-textarea:focus, .composer-select:focus {
        border-color: var(--border-md);
        background: var(--surface);
    }
    .field-input::placeholder, .field-textarea::placeholder { color: var(--text-3); }
    .field-textarea { resize: none; line-height: 1.55; }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: var(--radius-sm);
        font-family: var(--font-sans);
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: opacity .15s, background .15s;
        border: none;
    }
    .btn-primary { background: var(--text); color: var(--surface); }
    .btn-primary:hover { opacity: 0.82; }
    .btn-ghost {
        background: transparent;
        color: var(--text-2);
        border: 1px solid var(--border-md);
    }
    .btn-ghost:hover { background: var(--surface-2); color: var(--text); }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-3);
    }
    .empty-state h3 {
        font-family: var(--font-serif);
        font-size: 18px;
        font-weight: 400;
        margin-bottom: 6px;
        color: var(--text-2);
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

    {{-- ── LEFT SIDEBAR ── --}}
    <aside class="sidebar">
        <div class="sidebar-card">
            <div class="sidebar-head"><h4>Catégories</h4></div>
            <div class="sidebar-body">
                <a href="{{ route('forum.index') }}" class="sidebar-item {{ !request('category') ? 'active' : '' }}">
                    <span class="sidebar-dot"></span>
                    Tous les sujets
                    <span class="cat-count">{{ $totalThreads ?? 0 }}</span>
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('forum.index', ['category' => $cat->slug]) }}"
                   class="sidebar-item {{ request('category') === $cat->slug ? 'active' : '' }}">
                    <span class="sidebar-dot"></span>
                    {{ $cat->name }}
                    <span class="cat-count">{{ $cat->threads_count }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="sidebar-card">
            <div class="sidebar-head"><h4>Navigation</h4></div>
            <div class="sidebar-body">
                <a href="{{ route('posts.index') }}" class="sidebar-item">
                    <span class="sidebar-dot"></span> Actualités
                </a>
                <a href="{{ route('forum.index') }}" class="sidebar-item active">
                    <span class="sidebar-dot"></span> Forum
                </a>
            </div>
        </div>
    </aside>

    {{-- ── FORUM CONTENT ── --}}
    <div class="forum-main">

        {{-- Header --}}
        <div class="forum-header">
            <div class="forum-header-left">
                <h1>Forum étudiant</h1>
                <p>{{ $totalThreads ?? 0 }} discussion{{ ($totalThreads ?? 0) > 1 ? 's' : '' }} · Posez vos questions, partagez vos expériences</p>
            </div>
            <div class="forum-filter">
                <button class="filter-btn {{ !request('sort') || request('sort') === 'recent' ? 'active' : '' }}"
                        onclick="setSort('recent')">Récents</button>
                <button class="filter-btn {{ request('sort') === 'popular' ? 'active' : '' }}"
                        onclick="setSort('popular')">Populaires</button>
                <button class="filter-btn {{ request('sort') === 'unanswered' ? 'active' : '' }}"
                        onclick="setSort('unanswered')">Sans réponse</button>
            </div>
        </div>

        {{-- New thread --}}
        @auth
        <div class="thread-composer" id="threadComposer">
            <div class="thread-composer-header" onclick="toggleComposer()">
                <div class="thread-composer-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <span class="thread-composer-placeholder">Démarrer une nouvelle discussion...</span>
                <button class="btn btn-primary" style="pointer-events:none;padding:6px 14px;font-size:12px;">Nouveau sujet</button>
            </div>
            <div class="thread-composer-body" id="composerBody">
                <form method="POST" action="{{ route('forum.store') }}">
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <div>
                            <div class="field-label">Catégorie</div>
                            <select name="category_id" class="composer-select">
                                <option value="">Choisir une catégorie</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <div class="field-label">Titre de la discussion</div>
                            <input type="text" name="title" class="field-input" placeholder="Formulez votre question clairement..." required>
                        </div>
                        <div>
                            <div class="field-label">Description</div>
                            <textarea name="body" class="field-textarea" rows="4"
                                placeholder="Décrivez votre situation en détail pour obtenir de meilleures réponses..."></textarea>
                        </div>
                        <div style="display:flex;justify-content:flex-end;gap:8px;padding-top:4px;">
                            <button type="button" class="btn btn-ghost" onclick="toggleComposer()">Annuler</button>
                            <button type="submit" class="btn btn-primary">Publier la discussion</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endauth

        {{-- Thread list --}}
        @forelse($threads as $thread)
        <a href="{{ route('forum.show', $thread) }}" class="thread-card">
            <div class="thread-card-top">
                <div class="thread-avatar">
                    {{ strtoupper(substr($thread->user->name, 0, 2)) }}
                </div>
                <div class="thread-meta">
                    <div class="thread-author-row">
                        <span class="thread-author">{{ $thread->user->name }}</span>
                        @if($thread->is_pinned ?? false)
                            <span class="pinned-badge">Épinglé</span>
                        @endif
                        @if($thread->is_resolved ?? false)
                            <span class="resolved-badge">Résolu</span>
                        @endif
                        @if($thread->category)
                            @php
                                $tClass = match($thread->category->slug ?? '') {
                                    'inscriptions' => 'tag-blue',
                                    'certifications', 'releves' => 'tag-green',
                                    'pvr', 'rattrapages' => 'tag-amber',
                                    default => 'tag-blue',
                                };
                            @endphp
                            <span class="tag {{ $tClass }}">{{ $thread->category->name }}</span>
                        @endif
                        <span class="thread-time">{{ $thread->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="thread-title">{{ $thread->title }}</div>
                    <div class="thread-excerpt">{{ $thread->body }}</div>
                </div>
            </div>
            <div class="thread-footer">
                <div class="thread-stat">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.3">
                        <path d="M2 3h12v8H9l-2 2-2-2H2z"/>
                    </svg>
                    <strong>{{ $thread->replies_count ?? 0 }}</strong> réponse{{ ($thread->replies_count ?? 0) > 1 ? 's' : '' }}
                </div>
                <div class="thread-stat">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.3">
                        <path d="M8 12s-5-3.5-5-7a5 5 0 0 1 10 0c0 3.5-5 7-5 7z"/>
                    </svg>
                    <strong>{{ $thread->likes_count ?? 0 }}</strong> j'aime
                </div>
                <div class="thread-views">
                    {{ $thread->views_count ?? 0 }} vue{{ ($thread->views_count ?? 0) > 1 ? 's' : '' }}
                </div>
                @if($thread->latest_reply)
                <div style="font-size:11px;color:var(--text-3);margin-left:auto;">
                    Dernière réponse {{ $thread->latest_reply->created_at->diffForHumans() }}
                    par <strong style="color:var(--text-2);">{{ $thread->latest_reply->user->name }}</strong>
                </div>
                @endif
            </div>
        </a>
        @empty
        <div class="empty-state">
            <h3>Aucune discussion pour l'instant</h3>
            <p>Soyez le premier à poser une question ou partager une expérience.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if(isset($threads) && $threads->hasPages())
        <div style="display:flex;justify-content:center;padding:0.5rem 0;gap:6px;">
            @if($threads->onFirstPage())
                <span style="padding:6px 12px;border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--text-3);opacity:.5;">← Précédent</span>
            @else
                <a href="{{ $threads->previousPageUrl() }}" style="padding:6px 12px;border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--text-2);text-decoration:none;">← Précédent</a>
            @endif
            @if($threads->hasMorePages())
                <a href="{{ $threads->nextPageUrl() }}" style="padding:6px 12px;border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--text-2);text-decoration:none;">Suivant →</a>
            @else
                <span style="padding:6px 12px;border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--text-3);opacity:.5;">Suivant →</span>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleComposer() {
    document.getElementById('composerBody').classList.toggle('open');
}
function setSort(sort) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sort);
    window.location = url;
}
</script>
@endpush