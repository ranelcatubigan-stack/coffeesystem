@extends('layouts.app')

@section('title', isset($menuItem) ? 'Edit Menu Item' : 'New Menu Item')

@push('styles')
<style>
    .form-page {
        max-width: 680px;
        margin: 0 auto;
        padding: 3rem 3rem 5rem;
    }

    .page-header {
        margin-bottom: 2.5rem;
        opacity: 0;
        animation: fade-up 0.7s 0.1s forwards;
    }
    .page-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--caramel);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .page-eyebrow::before {
        content: '';
        display: block;
        width: 28px; height: 1px;
        background: var(--caramel);
    }
    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 3.5vw, 2.8rem);
        font-weight: 300;
        color: var(--oat);
    }
    .page-title em { font-style: italic; font-weight: 600; color: var(--caramel); }

    /* ── Form card ── */
    .form-card {
        background: rgba(242,234,216,0.03);
        border: 1px solid rgba(242,234,216,0.09);
        border-radius: 20px;
        padding: 2rem 2.2rem;
        opacity: 0;
        animation: fade-up 0.7s 0.2s forwards;
    }

    .form-group { margin-bottom: 1.5rem; }

    .form-label {
        display: block;
        font-size: 0.72rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(242,234,216,0.5);
        margin-bottom: 0.5rem;
    }

    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        background: rgba(242,234,216,0.05);
        border: 1px solid rgba(242,234,216,0.12);
        border-radius: 10px;
        padding: 0.85rem 1.1rem;
        color: var(--oat);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 300;
        transition: border-color 0.2s, background 0.2s;
        outline: none;
    }
    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        border-color: rgba(181,118,42,0.5);
        background: rgba(242,234,216,0.07);
    }
    .form-input::placeholder,
    .form-textarea::placeholder { color: rgba(242,234,216,0.25); }

    .form-textarea { resize: vertical; min-height: 100px; }

    .form-select option { background: var(--roast); }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* Image preview */
    .img-upload-wrap {
        border: 1px dashed rgba(242,234,216,0.18);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        position: relative;
    }
    .img-upload-wrap:hover {
        border-color: rgba(181,118,42,0.4);
        background: rgba(181,118,42,0.04);
    }
    .img-upload-wrap input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .img-upload-icon { font-size: 1.8rem; margin-bottom: 0.5rem; opacity: 0.5; }
    .img-upload-label {
        font-size: 0.8rem;
        color: rgba(242,234,216,0.35);
    }
    .img-preview {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 0.75rem;
        display: none;
    }

    /* Validation errors */
    .form-error {
        font-size: 0.78rem;
        color: #e07070;
        margin-top: 0.35rem;
    }

    /* Divider */
    .form-divider {
        height: 1px;
        background: rgba(242,234,216,0.07);
        margin: 1.5rem 0;
    }

    /* Actions */
    .form-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        margin-top: 2rem;
    }

    @media (max-width: 600px) {
        .form-page { padding: 2rem 1.5rem 4rem; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="form-page">
    <div class="page-header">
        <p class="page-eyebrow">Menu Management</p>
        <h1 class="page-title">
            @isset($menuItem) <em>Edit</em> Item @else Add <em>New</em> Item @endisset
        </h1>
    </div>

    <div class="form-card">
        <form
            action="{{ isset($menuItem) ? route('staff.menu.update', $menuItem->id) : route('staff.menu.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @isset($menuItem) @method('PATCH') @endisset

            {{-- Name --}}
            <div class="form-group">
                <label class="form-label" for="name">Item Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-input"
                    placeholder="e.g. Caramel Macchiato"
                    value="{{ old('name', $menuItem->name ?? '') }}"
                    required
                >
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-textarea"
                    placeholder="Brief, appetising description..."
                >{{ old('description', $menuItem->description ?? '') }}</textarea>
                @error('description') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Price + Category --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="price">Price (₱)</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="form-input"
                        placeholder="0.00"
                        step="0.01"
                        min="0"
                        value="{{ old('price', $menuItem->price ?? '') }}"
                        required
                    >
                    @error('price') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="category">Category</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">— Select —</option>
                        @foreach(['Hot Coffee', 'Cold Brew', 'Espresso', 'Pastries', 'Seasonal', 'Non-Coffee'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $menuItem->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-divider"></div>

            {{-- Image Upload --}}
            <div class="form-group">
                <label class="form-label">Item Image</label>
                <div class="img-upload-wrap" onclick="">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)">
                    <div class="img-upload-icon">📷</div>
                    <p class="img-upload-label">Click to upload or drag & drop<br><span style="font-size:0.72rem;opacity:0.6;">JPG, PNG — max 2MB</span></p>
                    <img id="img-preview" class="img-preview"
                        @isset($menuItem) @if($menuItem->image) src="{{ asset('storage/' . $menuItem->image) }}" style="display:block;" @endif @endisset
                        alt="Preview">
                </div>
                @error('image') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Availability toggle --}}
            <div class="form-group" style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <label class="form-label" style="margin-bottom:0.2rem;">Availability</label>
                    <p style="font-size:0.78rem;color:rgba(242,234,216,0.35);">Show this item on the menu</p>
                </div>
                <label style="position:relative;display:inline-block;width:44px;height:24px;cursor:pointer;">
                    <input type="checkbox" name="is_available" value="1"
                        {{ old('is_available', $menuItem->is_available ?? true) ? 'checked' : '' }}
                        style="opacity:0;width:0;height:0;">
                    <span style="position:absolute;inset:0;background:rgba(242,234,216,0.1);border:1px solid rgba(242,234,216,0.2);border-radius:999px;transition:0.2s;" id="toggle-track"></span>
                    <span style="position:absolute;left:3px;top:3px;width:16px;height:16px;border-radius:50%;background:rgba(242,234,216,0.4);transition:0.2s;" id="toggle-thumb"></span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    {{ isset($menuItem) ? 'Save Changes' : 'Add to Menu' }}
                </button>
                <a href="{{ route('staff.dashboard') }}" class="btn-outline">Cancel</a>
                @isset($menuItem)
                    <form action="{{ route('staff.menu.destroy', $menuItem->id) }}" method="POST"
                          style="margin-left:auto;"
                          onsubmit="return confirm('Delete this item permanently?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger">Delete</button>
                    </form>
                @endisset
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('img-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle switch styling
    const checkbox = document.querySelector('input[name="is_available"]');
    const track = document.getElementById('toggle-track');
    const thumb = document.getElementById('toggle-thumb');
    function updateToggle() {
        if (checkbox.checked) {
            track.style.background = 'rgba(181,118,42,0.4)';
            track.style.borderColor = 'rgba(181,118,42,0.6)';
            thumb.style.background = 'var(--caramel)';
            thumb.style.transform = 'translateX(20px)';
        } else {
            track.style.background = 'rgba(242,234,216,0.1)';
            track.style.borderColor = 'rgba(242,234,216,0.2)';
            thumb.style.background = 'rgba(242,234,216,0.4)';
            thumb.style.transform = 'translateX(0)';
        }
    }
    checkbox.addEventListener('change', updateToggle);
    updateToggle();
</script>
@endpush