{{-- resources/views/clients/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit ' . $client->name)

@push('styles')
<style>
    /* Reuses same style patterns as create.blade.php */
    .form-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        max-width: 720px;
        margin: 0 auto;
    }
    .form-card-header {
        background: linear-gradient(135deg, #2E75B6 0%, #1B2B4B 100%);
        padding: 1.75rem 2rem;
    }
    .form-card-header h2 {
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        color: #f1f5f9;
        margin: 0;
        font-size: 1.3rem;
    }
    .form-card-header p { color: #94a3b8; margin: .2rem 0 0; font-size: .85rem; }
    .form-card-body { padding: 2rem; }
    .form-label { font-weight: 600; font-size: .85rem; color: #374151; margin-bottom: .4rem; }
    .form-control, .form-select {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        font-size: .9rem;
        padding: .6rem .9rem;
        transition: border-color .2s, box-shadow .2s;
        background: #fafafa;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245,158,11,.12);
        background: #fff;
    }
    .form-control.is-invalid { border-color: #f87171; background-image: none; }
    .invalid-feedback { font-size: .8rem; }
    .form-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.5rem 0; }
    .section-title {
        font-size: .75rem; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: .08em; margin-bottom: 1rem;
    }
    .btn-submit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #0f172a; border: none; border-radius: 10px;
        font-weight: 700; padding: .65rem 1.75rem; font-size: .9rem;
        transition: opacity .2s, transform .15s;
    }
    .btn-submit:hover { opacity: .9; transform: translateY(-1px); }
    .btn-cancel { border-radius: 10px; border: 1.5px solid #e2e8f0; color: #64748b; font-size: .9rem; padding: .65rem 1.5rem; }
    .btn-cancel:hover { background: #f8fafc; }

    /* ── Current logo display ── */
    .current-logo-box {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
    }
    .current-logo-img {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        flex-shrink: 0;
    }
    .current-logo-label { font-size: .8rem; color: #94a3b8; margin-bottom: .2rem; }
    .current-logo-name { font-size: .9rem; color: #374151; font-weight: 600; }

    /* ── Upload zone ── */
    .logo-upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: #fafafa;
        position: relative;
    }
    .logo-upload-zone:hover {
        border-color: #f59e0b;
        background: #fffbeb;
    }
    .logo-upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .upload-text { font-size: .85rem; color: #64748b; margin: .35rem 0 0; }
    .upload-hint { font-size: .75rem; color: #94a3b8; margin: .2rem 0 0; }
    #newPreviewBox {
        margin-top: .75rem;
        display: none;
        align-items: center;
        gap: 1rem;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 10px;
        padding: .75rem 1rem;
    }
    #newPreview { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; }
    .btn-remove-preview { background: none; border: none; color: #f87171; font-size: 1.1rem; cursor: pointer; margin-left: auto; }
    .btn-remove-preview:hover { color: #dc2626; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="font-size:.85rem;">
            <li class="breadcrumb-item">
                <a href="{{ route('clients.index') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-buildings me-1"></i>Clients
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('clients.show', $client) }}" class="text-decoration-none text-muted">
                    {{ $client->name }}
                </a>
            </li>
            <li class="breadcrumb-item active fw-semibold">Edit</li>
        </ol>
    </nav>

    <div class="form-card shadow-sm">

        <div class="form-card-header">
            <h2>
                <i class="bi bi-pencil-square me-2" style="color:#f59e0b"></i>
                Edit Client
            </h2>
            <p>Update the information for <strong style="color:#f1f5f9">{{ $client->name }}</strong></p>
        </div>

        <div class="form-card-body">

            {{-- PUT method: browsers only support GET/POST natively,
                 so we use the @method directive to fake PUT --}}
            <form
                action="{{ route('clients.update', $client) }}"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                @csrf
                @method('PUT')

                {{-- ── Basic Info ── --}}
                <p class="section-title">Basic Information</p>

                <div class="mb-4">
                    <label for="name" class="form-label">
                        Client Name <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $client->name) }}"
                        required
                        autofocus
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="industry" class="form-label">Industry</label>
                    <select
                        id="industry"
                        name="industry"
                        class="form-select @error('industry') is-invalid @enderror"
                    >
                        <option value="">— Select an industry —</option>
                        @foreach($industries as $ind)
                            <option
                                value="{{ $ind }}"
                                {{ old('industry', $client->industry) === $ind ? 'selected' : '' }}
                            >
                                {{ $ind }}
                            </option>
                        @endforeach
                    </select>
                    @error('industry')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="form-divider">

                {{-- ── Logo ── --}}
                <p class="section-title">Logo / Brand Image</p>

                {{-- Show current logo if exists --}}
                @if($client->logo)
                    <div class="current-logo-box">
                        <img
                            src="{{ $client->logoUrl() }}"
                            alt="Current logo"
                            class="current-logo-img"
                        >
                        <div>
                            <p class="current-logo-label">Current logo</p>
                            <p class="current-logo-name">{{ basename($client->logo) }}</p>
                        </div>
                    </div>

                    {{-- Remove logo checkbox --}}
                    <div class="form-check mb-3">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="remove_logo"
                            id="remove_logo"
                            value="1"
                        >
                        <label class="form-check-label text-muted small" for="remove_logo">
                            Remove current logo (will use initials instead)
                        </label>
                    </div>
                @endif

                {{-- Upload new logo --}}
                <div class="mb-4">
                    <label class="form-label">
                        {{ $client->logo ? 'Replace with new logo' : 'Upload Logo' }}
                    </label>
                    <div class="logo-upload-zone">
                        <input
                            type="file"
                            id="logo"
                            name="logo"
                            accept="image/*"
                        >
                        <div style="font-size:1.5rem">📷</div>
                        <p class="upload-text">Click to upload a new image</p>
                        <p class="upload-hint">PNG, JPG, WEBP — max 2MB</p>
                    </div>

                    {{-- New image preview --}}
                    <div id="newPreviewBox" style="display:none;">
                        <img id="newPreview" src="" alt="New logo preview">
                        <div>
                            <p class="preview-name mb-0 small fw-semibold" id="newPreviewName"></p>
                            <p class="preview-size mb-0" style="font-size:.75rem;color:#94a3b8" id="newPreviewSize"></p>
                        </div>
                        <button type="button" class="btn-remove-preview" id="removeNewPreview">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>

                    @error('logo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="form-divider">

                {{-- ── Notes ── --}}
                <p class="section-title">Internal Notes</p>

                <div class="mb-4">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        class="form-control @error('notes') is-invalid @enderror"
                        rows="4"
                        placeholder="Anything useful for the team..."
                    >{{ old('notes', $client->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ── Buttons ── --}}
                <div class="d-flex gap-2 justify-content-between pt-2">
                    <a href="{{ route('clients.show', $client) }}" class="btn btn-light btn-cancel">
                        <i class="bi bi-arrow-left me-1"></i> Back to Profile
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const logoInput    = document.getElementById('logo');
const newPreviewBox  = document.getElementById('newPreviewBox');
const newPreviewImg  = document.getElementById('newPreview');
const newPreviewName = document.getElementById('newPreviewName');
const newPreviewSize = document.getElementById('newPreviewSize');
const removeBtn      = document.getElementById('removeNewPreview');

logoInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        newPreviewImg.src  = e.target.result;
        newPreviewName.textContent = file.name;
        newPreviewSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
        newPreviewBox.style.display = 'flex';
    };
    reader.readAsDataURL(file);
});

if (removeBtn) {
    removeBtn.addEventListener('click', () => {
        logoInput.value = '';
        newPreviewBox.style.display = 'none';
    });
}
</script>
@endpush
