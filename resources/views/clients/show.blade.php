{{-- resources/views/clients/show.blade.php --}}
@extends('layouts.app')

@section('title', $client->name . ' — Profile')

@push('styles')
<style>
    /* ── Hero Header ── */
    .client-hero {
        background: linear-gradient(135deg, #1B2B4B 0%, #2E75B6 60%, #1B2B4B 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid #334155;
        position: relative;
        overflow: hidden;
    }
    /* Decorative geometric pattern in the background */
    .client-hero::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        border: 2px solid rgba(245,158,11,.12);
        border-radius: 50%;
    }
    .client-hero::after {
        content: '';
        position: absolute;
        top: 10px; right: 10px;
        width: 100px; height: 100px;
        border: 1px solid rgba(245,158,11,.08);
        border-radius: 50%;
    }

    .hero-logo {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        object-fit: cover;
        border: 3px solid rgba(245,158,11,.4);
        flex-shrink: 0;
    }
    .hero-name {
        font-family: 'DM Sans', sans-serif;
        font-weight: 800;
        font-size: 1.75rem;
        color: #f1f5f9;
        margin: 0;
    }
    .hero-industry {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: rgba(245,158,11,.15);
        color: #f59e0b;
        font-size: .8rem;
        font-weight: 600;
        padding: .25rem .75rem;
        border-radius: 20px;
        border: 1px solid rgba(245,158,11,.25);
        margin-top: .4rem;
    }
    .hero-meta { color: #64748b; font-size: .8rem; margin-top: .25rem; }

    /* ── Stat Cards ── */
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: box-shadow .2s;
    }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(15,23,42,.08); }
    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .stat-icon.blue   { background: #eff6ff; color: #3b82f6; }
    .stat-icon.amber  { background: #fffbeb; color: #f59e0b; }
    .stat-icon.green  { background: #f0fdf4; color: #22c55e; }
    .stat-icon.purple { background: #faf5ff; color: #a855f7; }
    .stat-value { font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1; }
    .stat-label { font-size: .78rem; color: #64748b; margin-top: .15rem; }

    /* ── Tab Navigation ── */
    .profile-tabs {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
    }
    .profile-tabs .nav-tabs {
        border-bottom: 2px solid #f1f5f9;
        padding: .75rem 1.25rem 0;
        gap: .25rem;
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    .profile-tabs .nav-tabs::-webkit-scrollbar { display: none; }
    .profile-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: .6rem 1rem;
        font-size: .875rem;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
        transition: color .2s, border-color .2s;
        display: flex;
        align-items: center;
        gap: .4rem;
    }
    .profile-tabs .nav-link:hover { color: #0f172a; border-bottom-color: #e2e8f0; }
    .profile-tabs .nav-link.active {
        color: #f59e0b;
        border-bottom-color: #f59e0b;
        background: transparent;
    }
    .profile-tabs .tab-content { padding: 1.75rem; }

    /* ── Tab badge pill ── */
    .tab-badge {
        background: #f1f5f9;
        color: #64748b;
        font-size: .7rem;
        font-weight: 700;
        padding: .15rem .45rem;
        border-radius: 10px;
    }
    .nav-link.active .tab-badge {
        background: rgba(245,158,11,.15);
        color: #d97706;
    }

    /* ── Social Account chips ── */
    .social-chip {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .5rem 1rem;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        border: 1.5px solid #e2e8f0;
        text-decoration: none;
        transition: all .2s;
        color: #374151;
        background: #fff;
    }
    .social-chip:hover { border-color: #f59e0b; background: #fffbeb; color: #374151; }
    .social-chip.facebook { border-left: 3px solid #1877F2; }
    .social-chip.instagram { border-left: 3px solid #E1306C; }

    /* ── Recent Posts list ── */
    .post-row {
        display: flex;
        align-items: flex-start;
        gap: .85rem;
        padding: .85rem 0;
        border-bottom: 1px solid #f8fafc;
    }
    .post-row:last-child { border-bottom: none; }
    .post-platform-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        flex-shrink: 0;
    }
    .platform-facebook  { background: #e7f0fd; color: #1877F2; }
    .platform-instagram { background: #fce7ef; color: #E1306C; }
    .post-content-preview {
        font-size: .875rem;
        color: #374151;
        line-height: 1.45;
        /* Clamp to 2 lines */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .post-meta-row { font-size: .75rem; color: #94a3b8; margin-top: .2rem; }
    .status-badge {
        display: inline-block;
        font-size: .7rem;
        font-weight: 700;
        padding: .15rem .5rem;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .status-draft     { background: #f1f5f9; color: #64748b; }
    .status-scheduled { background: #eff6ff; color: #3b82f6; }
    .status-published { background: #f0fdf4; color: #22c55e; }
    .status-failed    { background: #fef2f2; color: #ef4444; }

    /* ── Coming Soon placeholder ── */
    .coming-soon {
        text-align: center;
        padding: 3rem 1rem;
    }
    .coming-soon .cs-icon { font-size: 3rem; margin-bottom: .75rem; opacity: .5; }
    .coming-soon h4 { font-size: 1rem; font-weight: 700; color: #374151; }
    .coming-soon p { font-size: .85rem; color: #94a3b8; max-width: 360px; margin: 0 auto; }
    .coming-soon .cs-tag {
        display: inline-block;
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #d97706;
        font-size: .72rem;
        font-weight: 700;
        padding: .2rem .65rem;
        border-radius: 20px;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    /* ── Section header inside tab ── */
    .tab-section-title {
        font-size: .75rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 1rem;
    }

    /* ── Client Notes card ── */
    .notes-card {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 1.25rem;
    }
    .notes-card p { font-size: .875rem; color: #78350f; line-height: 1.6; margin: 0; }
    .notes-card.empty p { color: #94a3b8; font-style: italic; }

    /* ── Action buttons in hero ── */
    .btn-hero-edit {
        background: rgba(245,158,11,.15);
        border: 1px solid rgba(245,158,11,.3);
        color: #f59e0b;
        border-radius: 10px;
        font-size: .85rem;
        font-weight: 600;
        padding: .5rem 1.1rem;
        text-decoration: none;
        transition: background .2s;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
    }
    .btn-hero-edit:hover { background: rgba(245,158,11,.25); color: #f59e0b; }
    .btn-hero-delete {
        background: rgba(239,68,68,.1);
        border: 1px solid rgba(239,68,68,.2);
        color: #ef4444;
        border-radius: 10px;
        font-size: .85rem;
        font-weight: 600;
        padding: .5rem 1.1rem;
        cursor: pointer;
        transition: background .2s;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
    }
    .btn-hero-delete:hover { background: rgba(239,68,68,.2); }

    /* ── Reports list ── */
    .report-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: .8rem;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        margin-bottom: .6rem;
        transition: border-color .2s;
    }
    .report-row:hover { border-color: #e2e8f0; background: #fafafa; }
    .report-icon { font-size: 1.5rem; }
    .report-period { font-size: .85rem; font-weight: 600; color: #374151; }
    .report-date   { font-size: .75rem; color: #94a3b8; }
    .btn-dl {
        margin-left: auto;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: .3rem .7rem;
        font-size: .78rem;
        font-weight: 600;
        color: #374151;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-dl:hover { background: #0f172a; color: #f59e0b; border-color: #0f172a; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ── Breadcrumb ── --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="font-size:.85rem;">
            <li class="breadcrumb-item">
                <a href="{{ route('clients.index') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-buildings me-1"></i>Clients
                </a>
            </li>
            <li class="breadcrumb-item active fw-semibold">{{ $client->name }}</li>
        </ol>
    </nav>

    {{-- ── Flash ── --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 mb-3">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════
         HERO HEADER
    ═══════════════════════════════════════════════ --}}
    <div class="client-hero">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
            {{-- Logo --}}
            <img
                src="{{ $client->logoUrl() }}"
                alt="{{ $client->name }}"
                class="hero-logo"
            >

            {{-- Name + meta --}}
            <div class="flex-grow-1">
                <h1 class="hero-name">{{ $client->name }}</h1>
                @if($client->industry)
                    <span class="hero-industry">
                        <i class="bi bi-tag-fill"></i>{{ $client->industry }}
                    </span>
                @endif
                <p class="hero-meta mt-2 mb-0">
                    <i class="bi bi-calendar3 me-1"></i>
                    Client since {{ $client->created_at->format('F Y') }}
                </p>
            </div>

            {{-- Action buttons --}}
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="{{ route('clients.edit', $client) }}" class="btn-hero-edit">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <button
                    class="btn-hero-delete"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                >
                    <i class="bi bi-trash3"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         STAT CARDS ROW
    ═══════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-share-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['social_accounts'] }}</div>
                    <div class="stat-label">Social Accounts</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon amber"><i class="bi bi-file-post-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['total_posts'] }}</div>
                    <div class="stat-label">Total Posts</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-clock-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['scheduled_posts'] }}</div>
                    <div class="stat-label">Scheduled</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['reports'] }}</div>
                    <div class="stat-label">Reports</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         TABS
    ═══════════════════════════════════════════════ --}}
    <div class="profile-tabs shadow-sm">

        {{-- Tab Nav --}}
        <ul class="nav nav-tabs" id="clientTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview" type="button">
                    <i class="bi bi-person-lines-fill"></i> Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#analytics" type="button">
                    <i class="bi bi-bar-chart-fill"></i> Analytics
                    <span class="tab-badge">Soon</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#posts" type="button">
                    <i class="bi bi-grid-3x2-gap-fill"></i> Posts
                    <span class="tab-badge">{{ $stats['total_posts'] }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inbox" type="button">
                    <i class="bi bi-chat-dots-fill"></i> Inbox
                    <span class="tab-badge">Soon</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reports" type="button">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Reports
                    <span class="tab-badge">{{ $stats['reports'] }}</span>
                </button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="clientTabsContent">

            {{-- ──────────────────────
                 TAB 1: OVERVIEW
            ────────────────────── --}}
            <div class="tab-pane fade show active" id="overview" role="tabpanel">

                <div class="row g-4">

                    {{-- Left: Notes --}}
                    <div class="col-md-6">
                        <p class="tab-section-title">
                            <i class="bi bi-sticky me-1"></i> Internal Notes
                        </p>
                        <div class="notes-card {{ !$client->notes ? 'empty' : '' }}">
                            <p>{{ $client->notes ?? 'No notes have been added for this client yet.' }}</p>
                        </div>
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-secondary rounded-3 mt-2" style="font-size:.8rem;">
                            <i class="bi bi-pencil me-1"></i>Edit Notes
                        </a>
                    </div>

                    {{-- Right: Social Accounts --}}
                    <div class="col-md-6">
                        <p class="tab-section-title">
                            <i class="bi bi-share me-1"></i> Connected Social Accounts
                        </p>

                        @if($client->socialAccounts->count())
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($client->socialAccounts as $account)
                                    <div class="social-chip {{ $account->platform }}">
                                        @if($account->platform === 'facebook')
                                            <i class="bi bi-facebook" style="color:#1877F2"></i>
                                        @else
                                            <i class="bi bi-instagram" style="color:#E1306C"></i>
                                        @endif
                                        <span>{{ $account->page_name }}</span>
                                        @if($account->token_expires_at && $account->token_expires_at < now())
                                            <span title="Token expired" style="color:#ef4444; font-size:.7rem;">
                                                <i class="bi bi-exclamation-circle-fill"></i>
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4" style="color:#94a3b8;">
                                <i class="bi bi-plug" style="font-size:2rem; opacity:.4;"></i>
                                <p class="small mt-2 mb-1">No social accounts connected yet.</p>
                                <small>Social accounts will be managed in Phase 4.</small>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ──────────────────────
                 TAB 2: ANALYTICS
            ────────────────────── --}}
            <div class="tab-pane fade" id="analytics" role="tabpanel">
                <div class="coming-soon">
                    <span class="cs-tag">Coming in Phase 4</span>
                    <div class="cs-icon">📊</div>
                    <h4>Analytics Dashboard</h4>
                    <p>Charts for followers growth, reach, impressions, and engagement rate will appear here once analytics snapshots are set up.</p>
                </div>
            </div>

            {{-- ──────────────────────
                 TAB 3: POSTS
            ────────────────────── --}}
            <div class="tab-pane fade" id="posts" role="tabpanel">

                @if($client->posts->count())
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="tab-section-title mb-0">Recent Posts</p>
                        {{-- Link to full posts list will go here in Phase 5 --}}
                        <span class="text-muted small">Showing last 5</span>
                    </div>

                    @foreach($client->posts as $post)
                        <div class="post-row">
                            {{-- Platform icon --}}
                            <div class="post-platform-icon platform-{{ $post->socialAccount->platform ?? 'facebook' }}">
                                <i class="bi bi-{{ ($post->socialAccount->platform ?? 'facebook') === 'instagram' ? 'instagram' : 'facebook' }}"></i>
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow-1 min-w-0">
                                <p class="post-content-preview">{{ $post->content }}</p>
                                <div class="post-meta-row">
                                    <span class="status-badge status-{{ $post->status }}">{{ $post->status }}</span>
                                    <span class="ms-2">
                                        @if($post->scheduled_at)
                                            📅 {{ $post->scheduled_at->format('M j, Y · H:i') }}
                                        @elseif($post->published_at)
                                            ✅ Published {{ $post->published_at->diffForHumans() }}
                                        @else
                                            Draft
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="text-center mt-3">
                        {{-- Will link to posts index filtered by client --}}
                        <span class="text-muted small">Full post management coming in Phase 5</span>
                    </div>

                @else
                    <div class="coming-soon">
                        <div class="cs-icon">📝</div>
                        <h4>No posts yet</h4>
                        <p>Posts for this client will appear here. Post scheduling is coming in Phase 5.</p>
                    </div>
                @endif
            </div>

            {{-- ──────────────────────
                 TAB 4: INBOX
            ────────────────────── --}}
            <div class="tab-pane fade" id="inbox" role="tabpanel">
                <div class="coming-soon">
                    <span class="cs-tag">Coming in Phase 6</span>
                    <div class="cs-icon">💬</div>
                    <h4>Social Inbox</h4>
                    <p>Comments and Instagram DMs for this client's accounts will be displayed and managed here.</p>
                </div>
            </div>

            {{-- ──────────────────────
                 TAB 5: REPORTS
            ────────────────────── --}}
            <div class="tab-pane fade" id="reports" role="tabpanel">

                @if($client->reports->count())
                    <p class="tab-section-title">Generated Reports</p>

                    @foreach($client->reports as $report)
                        <div class="report-row">
                            <div class="report-icon">📄</div>
                            <div>
                                <p class="report-period">
                                    {{ \Carbon\Carbon::parse($report->period_start)->format('M j') }}
                                    –
                                    {{ \Carbon\Carbon::parse($report->period_end)->format('M j, Y') }}
                                </p>
                                <p class="report-date">
                                    Generated {{ \Carbon\Carbon::parse($report->generated_at)->diffForHumans() }}
                                </p>
                            </div>
                            @if($report->file_path)
                                <a
                                    href="{{ asset('storage/' . $report->file_path) }}"
                                    target="_blank"
                                    class="btn-dl"
                                >
                                    <i class="bi bi-download me-1"></i>PDF
                                </a>
                            @endif
                        </div>
                    @endforeach

                    <div class="text-center mt-3">
                        <span class="text-muted small">Report generation coming in Phase 7</span>
                    </div>

                @else
                    <div class="coming-soon">
                        <span class="cs-tag">Coming in Phase 7</span>
                        <div class="cs-icon">📋</div>
                        <h4>No Reports Yet</h4>
                        <p>Generate PDF performance reports for this client with a single click. Coming soon.</p>
                    </div>
                @endif
            </div>

        </div>{{-- end tab-content --}}
    </div>{{-- end profile-tabs --}}

</div>

{{-- ═══════════════════════════════════════════════
     DELETE CONFIRMATION MODAL
═══════════════════════════════════════════════ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Delete Client
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-3">
                <p class="text-muted mb-1">You are about to permanently delete:</p>
                <p class="fw-bold fs-5">{{ $client->name }}</p>
                <div class="alert alert-danger border-0 rounded-3 text-start small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    All posts, reports, and social accounts linked to this client will also be deleted.
                    <strong>This cannot be undone.</strong>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('clients.destroy', $client) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3 fw-bold">
                        <i class="bi bi-trash3 me-1"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Restore the active tab after a page reload or redirect
// (so if you save and come back, you stay on the same tab)
const activeTab = localStorage.getItem('clientProfileTab_{{ $client->id }}');
if (activeTab) {
    const tabEl = document.querySelector(`[data-bs-target="${activeTab}"]`);
    if (tabEl) new bootstrap.Tab(tabEl).show();
}

document.querySelectorAll('#clientTabs [data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', e => {
        localStorage.setItem(
            'clientProfileTab_{{ $client->id }}',
            e.target.getAttribute('data-bs-target')
        );
    });
});
</script>
@endpush
