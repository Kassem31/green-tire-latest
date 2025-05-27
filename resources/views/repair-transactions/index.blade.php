@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/src/table/datatable/extensions/responsive/responsive.dataTables.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/responsive.bootstrap5.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/responsive-table.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/filter-column.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/pagination.css') }}">
@endsection

@section('content')
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">

            <div class="row layout-top-spacing">
                <div class="page-title">
                    <h3>Repair Transactions</h3>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('repair-transactions.pending') }}" class="btn btn-warning">Pending Repair
                        Transactions</a>
                </div>

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Inspection Barcode') }}</th>
                                        <th>{{ __('Tire Type') }}</th>
                                        <th>{{ __('Decision') }}</th>
                                        <th>{{ __('Repair Steps') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th class="text-center no-sort">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($repairTransactions as $transaction)
                                        <tr>
                                            <td data-th="{{ __('ID') }}">{{ $transaction->id }}</td>
                                            <td data-th="{{ __('Inspection Barcode') }}">
                                                {{ $transaction->inspectionTransaction->barcode }}</td>
                                            <td data-th="{{ __('Tire Type') }}">
                                                {{ $transaction->inspectionTransaction->tireType->name_en }}</td>
                                            <td data-th="{{ __('Decision') }}">
                                                @if ($transaction->decision === 'repair')
                                                    <span class="badge bg-success">{{ $transaction->decision }}</span>
                                                @elseif ($transaction->decision === 'scrap')
                                                    <span class="badge bg-danger">{{ $transaction->decision }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $transaction->decision }}</span>
                                                @endif
                                            </td>
                                            <td data-th="{{ __('Repair Steps') }}">
                                                {{ $transaction->repairSteps->count() }}</td>
                                            <td data-th="{{ __('Created At') }}">
                                                {{ $transaction->created_at->format('Y-m-d') }}</td>
                                            <td data-th="{{ __('Actions') }}">
                                                <div class="d-flex flex-wrap justify-content-center button-group gap-1">
                                                    <a href="{{ route('repair-transactions.show', $transaction) }}"
                                                        class="btn btn-info btn-sm">{{ __('View') }}</a>
                                                    <a href="{{ route('repair-transactions.edit', $transaction) }}"
                                                        class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                                    <form action="{{ route('repair-transactions.destroy', $transaction) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this repair transaction?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            style="margin-top: 0.85rem">{{ __('Delete') }}</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                {{ __('No repair transactions found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            @include('vendor.pagination.info', ['paginator' => $repairTransactions])
                            {{ $repairTransactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/extensions/responsive/dataTables.responsive.min.js') }}">
    </script>
    <script>
        $('#zero-config').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "paging": false, // Disable DataTables pagination as we're using Laravel's
        "responsive": {
            details: false
        },
        "columnDefs": [{
            "targets": [6],
            "orderable": false,
            "className": "text-center"
        }],
        "order": [
            [0, "desc"]
        ]
        });
        });
    </script>
@endsection
