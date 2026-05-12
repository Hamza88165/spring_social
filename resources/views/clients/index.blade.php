{{-- resources/views/clients/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Clients')

@push('styles')
<style>
    /* ── Page header ── */
    .page-header {
        background: linear-gradient(135deg, #2E75B6 0%, #1B2B4B 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.75rem;
        border: 1px solid #1B2B4B;
    }
    .page-header h1 {
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: #f1f5f9;
        margin: 0;
    }
    .page-header p {
        color: #94a3b8;
        margin: .25rem 0 0;
        font-size: .9rem;
    }

    /* ── Search / filter bar ── */
    .filter-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }
    .filter-bar .form-control,
    .filter-bar .form-select {
        border-radius: 8px;
        border-color: #e2e8f0;
        font-size: .875rem;
    }
    .filter-bar .form-control:focus,
    .filter-bar .form-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245,158,11,.12);
    }
    .btn-search {
        background: #1B2B4B;
        color: #f59e0b;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: .5rem 1.25rem;
        transition: background .2s;
    }
    .btn-search:hover { background: #1B2B4B; color: #f59e0b; }
    .btn-reset {
        border-radius: 8px;
        border-color: #e2e8f0;
        font-size: .875rem;
        color: #64748b;
    }
    .btn-reset:hover { background: #f8fafc; }

    /* ── Client cards ── */
    .client-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s;
        height: 100%;
    }
    .client-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(15,23,42,.1);
        border-color: #f59e0b;
    }
    .client-card-header {
                background: linear-gradient(135deg, #2E75B6, #1B2B4B);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .client-logo {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid rgba(245,158,11,.4);
        flex-shrink: 0;
        background: #0f172a;
    }
    .client-card-header .client-name {
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: #f1f5f9;
        margin: 0;
        line-height: 1.3;
    }
    .client-card-body { padding: 1.1rem 1.25rem; }

    .industry-badge {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        font-size: .75rem;
        font-weight: 600;
        padding: .25rem .7rem;
        border-radius: 20px;
        margin-bottom: .75rem;
        letter-spacing: .03em;
    }
    .client-notes {
        font-size: .825rem;
        color: #64748b;
        line-height: 1.5;
        /* Clamp to 2 lines */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.4em;
    }
    .client-meta {
        display: flex;
        gap: .5rem;
        margin-top: .85rem;
        flex-wrap: wrap;
    }
    .meta-pill {
        font-size: .75rem;
        font-weight: 600;
        color: #64748b;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: .2rem .55rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }
    .meta-pill i { font-size: .7rem; }

    .client-card-footer {
        padding: .85rem 1.25rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: .5rem;
    }
    .btn-view {
        flex: 1;
        background: #1B2B4B;
        color: #f59e0b;
        border: none;
        border-radius: 8px;
        font-size: .825rem;
        font-weight: 600;
        padding: .45rem .75rem;
        text-align: center;
        text-decoration: none;
        transition: background .2s;
    }
    .btn-view:hover { background: #1e293b; color: #f59e0b; }
    .btn-icon {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        font-size: .875rem;
        transition: all .2s;
        flex-shrink: 0;
    }
    .btn-icon:hover { background: #fef3c7; border-color: #f59e0b; color: #d97706; }
    .btn-icon.danger:hover { background: #fee2e2; border-color: #f87171; color: #dc2626; }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
    }
    .empty-state .empty-icon {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: .4;
    }
    .empty-state h3 { font-size: 1.1rem; color: #475569; font-weight: 600; margin-bottom: .4rem; }
    .empty-state p { font-size: .875rem; }

    /* ── Add button ── */
    .btn-add-client {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #f1f5f9;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        padding: .6rem 1.4rem;
        font-size: .9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        transition: opacity .2s, transform .15s;
    }
    .btn-add-client:hover { opacity: .9; transform: translateY(-1px); color: #0f172a; }

    /* ── Results count ── */
    .results-info { font-size: .85rem; color: #64748b; }

    /* ── Delete modal ── */
    .modal-header { border-bottom: 1px solid #f1f5f9; }
    .modal-footer { border-top: 1px solid #f1f5f9; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ── Page Header ── --}}
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h1><i class="bi bi-buildings me-2" style="color:#f59e0b"></i>Clients</h1>
            <p>Manage all your agency clients and their social presence</p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn-add-client">
            <i class="bi bi-plus-lg"></i> Add New Client
        </a>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── Search + Filter Bar ── --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('clients.index') }}" class="row g-2 align-items-center">
            {{-- Search box --}}
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        class="form-control border-start-0 ps-0"
                        placeholder="Search clients by name..."
                        value="{{ $search ?? '' }}"
                        style="border-radius: 0 8px 8px 0;"
                    >
                </div>
            </div>

            {{-- Industry filter --}}
            <div class="col-md-4">
                <select name="industry" class="form-select">
                    <option value="">All Industries</option>
                    @foreach($industries as $ind)
                        <option value="{{ $ind }}" {{ ($industry ?? '') === $ind ? 'selected' : '' }}>
                            {{ $ind }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-search flex-grow-1">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if($search || $industry)
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-reset">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Results Info ── --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="results-info mb-0">
            Showing <strong>{{ $clients->firstItem() ?? 0 }}–{{ $clients->lastItem() ?? 0 }}</strong>
            of <strong>{{ $clients->total() }}</strong> client{{ $clients->total() !== 1 ? 's' : '' }}
            @if($search || $industry)
                <span class="text-warning">— filtered</span>
            @endif
        </p>
    </div>

    {{-- ── Client Cards Grid ── --}}
    @if($clients->count())
        <div class="row g-4">
            @foreach($clients as $client)
            <div class="col-sm-6 col-xl-4">
                <div class="client-card">

                    {{-- Card Header: logo + name --}}
                    <div class="client-card-header">
                        <img
                            src="{{ $client->logoUrl() }}"
                            alt="{{ $client->name }}"
                            class="client-logo"
                        >
                        <div class="overflow-hidden">
                            <h5 class="client-name text-truncate">{{ $client->name }}</h5>
                            <small style="color:#94a3b8; font-size:.78rem;">
                                Added {{ $client->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    {{-- Card Body: industry + notes + stats --}}
                    <div class="client-card-body">
                        @if($client->industry)
                            <span class="industry-badge">
                                <i class="bi bi-tag me-1"></i>{{ $client->industry }}
                            </span>
                        @endif

                        <p class="client-notes">
                            {{ $client->notes ?? 'No notes added yet.' }}
                        </p>

                        <div class="client-meta">
                            <span class="meta-pill">
                                <i class="bi bi-share-fill"></i>
                                {{ $client->social_accounts_count }}
                                account{{ $client->social_accounts_count !== 1 ? 's' : '' }}
                            </span>
                            <span class="meta-pill">
                                <i class="bi bi-file-post"></i>
                                {{ $client->posts_count }}
                                post{{ $client->posts_count !== 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Footer: action buttons --}}
                    <div class="client-card-footer">
                        <a href="{{ route('clients.show', $client) }}" class="btn-view">
                            <i class="bi bi-eye me-1"></i> View Profile
                        </a>
                        <a href="{{ route('clients.edit', $client) }}" class="btn-icon" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button
                            class="btn-icon danger"
                            title="Delete"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-client-id="{{ $client->id }}"
                            data-client-name="{{ $client->name }}"
                        >
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        {{-- ── Pagination ── --}}
        @if($clients->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $clients->links() }}
            </div>
        @endif

    @else
        {{-- ── Empty State ── --}}
        <div class="empty-state">
            <div class="empty-icon">🏢</div>
            <h3>No clients found</h3>
            @if($search || $industry)
                <p>No clients match your search. <a href="{{ route('clients.index') }}">Clear filters</a></p>
            @else
                <p>Get started by adding your first client.</p>
                <a href="{{ route('clients.create') }}" class="btn-add-client mt-3">
                    <i class="bi bi-plus-lg"></i> Add First Client
                </a>
            @endif
        </div>
    @endif

</div>

{{-- ════════════════════════════════════════
     DELETE CONFIRMATION MODAL
     ════════════════════════════════════════ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Delete Client
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-1 text-muted">You are about to permanently delete:</p>
                <p class="fw-bold fs-5 mb-3" id="modalClientName"></p>
                <div class="alert alert-danger border-0 rounded-3 text-start small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    This will also delete all associated posts, reports, and social accounts.
                    <strong>This action cannot be undone.</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" action="">
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
// Wire up the delete modal with the correct client name and form action
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
    // The button that triggered the modal
    const button = event.relatedTarget;

    // Read data attributes from the button
    const clientId   = button.getAttribute('data-client-id');
    const clientName = button.getAttribute('data-client-name');

    // Update the modal
    document.getElementById('modalClientName').textContent = clientName;
    document.getElementById('deleteForm').action = `/clients/${clientId}`;
});
</script>
@endpush
