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
                <h3 class="display-4">Detail User</h3>
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
            <div class="col-4">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-body">
                        <h3>Detail user :</h3>
                        @php
                            $rl = [
                            'Super Admin',
                            'Admin Produksi',
                            'CS'
                            ];
                        @endphp
                        <ul>
                            <li>Nama : {{ $user->name }}</li>
                            <li>Username : {{ $user->username }}</li>
                            <li>Email : {{ $user->email }}</li>
                            <li>Role : {{ $rl[$user->role] }}</li>
                        </ul>
                        <p><a href="/users/reset" class="btn btn-sm btn-info">Reset Password</a></p>
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

<!-- SweetAlert2 -->
<script src="/assets/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- Page specific script -->
<script>
    $(document).ready(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        bsCustomFileInput.init();

    });
</script>
@include('admin.validator')
@endsection