@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Observation Details</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="form-group mb-4">
                        <label for="name_ar">Name (Arabic):</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" value="{{ $observation->name_ar }}"
                            readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label for="name_en">Name (English):</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ $observation->name_en }}"
                            readonly>
                    </div>

                    <div class="form-group mb-4">
                        <a href="{{ route('observations.index') }}" class="btn btn-secondary">Back to Observations</a>
                        <a href="{{ route('observations.edit', $observation->id) }}" class="btn btn-primary">Edit Observation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
