@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>{{ __('Tire Types') }}</h1>
            <a href="{{ route('tire-types.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> {{ __('Create New Tire Type') }}
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('English Name') }}</th>
                            <th class="mobile-hidden">{{ __('Arabic Name') }}</th>
                            <th class="mobile-hidden">{{ __('Description') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tireTypes as $tireType)
                            @if(!$tireType->deleted_at)
                                <tr>
                                    <td>{{ $tireType->id }}</td>
                                    <td>{{ $tireType->name_en }}</td>
                                    <td class="mobile-hidden">{{ $tireType->name_ar }}</td>
                                    <td class="mobile-hidden">{{ $tireType->description }}</td>
                                    <td class="d-flex flex-wrap gap-1">
                                        <a href="{{ route('tire-types.edit', $tireType) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i> <span class="mobile-hidden">{{ __('Edit') }}</span>
                                        </a>
                                        <form action="{{ route('tire-types.destroy', $tireType) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tire type?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> <span class="mobile-hidden">{{ __('Delete') }}</span>
                                            </button>
                                        </form>
                                        <div class="mobile-only w-100 mt-1">
                                            <small>
                                                <strong>{{ __('Arabic:') }}</strong> {{ $tireType->name_ar }}<br>
                                                <strong>{{ __('Desc:') }}</strong> {{ Str::limit($tireType->description, 50) }}
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
