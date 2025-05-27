@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Edit Observation</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <form action="{{ route('observations.update', $observation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="name_ar">Name (Arabic):</label>
                            <input type="text" class="form-control" id="name_ar" name="name_ar"
                                value="{{ $observation->name_ar }}">
                            @error('name_ar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="name_en">Name (English):</label>
                            <input type="text" class="form-control" id="name_en" name="name_en"
                                value="{{ $observation->name_en }}">
                            @error('name_en')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <a href="{{ route('observations.index') }}" class="btn btn-secondary">Back to Observations</a>
                            <button type="submit" class="btn btn-primary">Update Observation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
