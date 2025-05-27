@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Pending Transactions') }}</h5>
                    <div>
                        <a href="{{ route('inspection-transactions.index') }}" class="btn btn-secondary btn-sm me-2">{{ __('All Transactions') }}</a>
                        <a href="{{ route('inspection-transactions.create') }}" class="btn btn-primary btn-sm">{{ __('Create New') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Barcode') }}</th>
                                    <th>{{ __('Tire Type') }}</th>
                                    <th>{{ __('Building Date') }}</th>
                                    <th>{{ __('Machine') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingTransactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->barcode }}</td>
                                        <td>{{ $transaction->tireType->name_en }}</td>
                                        <td>{{ $transaction->building_date ? $transaction->building_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $transaction->machine ?? 'N/A' }}</td>
                                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('inspection-transactions.show', $transaction) }}" class="btn btn-info btn-sm">{{ __('View') }}</a>
                                                <a href="{{ route('inspection-transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No pending transactions found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
