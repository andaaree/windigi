<!DOCTYPE html>
@extends('/admin/body')
@section('title', 'Daftar Product Key - WDT (Windows Digital Tracker)')
@section('ext-css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="display-4">Dashboard - Windows Digital Tracker</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            @if (Auth::user()->role < 2)
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>
                                Total Key :
                            </h3>
                            <p>
                                {{ $tk }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>
                                Total Consumed :
                            </h3>
                            <p>
                                {{ $tp }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <h3>
                                Sisa Key :
                            </h3>
                            <p>
                                {{ $ts }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-unlock-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-10">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header">
                            @if (Auth::user()->role < 1)
                            <a href="/keys/create" class="btn btn-dark d-inline mx-2">
                                Tambah Key
                            </a>
                            @endif
                            @if (Auth::user()->role < 2)
                            <a href="/plans/create" class="btn btn-dark d-inline mx-2">
                                Consume Key
                            </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SPO Purchase</th>
                                        <th>SRO Produksi</th>
                                        <th>Product Key</th>
                                        <th>Product Key ID</th>
                                        <th>SN Casing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('ext-script')
    <!-- bs-custom-file-input -->

    <script src="/assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="/assets/adminlte/plugins/select2/js/select2.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/adminlte/plugins/jszip/jszip.min.js"></script>
    <script src="/assets/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/assets/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/assets/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            bsCustomFileInput.init();

            var table = $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "font-size": "11px",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "keys.bundle_id",
                        name: "keys.bundle_id"
                    },
                    {
                        data: "plan_id",
                        name: "plan_id"
                    },
                    {
                        data: "keys.p_key",
                        name: "keys.p_key",
                        render: function(data) {
                            var lastFive = data.substr(data.length - 5);
                            return lastFive;
                        }
                    },
                    
                    {
                        data: "p_key_id",
                        name: "p_key_id"
                    },
                    {
                        data: "sn_casing",
                        name: "sn_casing"
                    }
                ],
                "ajax": "/combine/all"
            });
            $('#example1 tbody').on('click', '.del-key', function(e) {
                e.preventDefault;
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Anda tidak bisa kembalikan data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "delete",
                            url: "/admin/plans/" + id,
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: data.status,
                                    title: "Berhasil",
                                    text: data.message,
                                    timer: 1200
                                });
                                table.draw();
                            },
                            error: function(data) {
                                var js = data.responseJSON;
                                Swal.fire({
                                    icon: 'error',
                                    title: js.exception,
                                    text: js.message,
                                    timer: 1200
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
    @include('admin.validator')
@endsection
