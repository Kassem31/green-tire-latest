@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/src/table/datatable/extensions/responsive/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/responsive-table.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/filter-column.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/pagination.css') }}">
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Pending Repair Transactions</h3>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('repair-transactions.index') }}" class="btn btn-secondary">All Repair
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


                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('repair-transactions.pending') }}" class="mb-4">
                        <div class="row align-items-end mb-2">
                            <div class="col-md-3 col-12 filter-column mb-2">
                                <label for="filter-barcode" class="form-label">Inspection Barcode</label>
                                <input type="text" id="filter-barcode" name="barcode" class="form-control"
                                    placeholder="Filter by Barcode" value="{{ request('barcode') }}">
                            </div>
                            <div class="col-md-3 col-12 filter-column mb-2">
                                <label for="filter-tire-type" class="form-label">Tire Type</label>
                                <select id="filter-tire-type" name="tire_type_id" class="form-control">
                                    <option value="">All Tire Types</option>
                                    @foreach ($tireTypes as $tireType)
                                        <option value="{{ $tireType->id }}"
                                            {{ request('tire_type_id') == $tireType->id ? 'selected' : '' }}>
                                            {{ $tireType->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12 filter-column mb-2">
                                <label for="filter-date-from" class="form-label">Date From</label>
                                <input type="date" id="filter-date-from" name="date_from" class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3 col-12 filter-column mb-2">
                                <label for="filter-date-to" class="form-label">Date To</label>
                                <input type="date" id="filter-date-to" name="date_to" class="form-control"
                                    value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3 d-flex justify-content-center justify-content-md-start gap-2">
                                <button type="submit" class="btn btn-primary" style="margin-left: 1rem">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('repair-transactions.pending') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="zero-config" class="table dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Inspection Barcode') }}</th>
                                    <th>{{ __('Tire Type') }}</th>
                                    <th>{{ __('Decision') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th class="text-center no-sort">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingTransactions as $transaction)
                                    <tr>
                                        <td data-th="ID">{{ $loop->iteration }}</td>
                                        <td data-th="Inspection Barcode">{{ $transaction->inspectionTransaction->barcode }}
                                        </td>
                                        <td data-th="Tire Type">
                                            {{ $transaction->inspectionTransaction->tireType->name_en }}</td>
                                        <td data-th="Decision">
                                            <span class="badge bg-warning">{{ $transaction->decision }}</span>
                                        </td>
                                        <td data-th="Created At">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center" data-th="Actions">
                                            <div class="d-flex flex-wrap justify-content-center button-group gap-1">
                                                <a href="{{ route('repair-transactions.show', $transaction) }}"
                                                    class="btn btn-info btn-sm">{{ __('View') }}</a>
                                                <a href="{{ route('repair-transactions.edit', $transaction) }}"
                                                    class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{ __('No pending repair transactions found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrapper">
                        @include('vendor.pagination.info', ['paginator' => $pendingTransactions])
                        {{ $pendingTransactions->appends(request()->query())->links() }}
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
                "targets": [5],
                "orderable": false,
                "className": "text-center"
            }],
            "order": [
                [0, "asc"]
            ]
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

                const ToastSuccess = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    background: isDarkMode ? '#333' : '#fff',
                    color: isDarkMode ? '#fff' : '#000',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                ToastSuccess.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                    const newColorScheme = event.matches ? 'dark' : 'light';
                    ToastSuccess.update({
                        background: newColorScheme === 'dark' ? '#333' : '#fff',
                        color: newColorScheme === 'dark' ? '#fff' : '#000'
                    });
                });
            });
        </script>
    @endif
@endsection
