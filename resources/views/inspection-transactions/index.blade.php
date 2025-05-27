@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/extensions/responsive/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/responsive-table.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/filter-column.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/pagination.css') }}">
@endsection

@section('content')
<div class="layout-px-spacing">
    {{-- <div class="middle-content container-xxl p-0"> --}}
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Repair Transactions</h3>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('inspection-transactions.create') }}" class="btn btn-primary me-2">Add Inspection</a>
                <a href="{{ route('repair-transactions.pending') }}" class="btn btn-warning">Pending Transactions</a>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <form method="GET" action="{{ route('inspection-transactions.index') }}" class="mb-4">
                        <div class="row align-items-end mb-2">
                            <div class="col-md-2 col-12 filter-column mb-2">
                                <label for="filter-barcode" class="form-label">Barcode</label>
                                <input type="text" id="filter-barcode" name="barcode" class="form-control"
                                    placeholder="Filter by Barcode" value="{{ request('barcode') }}">
                            </div>
                            <div class="col-md-2 col-12 filter-column mb-2">
                                <label for="filter-tire-type" class="form-label">Tire Type</label>
                                <select id="filter-tire-type" name="tire_type_id" class="form-control">
                                    <option value="">All Tire Types</option>
                                    @foreach($tireTypes as $tireType)
                                        <option value="{{ $tireType->id }}" {{ request('tire_type_id') == $tireType->id ? 'selected' : '' }}>
                                            {{ $tireType->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-12 filter-column mb-2">
                                <label for="filter-decision" class="form-label">Decision</label>
                                <select id="filter-decision" name="decision" class="form-control">
                                    <option value="">All Decisions</option>
                                    <option value="Repair" {{ request('decision') == 'Repair' ? 'selected' : '' }}>Repair</option>
                                    <option value="Scrap" {{ request('decision') == 'Scrap' ? 'selected' : '' }}>Scrap</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-12 filter-column mb-2">
                                <label for="filter-date" class="form-label">Building Date</label>
                                <input type="date" id="filter-date" name="building_date" class="form-control"
                                    value="{{ request('building_date') }}">
                            </div>
                            <div class="col-md-2 col-12 filter-column mb-2">
                                <label for="filter-machine" class="form-label">Machine</label>
                                <input type="text" id="filter-machine" name="machine" class="form-control"
                                    placeholder="Filter by Machine" value="{{ request('machine') }}">
                            </div>
                            <div class="col-md-2 col-12 filter-column mb-2">
                                <label for="filter-status" class="form-label">Status</label>
                                <select id="filter-status" name="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="repaired" {{ request('status') == 'repaired' ? 'selected' : '' }}>Repaired</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Repair</option>
                                    <option value="scrap" {{ request('status') == 'scrap' ? 'selected' : '' }}>Scrapped</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-2 d-flex justify-content-center" style="margin-bottom: 0.6rem;">
                                <x-filter-button />
                            </div>
                        </div>
                        {{-- <div class="row"> --}}
                        {{-- </div> --}}
                    </form>

                    <div class="table-responsive">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Tire Type</th>
                                <th>Decision</th>
                                <th>Building Date</th>
                                <th>Machine</th>
                                <th class="text-center">Status</th>
                                <th class="text-center no-sort">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inspectionTransactions as $transaction)
                            <tr>
                                <td data-th="Barcode">{{ $transaction->barcode }}</td>
                                <td data-th="Tire Type">{{ $transaction->tireType->name_en }}</td>
                                <td data-th="Decision">{{ $transaction->decision }}</td>
                                <td data-th="Building Date">{{ $transaction->building_date ? $transaction->building_date->format('Y-m-d') :
                                    'N/A' }}</td>
                                <td data-th="Machine">{{ $transaction->machine ?? 'N/A' }}</td>
                                <td class="text-center" data-th="Status">
                                    @if ($transaction->is_repaired)
                                    <span class="badge bg-success">Repaired</span>
                                    @elseif (strtolower($transaction->decision) === 'repair')
                                    <span class="badge bg-warning">Pending Repair</span>
                                    @elseif (strtolower($transaction->decision) === 'scrap')
                                    <span class="badge bg-danger">Scrapped</span>
                                    @else
                                    <span class="badge bg-secondary">{{ $transaction->decision }}</span>
                                    @endif
                                </td>
                                <td class="text-center" data-th="Actions">
                                    <div class="d-flex flex-wrap justify-content-center button-group gap-1">
                                        <!-- Show Button -->
                                        <x-show-button route="inspection-transactions.show" :param="$transaction->id"
                                            name="inspection" />

                                        @if (strtolower($transaction->decision) === 'repair' && !$transaction->is_repaired)
                                        <a href="{{ route('repair-transactions.create', ['inspection_id' => $transaction->id]) }}"
                                            class="btn btn-success btn-icon btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Add Repair Steps">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                                                <path
                                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                                </path>
                                            </svg>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="pagination-wrapper">
                        @include('vendor.pagination.info', ['paginator' => $inspectionTransactions])
                        {{ $inspectionTransactions->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</div>
<!--  END CONTENT AREA  -->
@endsection

@section('scripts')
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
<script src="{{ asset('src/assets/js/custom.js') }}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('src/plugins/src/table/datatable/extensions/responsive/dataTables.responsive.min.js') }}"></script>
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
            "columnDefs": [
                { 
                    "targets": [5,6],
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            "order": [[0, "asc"]]
        });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                })
            });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    background: isDarkMode ? '#333' : '#fff',
                    color: isDarkMode ? '#fff' : '#000'
                });

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                    const newColorScheme = event.matches ? 'dark' : 'light';
                    Swal.update({
                        background: newColorScheme === 'dark' ? '#333' : '#fff',
                        color: newColorScheme === 'dark' ? '#fff' : '#000'
                    });
                });
            });
</script>
@endif
@endsection
