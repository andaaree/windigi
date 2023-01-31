<!DOCTYPE html>
@extends('/admin/body')
@section('title', 'User - Admin Perpus')
@section('ext-css')
<!-- Select2 -->
<link rel="stylesheet" href="/assets/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

{{-- DataTables --}}
<link rel="stylesheet" href="/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('csrf-ajax')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('container')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="display-4">Daftar user</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item active">user</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header">
                        <button data-target="#modal-add" data-toggle="modal" class="btn btn-dark">Tambah user</button> <button data-target="#modal-import" data-toggle="modal" class="d-inline btn btn-dark">Import user</button>
                    </div>
                    <div class="card-body">
                        <p>Export to :</p>
                        <table id="tb-user" class="table table-bordered table-striped">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
            while ($number > 0) {
                foreach ($map as $roman => $int) {
                    if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                    }
                }
            }
        return $returnValue;
    }
    @endphp
    <div class="modal fade" aria-modal="true" id="modal-add" aria-hidden="false" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="fdata" action="{{ route('users.store' )}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1>Tambah User</h1>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama'){{'is-invalid'}}@enderror" value="{{old('nama')}}">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control @error('username'){{'is-invalid'}}@enderror" value="{{old('username')}}">
                            @error('username')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control @error('email'){{'is-invalid'}}@enderror" value="{{old('email')}}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label" for="role">Role</label>
                            <div class="input-group">
                                <select name="role" required class="form-control select2bs4 @error('role'){{ 'is-invalid' }}@enderror" id=" role" aria-label="">
                                    <option selected>-- Pilih Role --</option>
                                    @php
                                    $rl = [
                                    'Super Admin',
                                    'Admin Produksi',
                                    'CS'
                                    ];
                                    @endphp
                                    @for($i = 0; $i < count($rl); $i++)
                                    {{-- <option @if (old('role') == $i) {{'selected'}}@endif value="{{ $i }}">{{ $rl[$i] }}</option> --}}
                                    <option value="{{ $i }}">{{ $rl[$i] }}</option>

                                    @endfor
                                </select>
                                @error('role')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password'){{'is-invalid'}}@enderror" value="{{old('password')}}">
                            @error('password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation'){{'is-invalid'}}@enderror" value="{{old('password_confirmation')}}">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button id="save-user" class="btn btn-secondary">Tambah</button>
                    </div>
                </form>
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

        var table = $('#tb-user').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "dom":'Blfrtip',
            "buttons": ['excel','pdf'],
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: "name",
                name: "name"
            }, {
                data: "username",
                name: "username"
            }, {
                data: "role",
                name: "role",
                render: function(data, type, full, mime) {
                    var rl = "";
                    if (data == 0) {
                        rl = "Super Admin";
                    } else if (data == 1) {
                        rl = "Admin Produksi";
                    } else {
                        rl = "CS";
                    }
                    return rl;
                }
            }, {
                data: 'DT_RowId',
                    render: function (data) { 
                        return '<button data-id="'+data+'" class="d-inline v-user btn btn-info"><i class="fas fa-eye"></i></button> <button data-id="'+data+'" type="button" class="edit-user btn btn-success"><i class="fas fa-edit"></i></button> <button data-id="'+data+'" type="button" class="d-inline del-user btn btn-danger"><i class="fas fa-trash"></i></button>';
                    },
                    searchable:false,
                    orderable:false
            }],
            "ajax": "/user/all"
        });
        $('#tb-user tbody').on('click', '.edit-user', function(e) {
            e.preventDefault;
            var id = $(this).attr('data-id');
            window.location.href = "users/" + id + "/edit";
        });
        $('#tb-user tbody').on('click', '.v-user', function(e) {
            e.preventDefault;
            var id = $(this).attr('data-id');
            window.location.href = "users/" + id;
        });
        $('#tb-user tbody').on('click', '.del-user', function(e) {
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
                        url: "/users/" + id,
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