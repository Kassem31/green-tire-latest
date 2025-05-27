@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Inspection Transaction Details') }}</h5>
                    <div>
                        <a href="{{ route('inspection-transactions.edit', $inspectionTransaction) }}" class="btn btn-primary btn-sm">{{ __('Edit') }}</a>
                        <a href="{{ route('inspection-transactions.index') }}" class="btn btn-secondary btn-sm">{{ __('Back to List') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">{{ __('ID') }}</th>
                                <td>{{ $inspectionTransaction->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Barcode') }}</th>
                                <td>{{ $inspectionTransaction->barcode }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Tire Type') }}</th>
                                <td>{{ $inspectionTransaction->tireType->name_en }} ({{ $inspectionTransaction->tireType->name_ar }})</td>
                            </tr>
                            <tr>
                                <th>{{ __('Decision') }}</th>
                                <td>{{ $inspectionTransaction->decision }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Is Repaired') }}</th>
                                <td>{{ $inspectionTransaction->is_repaired ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Building Date') }}</th>
                                <td>{{ $inspectionTransaction->building_date ? $inspectionTransaction->building_date->format('Y-m-d') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Machine') }}</th>
                                <td>{{ $inspectionTransaction->machine ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Operator Name') }}</th>
                                <td>{{ $inspectionTransaction->operator_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Operator Code') }}</th>
                                <td>{{ $inspectionTransaction->operator_code ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Created At') }}</th>
                                <td>{{ $inspectionTransaction->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Updated At') }}</th>
                                <td>{{ $inspectionTransaction->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mt-4 mb-3">{{ __('Observations') }}</h5>
                    @if($inspectionTransaction->observations->count() > 0)
                        <ul class="list-group">
                            @foreach($inspectionTransaction->observations as $observation)
                                <li class="list-group-item">{{ $observation->name_en }} ({{ $observation->name_ar }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ __('No observations recorded.') }}</p>
                    @endif

                    @if($inspectionTransaction->repairTransaction)
                        <h5 class="mt-4 mb-3">{{ __('Repair Information') }}</h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">{{ __('Repair ID') }}</th>
                                    <td>{{ $inspectionTransaction->repairTransaction->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Repair Decision') }}</th>
                                    <td>{{ $inspectionTransaction->repairTransaction->decision }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Repair Date') }}</th>
                                    <td>{{ $inspectionTransaction->repairTransaction->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
