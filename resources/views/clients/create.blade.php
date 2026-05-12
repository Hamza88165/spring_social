{{-- resources/views/clients/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add New Client')

@push('styles')
<style>
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
        border-bottom: 1px solid #334155;
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

    .form-label {
        font-weight: 600;
        font-size: .85rem;
        color: #374151;
        margin-bottom: .4rem;
        letter-spacing: .02em;
    }
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
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #f87171;
        background-image: none;
    }
    .invalid-feedback { font-size: .8rem; }

    /* ── Logo Upload Zone ── */
    .logo-upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: #fafafa;
        position: relative;
    }
    .logo-upload-zone:hover, .logo-upload-zone.dragover {
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
    .upload-icon { font-size: 2rem; color: #94a3b8; margin-bottom: .5rem; }
    .upload-text { font-size: .85rem; color: #64748b; margin: 0; }
    .upload-hint { font-size: .75rem; color: #94a3b8; margin-top: .25rem; }

    /* Preview box shown after picking a file */
    #logoPreviewBox {
        display: none;
        margin-top: 1rem;
        align-items: center;
        gap: 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: .75rem 1rem;
    }
    #logoPreview {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid #e2e8f0;
    }
    .preview-name { font-size: .85rem; color: #374151; font-weight: 500; }
    .preview-size { font-size: .75rem; color: #94a3b8; }
    .btn-remove-preview {
        background: none;
        border: none;
        color: #f87171;
        font-size: 1.1rem;
        cursor: pointer;
        margin-left: auto;
        transition: color .2s;
    }
    .btn-remove-preview:hover { color: #dc2626; }

    /* ── Divider ── */
    .form-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 1.5rem 0;
    }

    /* ── Action Buttons ── */
    .btn-submit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #0f172a;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        padding: .65rem 1.75rem;
        font-size: .9rem;
        transition: opacity .2s, transform .15s;
    }
    .btn-submit:hover { opacity: .9; transform: translateY(-1px); }
    .btn-cancel {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        font-size: .9rem;
        padding: .65rem 1.5rem;
    }
    .btn-cancel:hover { background: #f8fafc; }

    .section-title {
        font-size: .75rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 1rem;
    }
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
            <li class="breadcrumb-item active text-dark fw-semibold">Add New Client</li>
        </ol>
    </nav>

    <div class="form-card shadow-sm">

        {{-- Header --}}
        <div class="form-card-header">
            <h2><i class="bi bi-person-plus-fill me-2" style="color:#f59e0b"></i>Add New Client</h2>
            <p>Fill in the details below to create a new client profile</p>
        </div>

        {{-- Form --}}
        <div class="form-card-body">
            <form
                action="{{ route('clients.store') }}"
                method="POST"
                enctype="multipart/form-data"
                {{-- enctype is REQUIRED for file uploads --}}
                novalidate
            >
                @csrf

                {{-- ── Section: Basic Info ── --}}
                <p class="section-title">Basic Information</p>

                {{-- Client Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label">
                        Client Name <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="e.g. Café Maroc, Immo Atlas..."
                        autofocus
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Industry --}}
                <div class="mb-4">
                    <label for="industry" class="form-label">Industry</label>
                    <select
                        id="industry"
                        name="industry"
                        class="form-select @error('industry') is-invalid @enderror"
                    >
                        <option value="">— Select an industry —</option>
                        @foreach($industries as $ind)
                            <option value="{{ $ind }}" {{ old('industry') === $ind ? 'selected' : '' }}>
                                {{ $ind }}
                            </option>
                        @endforeach
                    </select>
                    @error('industry')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="form-divider">

                {{-- ── Section: Logo ── --}}
                <p class="section-title">Logo / Brand Image</p>

                <div class="mb-4">
                    <label class="form-label">Client Logo</label>

                    {{-- Drop zone --}}
                    <div class="logo-upload-zone" id="uploadZone">
                        <input
                            type="file"
                            id="logo"
                            name="logo"
                            accept="image/*"
                            class="@error('logo') is-invalid @enderror"
                        >
                        <div class="upload-icon">📷</div>
                        <p class="upload-text">Click to upload or drag & drop</p>
                        <p class="upload-hint">PNG, JPG, WEBP — max 2MB</p>
                    </div>

                    {{-- Preview (hidden until a file is chosen) --}}
                    <div id="logoPreviewBox" style="display:none;">
                        <img id="logoPreview" src="" alt="Preview">
                        <div>
                            <p class="preview-name mb-0" id="previewName"></p>
                            <p class="preview-size mb-0" id="previewSize"></p>
                        </div>
                        <button type="button" class="btn-remove-preview" id="removePreview" title="Remove">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>

                    @error('logo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text">If no logo is uploaded, initials will be used automatically.</div>
                </div>

                <hr class="form-divider">

                {{-- ── Section: Notes ── --}}
                <p class="section-title">Internal Notes</p>

                <div class="mb-4">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        class="form-control @error('notes') is-invalid @enderror"
                        rows="4"
                        placeholder="Anything useful for the team: contact person, posting preferences, special instructions..."
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ── Action Buttons ── --}}
                <div class="d-flex gap-2 justify-content-end pt-2">
                    <a href="{{ route('clients.index') }}" class="btn btn-light btn-cancel">
                        Cancel
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-lg me-1"></i> Save Client
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ── Logo upload preview ──────────────────────────────────────────────
const fileInput   = document.getElementById('logo');
const uploadZone  = document.getElementById('uploadZone');
const previewBox  = document.getElementById('logoPreviewBox');
const previewImg  = document.getElementById('logoPreview');
const previewName = document.getElementById('previewName');
const previewSize = document.getElementById('previewSize');
const removeBtn   = document.getElementById('removePreview');

// When user picks a file
fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    showPreview(file);
});

// When user clicks "Remove"
removeBtn.addEventListener('click', function () {
    fileInput.value = '';        // Clear the file input
    previewBox.style.display = 'none';
    uploadZone.style.display  = 'block';
});

function showPreview(file) {
    // Show a thumbnail
    const reader = new FileReader();
    reader.onload = e => {
        previewImg.src = e.target.result;
        previewName.textContent = file.name;
        previewSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
        previewBox.style.display  = 'flex';
        uploadZone.style.display  = 'none';
    };
    reader.readAsDataURL(file);
}

// ── Drag & Drop highlighting ─────────────────────────────────────────
uploadZone.addEventListener('dragover', e => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    // The browser will set fileInput.files via the native drop on the hidden input,
    // but we also manually trigger change if needed:
    const file = e.dataTransfer.files[0];
    if (file) showPreview(file);
});
</script>
@endpush
