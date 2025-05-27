@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>{{ __('Tire Type Details') }}</h2>
            <div>
                <a href="{{ route('tire-types.edit', $tireType) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                </a>
                <a href="{{ route('tire-types.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th style="width: 200px;">{{ __('ID') }}</th>
                        <td>{{ $tireType->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('English Name') }}</th>
                        <td>{{ $tireType->name_en }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Arabic Name') }}</th>
                        <td>{{ $tireType->name_ar }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Description') }}</th>
                        <td>{{ $tireType->description ?: 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Created At') }}</th>
                        <td>{{ $tireType->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Last Updated') }}</th>
                        <td>{{ $tireType->updated_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
