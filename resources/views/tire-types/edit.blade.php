@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Edit Tire Type') }}</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('tire-types.update', $tireType) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name_en" class="form-label">{{ __('English Name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $tireType->name_en) }}" required>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name_ar" class="form-label">{{ __('Arabic Name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar', $tireType->name_ar) }}" required>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $tireType->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex">
                    <button type="submit" class="btn btn-primary me-2">{{ __('Update Tire Type') }}</button>
                    <a href="{{ route('tire-types.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
