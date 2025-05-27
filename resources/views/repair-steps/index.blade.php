@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/src/table/datatable/extensions/responsive/responsive.dataTables.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/css/light/table/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/css/dark/table/datatable/responsive.bootstrap5.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/responsive-table.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/filter-column.css') }}">
@endsection

@section('content')
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Repair Steps</a></li>
                    </ol>
                </nav>
            </div>
            <!-- /BREADCRUMB -->

            <div class="row layout-top-spacing">

                <x-add-button model="repair-steps" name="repair step" />

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <form method="GET" action="{{ route('repair-steps.index') }}" class="mb-3">
                            <div class="row align-items-end">
                                <div class="col-md-4 col-12 filter-column">
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Filter by Name" value="{{ request('name') }}">
                                </div>
                                <div class="col-md-4 col-12 filter-column d-flex">
                                    <x-filter-button />
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name (Arabic)</th>
                                        <th>Name (English)</th>
                                        <th>Created At</th>
                                        <th class="text-center no-sort">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($repairSteps as $repairStep)
                                        <tr>
                                            <td data-th="ID">{{ $repairStep->id }}</td>
                                            <td data-th="Name (Arabic)">{{ $repairStep->name_ar }}</td>
                                            <td data-th="Name (English)">{{ $repairStep->name_en }}</td>
                                            <td data-th="Created At">{{ $repairStep->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center" data-th="Actions">
                                                <div class="d-flex flex-wrap justify-content-center button-group gap-1">
                                                    <!-- Show Button -->
                                                    <x-show-button route="repair-steps.show" :param="$repairStep->id"
                                                        name="repair step" />
                                                    <!-- Edit Button -->
                                                    <x-edit-button route="repair-steps.edit" :param="$repairStep->id"
                                                        name="repair step" />
                                                    <!-- Delete Button -->
                                                    <div style="margin-top: 0.08rem">

                                                        <x-delete-button route="repair-steps.destroy" :param="$repairStep->id"
                                                            name="repair step" />
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!--  END CONTENT AREA  -->
@endsection
<!-- END MAIN CONTAINER -->
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
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10,
            "lengthChange": false,
            "searching": false,
            "responsive": {
                details: false
            },
            "columnDefs": [{
                "targets": [4],
                "orderable": false,
                "className": "text-center"
            }],
            "order": [
                [0, "asc"]
            ]
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

    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const deleteUrl = this.getAttribute('data-url');
                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)')
                    .matches;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    background: isDarkMode ? '#333' : '#fff',
                    color: isDarkMode ? '#fff' : '#000'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit the form to delete the repair step
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        form.appendChild(csrfToken);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);
                        form.submit();
                    }
                })
            });
        });
    </script>
@endsection
