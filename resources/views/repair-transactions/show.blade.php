@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Repair Transaction Details</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('repair-transactions.edit', $repairTransaction) }}" class="btn btn-primary mr-2">Edit</a>
                        <a href="{{ route('repair-transactions.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                    <!-- Repair Transaction Info -->
                    <div class="form-group mb-4">
                        <h5>Repair Transaction Information:</h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">ID</th>
                                    <td>{{ $repairTransaction->id }}</td>
                                </tr>
                                <tr>
                                    <th>Decision</th>
                                    <td>
                                        @if ($repairTransaction->decision === 'repair')
                                            <span class="badge bg-success">Repair</span>
                                        @elseif ($repairTransaction->decision === 'scrap')
                                            <span class="badge bg-danger">Scrap</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created Date</th>
                                    <td>{{ $repairTransaction->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated Date</th>
                                    <td>{{ $repairTransaction->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Inspection Info -->
                    <div class="form-group mb-4">
                        <h5>Inspection Information:</h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Barcode</th>
                                    <td>{{ $repairTransaction->inspectionTransaction->barcode }}</td>
                                </tr>
                                <tr>
                                    <th>Tire Type</th>
                                    <td>{{ $repairTransaction->inspectionTransaction->tireType->name_en }}</td>
                                </tr>
                                <tr>
                                    <th>Inspection Decision</th>
                                    <td>{{ $repairTransaction->inspectionTransaction->decision }}</td>
                                </tr>
                                <tr>
                                    <th>Building Date</th>
                                    <td>
                                        {{ $repairTransaction->inspectionTransaction->building_date ?
                                           $repairTransaction->inspectionTransaction->building_date->format('Y-m-d') : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Machine</th>
                                    <td>{{ $repairTransaction->inspectionTransaction->machine ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <a href="{{ route('inspection-transactions.show', $repairTransaction->inspectionTransaction->id) }}"
                               class="btn btn-info btn-sm">
                                View Full Inspection Details
                            </a>
                        </div>
                    </div>

                    <!-- Repair Steps -->
                    <div class="form-group mb-4">
                        <h5>Repair Steps:</h5>
                        @if ($repairTransaction->repairSteps->count() > 0)
                            <ul class="list-group">
                                @foreach ($repairTransaction->repairSteps as $step)
                                    <li class="list-group-item">{{ $step->name_en }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No repair steps have been added.</p>
                        @endif
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
@endsection
