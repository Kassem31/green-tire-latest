@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Repair Step Details</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="form-group mb-4">
                        <label for="id">ID:</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $repairStep->id }}"
                            readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label for="name_ar">Name (Arabic):</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" value="{{ $repairStep->name_ar }}"
                            readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label for="name_en">Name (English):</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ $repairStep->name_en }}"
                            readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label for="created_by">Created By:</label>
                        <input type="text" class="form-control" id="created_by" name="created_by"
                            value="{{ $repairStep->creator ? $repairStep->creator->name : 'N/A' }}" readonly>
                    </div>

                    <div class="form-group mb-4">
                        <label for="updated_by">Updated By:</label>
                        <input type="text" class="form-control" id="updated_by" name="updated_by"
                            value="{{ $repairStep->updater ? $repairStep->updater->name : 'N/A' }}" readonly>
                    </div>

                    <div class="form-group mb-4">
                        <a href="{{ route('repair-steps.index') }}" class="btn btn-secondary">Back to Repair Steps</a>
                        <a href="{{ route('repair-steps.edit', $repairStep->id) }}" class="btn btn-primary">Edit Repair Step</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
