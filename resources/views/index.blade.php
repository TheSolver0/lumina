@extends('layout.app')

@section('content')

    {{-- ─── Google Fonts ────────────────────────────── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">

    
   

    {{-- ═══ FLASH MESSAGES ═══ --}}
    @if (session('success'))
        <div class="flash">
            <div class="flash-msg flash-success">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 8l3.5 3.5L13 4" stroke-linecap="round" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="flash">
            <div class="flash-msg flash-error">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="8" cy="8" r="6" />
                    <path d="M8 5v4M8 11v.5" stroke-linecap="round" />
                </svg>
                {{ $errors->first() }}
            </div>
        </div>
    @endif

    {{-- ═══ PAGE LAYOUT ═══ --}}
    <div class="page-wrap">

        {{-- ─── LEFT SIDEBAR ─── --}}
        <aside class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-head">
                    <span class="sidebar-title">Navigation</span>
                </div>
                <nav class="nav-list">
                    <a href="#" class="nav-entry active" onclick="showSection('feed',this)">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="3" width="12" height="2.5" rx="0.5" />
                            <rect x="2" y="7" width="8" height="2.5" rx="0.5" />
                            <rect x="2" y="11" width="10" height="2.5" rx="0.5" />
                        </svg>
                        Actualités
                    </a>
                    <a href="#" class="nav-entry" onclick="showSection('inscriptions',this)">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M8 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm-5 9c0-2 2-3.5 5-3.5s5 1.5 5 3.5v1H3v-1z" />
                        </svg>
                        Inscriptions
                    </a>
                    <a href="#" class="nav-entry">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="2" width="10" height="12" rx="1" />
                            <path d="M5 6h6M5 8.5h4" stroke-linecap="round" />
                        </svg>
                        Certifications
                    </a>
                    <a href="#" class="nav-entry">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="3" width="12" height="10" rx="1" />
                            <path d="M5 7h6M5 10h3" stroke-linecap="round" />
                        </svg>
                        Relevés de notes
                    </a>
                    <a href="#" class="nav-entry">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                            <path d="M8 5v3.5l2.5 1.5" stroke-linecap="round" />
                        </svg>
                        PVRs
                    </a>
                    <a href="#" class="nav-entry">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 8h10M8 3v10" stroke-linecap="round" />
                        </svg>
                        Rattrapages
                    </a>
                    <a href="#" class="nav-entry" onclick="showSection('forum',this)">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M2 4h12v7a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4zM5 8h6" stroke-linecap="round" />
                        </svg>
                        Forum
                    </a>
                </nav>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-head">
                    <span class="sidebar-title">Activité récente</span>
                </div>
                <div class="activity-list">
                    <div class="activity-entry">
                        <div class="activity-time">Il y a 2 jours</div>
                        <div class="activity-text">Commentaire sur la publication de Diamond M.</div>
                    </div>
                    <div class="activity-entry">
                        <div class="activity-time">Il y a 5 jours</div>
                        <div class="activity-text">Nouveau post dans la section Inscriptions.</div>
                    </div>
                    <div class="activity-entry">
                        <div class="activity-time">Il y a 1 semaine</div>
                        <div class="activity-text">Votre relevé de notes a été mis à jour.</div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ─── MAIN FEED ─── --}}
        <main class="feed" id="main-feed">

            {{-- ═══ SECTION : FIL D'ACTUALITÉ ═══ --}}
            <div id="section-feed">

                {{-- Tab switcher --}}
                <div class="feed-tabs">
                    <button class="feed-tab active">Tous les posts</button>
                    <button class="feed-tab" onclick="filterByTag('inscription')">Inscriptions</button>
                    <button class="feed-tab" onclick="filterByTag('certification')">Certifications</button>
                    <button class="feed-tab" onclick="filterByTag('releve')">Relevés</button>
                </div>

                {{-- Composer --}}
                @auth
                    <div class="composer">
                        <div class="composer-header">
                            <div class="composer-av">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                            <span class="composer-label">Rédiger un post — réservé aux autorisés</span>
                        </div>

                        <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="composer-body">
                                <input class="c-input" type="text" name="title" placeholder="Titre du post" required
                                    value="{{ old('title') }}">
                                <textarea class="c-textarea" name="body" rows="3"
                                    placeholder="Partagez une information, une annonce, une alerte...">{{ old('body') }}</textarea>
                                <div class="composer-row">
                                    <select class="c-select" name="category">
                                        <option value="">Catégorie</option>
                                        <option value="annonce">Annonce générale</option>
                                        <option value="inscription">Inscription</option>
                                        <option value="certification">Certification</option>
                                        <option value="releve">Relevé de notes</option>
                                        <option value="pvr">PVR</option>
                                        <option value="rattrapage">Rattrapage</option>
                                    </select>
                                </div>
                            </div>

                            <div id="preview-strip"></div>

                            <div class="composer-footer">
                                <div class="composer-left">
                                    <label class="upload-btn" for="media-upload">
                                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="2" y="3" width="12" height="10" rx="1" />
                                            <circle cx="5.5" cy="6.5" r="1" fill="currentColor"
                                                stroke="none" />
                                            <path d="M2 11.5l3.5-3.5 2.5 2.5 2-1.5 3.5 3.5" stroke-linecap="round" />
                                        </svg>
                                        Médias
                                        <input type="file" id="media-upload" name="media[]" accept="image/*,video/*"
                                            multiple style="position:absolute;opacity:0;width:0;height:0;">
                                    </label>
                                </div>
                                <button class="btn-post" type="submit">Publier</button>
                            </div>
                        </form>
                    </div>
                @endauth

                {{-- Posts --}}
                @forelse ($posts as $post)
                    <div class="post-card" data-category="{{ $post->category ?? 'general' }}">

                        <div class="post-head">
                            <div class="post-av">{{ strtoupper(substr($post->user->name ?? 'AN', 0, 2)) }}</div>
                            <div class="post-meta">
                                <div class="post-author">{{ $post->user->name ?? 'Anonyme' }}</div>
                                <div class="post-date">
                                    <svg width="10" height="10" viewBox="0 0 16 16" fill="none"
                                        stroke="currentColor" stroke-width="1.5"
                                        style="vertical-align:-1px;margin-right:3px;">
                                        <circle cx="8" cy="8" r="6" />
                                        <path d="M8 5v3.5l2 1" stroke-linecap="round" />
                                    </svg>
                                    Publié le {{ $post->created_at->format('d M Y') }} à
                                    {{ $post->created_at->format('H:i') }}
                                </div>
                            </div>

                            <div class="post-options">
                                <button class="options-btn" onclick="toggleMenu(this)">&#xFE19;</button>
                                <div class="options-menu">
                                    @auth
                                        @if (Auth::id() === $post->user_id || Auth::user()->is_admin)
                                            <button
                                                onclick="openEditModal({{ $post->id }}, '{{ addslashes($post->title) }}', '{{ addslashes($post->body) }}', '{{ $post->category }}')">
                                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path d="M11 2l3 3L6 13H3v-3L11 2z" />
                                                </svg>
                                                Modifier
                                            </button>
                                            <form method="POST" action="{{ route('post.destroy', $post) }}"
                                                onsubmit="return confirm('Supprimer ce post ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="danger">
                                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor"
                                                        stroke-width="1.5">
                                                        <path d="M3 5h10l-1 8H4L3 5zM6 3h4M1 5h14" stroke-linecap="round" />
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                    <a href="#">
                                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor"
                                            stroke-width="1.5">
                                            <path d="M8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                                            <path d="M8 7v4M8 5.5v.5" stroke-linecap="round" />
                                        </svg>
                                        Signaler
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="post-body">
                            @php
                                $catKey = $post->category ?? 'general';
                                $catLabels = [
                                    'annonce' => 'Annonce',
                                    'inscription' => 'Inscription',
                                    'certification' => 'Certification',
                                    'releve' => 'Relevé de notes',
                                    'pvr' => 'PVR',
                                    'rattrapage' => 'Rattrapage',
                                    'general' => 'Général',
                                ];
                            @endphp
                            @if ($post->category)
                                <div><span
                                        class="post-tag tag-{{ $catKey }}">{{ $catLabels[$catKey] ?? $catKey }}</span>
                                </div>
                            @endif
                            <div class="post-title-line">{{ $post->title }}</div>
                            @if ($post->body)
                                <p style="margin-top:4px;">{{ $post->body }}</p>
                            @endif
                        </div>

                        {{-- Media --}}
                        @if ($post->media && $post->media->count() > 0)
                            @php
                                $allMedia = $post->media;
                                $total = $allMedia->count();
                                $show = $allMedia->take(4);
                                $countClass =
                                    $total === 1
                                        ? 'count-1'
                                        : ($total === 2
                                            ? 'count-2'
                                            : ($total === 3
                                                ? 'count-3'
                                                : 'count-many'));
                            @endphp
                            <div class="media-grid {{ $countClass }}">
                                @foreach ($show as $i => $media)
                                    <div class="media-item">
                                        @if ($media->media_type === 'video')
                                            <video src="{{ $media->media_url }}" controls></video>
                                        @else
                                            <img src="{{ $media->media_url }}" alt="Media" loading="lazy">
                                        @endif
                                        @if ($i === 3 && $total > 4)
                                            <div class="media-more-overlay">+{{ $total - 4 }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Stats --}}
                        <div class="post-stats">
                            <span class="stat-item"><strong>0</strong> j'aime</span>
                            <span class="stat-item"><strong>0</strong> commentaires</span>
                            <span class="stat-item"><strong>0</strong> partages</span>
                        </div>

                        {{-- Actions --}}
                        <div class="post-actions">
                            <button class="action-btn" onclick="toggleLike(this)">
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M8 13S2.5 9 2.5 5.5a3.5 3.5 0 0 1 5.5-2.9A3.5 3.5 0 0 1 13.5 5.5C13.5 9 8 13 8 13z" />
                                </svg>
                                J'aime
                            </button>
                            <button class="action-btn" onclick="toggleComments(this, {{ $post->id }})">
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 3H2v8h3l3 3 3-3h3V3z" />
                                </svg>
                                Commenter
                            </button>
                            <button class="action-btn"
                                onclick="navigator.share ? navigator.share({title:'{{ addslashes($post->title) }}'}) : alert('Lien copié')">
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="4" r="1.5" />
                                    <circle cx="4" cy="8" r="1.5" />
                                    <circle cx="12" cy="12" r="1.5" />
                                    <path d="M5.5 7.3l5-2.6M5.5 8.7l5 2.6" />
                                </svg>
                                Partager
                            </button>
                        </div>

                        {{-- Comments --}}
                        <div class="comments-area" id="comments-{{ $post->id }}">
                            <p style="font-size:13px;color:var(--c-hint);padding-bottom:10px;">Aucun commentaire pour
                                l'instant.</p>
                            @auth
                                <form class="comment-form" method="POST" action="#">
                                    @csrf
                                    <div class="comment-av">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                                    <textarea name="body" placeholder="Ajouter un commentaire..." rows="1"></textarea>
                                    <button class="btn-comment" type="submit">Envoyer</button>
                                </form>
                            @endauth
                        </div>

                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">&#9702;</div>
                        <h3>Aucun post disponible</h3>
                        <p>Soyez le premier à publier une information.</p>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if ($posts->hasPages())
                    <div class="pagination-wrap">
                        {{ $posts->links() }}
                    </div>
                @endif

            </div>{{-- /section-feed --}}

            {{-- ═══ SECTION : FORUM ═══ --}}
            <div id="section-forum" style="display:none;">

                <div class="forum-header">
                    <h2>Forum étudiant</h2>
                    <p>Posez vos questions, partagez vos expériences avec la communauté universitaire.</p>
                    @auth
                        <button class="forum-new-btn" onclick="openForumModal()">
                            <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M8 3v10M3 8h10" stroke-linecap="round" />
                            </svg>
                            Nouveau sujet
                        </button>
                    @endauth
                </div>

                {{-- Forum threads (posts with category='forum') --}}
                @forelse($posts->where('category', 'forum') as $thread)
                    <div class="forum-thread">
                        <div class="thread-av">{{ strtoupper(substr($thread->user->name ?? 'AN', 0, 2)) }}</div>
                        <div class="thread-main">
                            <div class="thread-title">{{ $thread->title }}</div>
                            <div class="thread-excerpt">{{ Str::limit($thread->body, 120) }}</div>
                            <div class="thread-meta">
                                <span class="thread-meta-item">
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M8 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z" />
                                        <path d="M3 14c0-2 2-3.5 5-3.5s5 1.5 5 3.5" />
                                    </svg>
                                    {{ $thread->user->name ?? 'Anonyme' }}
                                </span>
                                <span class="thread-meta-item">
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="8" cy="8" r="6" />
                                        <path d="M8 5v3.5l2 1" stroke-linecap="round" />
                                    </svg>
                                    {{ $thread->created_at->diffForHumans() }}
                                </span>
                                <span class="thread-meta-item">
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M14 3H2v8h3l3 3 3-3h3V3z" />
                                    </svg>
                                    0 réponse(s)
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">&#8857;</div>
                        <h3>Forum vide</h3>
                        <p>Aucun sujet de discussion pour le moment. Lancez-vous !</p>
                    </div>
                @endforelse

            </div>{{-- /section-forum --}}

        </main>

        {{-- ─── RIGHT SIDEBAR ─── --}}
        <aside class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-head">
                    <span class="sidebar-title">Liens récents</span>
                    <a href="#" class="sidebar-link-all">Tout voir</a>
                </div>
                <div>
                    <div class="recent-item">
                        <img class="recent-thumb" src="{{ asset('assets/images/resources/FS_PREINSCRIPTIONS.jpg') }}"
                            alt="">
                        <div class="recent-info">
                            <div class="recent-title">Comment s'inscrire en ligne</div>
                            <div class="recent-time">Il y a 2 semaines</div>
                        </div>
                    </div>
                    <div class="recent-item">
                        <img class="recent-thumb" src="{{ asset('assets/images/resources/DEUP_GID.jpg') }}"
                            alt="">
                        <div class="recent-info">
                            <div class="recent-title">Problème de relevé de notes</div>
                            <div class="recent-time">Il y a 3 ans</div>
                        </div>
                    </div>
                    <div class="recent-item">
                        <img class="recent-thumb" src="{{ asset('assets/images/resources/FS_PREINSCRIPTIONS.jpg') }}"
                            alt="">
                        <div class="recent-info">
                            <div class="recent-title">Guide préinscription FS</div>
                            <div class="recent-time">Il y a 1 an</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-head">
                    <span class="sidebar-title">Membres actifs</span>
                </div>
                <div class="members-list">
                    @foreach ($posts->pluck('user')->unique('id')->take(5) as $member)
                        @if ($member)
                            <div class="member-row">
                                <div class="member-av">{{ strtoupper(substr($member->name, 0, 2)) }}</div>
                                <span class="member-name">{{ $member->name }}</span>
                                <div class="member-status"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </aside>

    </div>{{-- /page-wrap --}}

    {{-- ═══ EDIT MODAL ═══ --}}
    <div class="modal-backdrop" id="edit-modal">
        <div class="modal">
            <div class="modal-head">
                <h3>Modifier le post</h3>
                <button class="modal-close" onclick="closeModal('edit-modal')">&times;</button>
            </div>
            <form method="POST" id="edit-form" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <input class="c-input" type="text" name="title" id="edit-title" placeholder="Titre" required>
                    <textarea class="c-textarea" name="body" id="edit-body" rows="4" placeholder="Contenu..."></textarea>
                    <select class="c-select" name="category" id="edit-category">
                        <option value="">Catégorie</option>
                        <option value="annonce">Annonce générale</option>
                        <option value="inscription">Inscription</option>
                        <option value="certification">Certification</option>
                        <option value="releve">Relevé de notes</option>
                        <option value="pvr">PVR</option>
                        <option value="rattrapage">Rattrapage</option>
                    </select>
                    <label class="upload-btn" for="edit-media" style="width:fit-content;">
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <rect x="2" y="3" width="12" height="10" rx="1" />
                            <circle cx="5.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                            <path d="M2 11.5l3.5-3.5 2.5 2.5 2-1.5 3.5 3.5" stroke-linecap="round" />
                        </svg>
                        Ajouter des médias
                        <input type="file" id="edit-media" name="media[]" accept="image/*,video/*" multiple
                            style="position:absolute;opacity:0;width:0;height:0;">
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('edit-modal')">Annuler</button>
                    <button class="btn-post" type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══ FORUM NEW TOPIC MODAL ═══ --}}
    <div class="modal-backdrop" id="forum-modal">
        <div class="modal">
            <div class="modal-head">
                <h3>Nouveau sujet de discussion</h3>
                <button class="modal-close" onclick="closeModal('forum-modal')">&times;</button>
            </div>
            <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="forum">
                <div class="modal-body">
                    <input class="c-input" type="text" name="title" placeholder="Sujet de la discussion" required>
                    <textarea class="c-textarea" name="body" rows="5"
                        placeholder="Décrivez votre question ou votre sujet de discussion..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('forum-modal')">Annuler</button>
                    <button class="btn-post" type="submit">Publier le sujet</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══ SCRIPTS ═══ --}}
    <script>
        /* ── Section switching ── */
        function showSection(name, el) {
            ['feed', 'forum'].forEach(s => {
                document.getElementById('section-' + s).style.display = s === name ? 'block' : 'none';
            });
            document.querySelectorAll('.nav-entry').forEach(e => e.classList.remove('active'));
            if (el) el.classList.add('active');
            document.querySelectorAll('.nav-tab').forEach(t => {
                t.classList.toggle('active', t.dataset.tab === name);
            });
        }

        /* ── Nav tabs ── */
        document.querySelectorAll('.nav-tab[data-tab]').forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                showSection(tab.dataset.tab, null);
                document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });

        /* ── Options dropdown ── */
        function toggleMenu(btn) {
            const menu = btn.nextElementSibling;
            const isOpen = menu.classList.contains('open');
            document.querySelectorAll('.options-menu.open').forEach(m => m.classList.remove('open'));
            if (!isOpen) menu.classList.add('open');
        }
        document.addEventListener('click', e => {
            if (!e.target.closest('.post-options')) {
                document.querySelectorAll('.options-menu.open').forEach(m => m.classList.remove('open'));
            }
        });

        /* ── Like toggle ── */
        function toggleLike(btn) {
            btn.classList.toggle('liked');
            const txt = btn.querySelector('svg') ? btn.innerHTML.replace(/J'aime|Aimé/, btn.classList.contains('liked') ?
                'Aimé' : 'J\'aime') : '';
        }

        /* ── Toggle comments ── */
        function toggleComments(btn, postId) {
            const area = document.getElementById('comments-' + postId);
            if (area) area.classList.toggle('open');
        }

        /* ── Media preview ── */
        document.getElementById('media-upload')?.addEventListener('change', function() {
            const strip = document.getElementById('preview-strip');
            strip.innerHTML = '';
            Array.from(this.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.className = 'preview-thumb';
                    img.src = URL.createObjectURL(file);
                    strip.appendChild(img);
                }
            });
            if (this.files.length > 0) strip.style.paddingBottom = '8px';
        });

        /* ── Edit modal ── */
        function openEditModal(id, title, body, category) {
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-body').value = body;
            document.getElementById('edit-category').value = category || '';
            document.getElementById('edit-form').action = '/post/' + id;
            document.getElementById('edit-modal').classList.add('open');
        }

        /* ── Forum modal ── */
        function openForumModal() {
            document.getElementById('forum-modal').classList.add('open');
        }

        /* ── Close modal ── */
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        /* Click outside modal to close */
        document.querySelectorAll('.modal-backdrop').forEach(bd => {
            bd.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('open');
            });
        });

        /* ── Filter by category tab ── */
        function filterByTag(cat) {
            document.querySelectorAll('.post-card').forEach(card => {
                const c = card.dataset.category;
                card.style.display = (!cat || c === cat) ? 'block' : 'none';
            });
            document.querySelectorAll('.feed-tabs .feed-tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');
        }

        document.querySelectorAll('.feed-tabs .feed-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.feed-tabs .feed-tab').forEach(t => t.classList.remove(
                'active'));
                this.classList.add('active');
            });
        });

        /* Reset filter on "Tous" */
        document.querySelector('.feed-tabs .feed-tab')?.addEventListener('click', function() {
            document.querySelectorAll('.post-card').forEach(c => c.style.display = 'block');
        });
    </script>

@endsection
