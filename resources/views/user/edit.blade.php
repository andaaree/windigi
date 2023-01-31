<!DOCTYPE html>
@extends('/admin/body')
@section('title', 'Edit User - Admin Perpus')
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
                <h3 class="display-4">Edit User</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/user">User</a></li>
                    <li class="breadcrumb-item">Edit User</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
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
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Edit User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route("user.update",$user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama user</label>
                                <input type="text" name="nama" id="nama" class="form-control @error('nama'){{'is-invalid'}}@enderror" value="{{ old('nama', $user->name) }}">
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="@if($user->role < 1){{ 'text' }}@else {{ 'number' }} @endif" name="username" id="username" class="form-control @error('username'){{'is-invalid'}}@enderror" value="{{old('username', $user->username)}}">
                                @error('username')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control @error('email'){{'is-invalid'}}@enderror" value="{{old('email', $user->email)}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="sekolah">Sekolah</label>
                                <div class="input-group">
                                    <select name="sekolah" class="form-control select2bs4 @error('sekolah'){{ 'is-invalid' }}@enderror" id="sekolah" aria-label="">
                                        <option value="">-- Pilih Sekolah --</option>
                                        @foreach ($sch as $s )
                                        <option @if(old('sekolah', $user->school_id)==$s->id){{ 'selected' }}@endif value="{{ $s->id }}">{{ $s->sch_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sekolah')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="kelas">Kelas</label>
                                <div class="input-group">
                                    <select name="kelas" class="form-control select2bs4 @error('kelas'){{ 'is-invalid' }}@enderror" id="kelas" aria-label="">
                                        <option value="">-- Pilih Kelas --</option>
                                        {{-- @foreach ($grade as $k )
                                        <option @if(old('kelas', $user->grade_id)==$k->id){{ 'selected' }}@endif value="{{ $k->id }}">{{ $k->grade_name }}</option>
                                        @endforeach --}}
                                    </select>
                                    @error('kelas')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="sekolah">Jurusan</label>
                                <div class="input-group">
                                    <select name="jurusan" class="form-control select2bs4 @error('jurusan'){{ 'is-invalid' }}@enderror" id="jurusan" aria-label="">
                                        <option value="">-- Pilih Jurusan --</option>
                                        {{-- @foreach ($maj as $m )
                                        <option @if(old('jurusan', $user->major_id)==$m->id){{ 'selected' }}@endif value="{{ $m->id }}">{{ $m->maj_name }} - {{ $m->educations->edu_name }}</option>
                                        @endforeach --}}
                                    </select>
                                    @error('jurusan')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="role">Role</label>
                                <div class="input-group">
                                    <select name="role" class="form-control select2bs4 @error('role'){{ 'is-invalid' }}@enderror"" id=" role" aria-label="">
                                        <option selected>-- Pilih Role --</option>
                                        @php
                                        $rl = [
                                        'Super Admin',
                                        'Admin Sekolah',
                                        'Guru',
                                        'Murid'
                                        ];
                                        @endphp
                                        @for($i = 0; $i < count($rl); $i++) <option @if(old('role', $user->role)==$i){{ 'selected' }}@endif value="{{ $i }}">{{ $rl[$i] }}</option>
                                            @endfor
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->role < 2)
                                <label class="form-label" for="pass">Password</label>
                                <input tooltip="Kosongkan jika tidak diubah" placeholder="Kosongkan jika tidak diubah" type="password" name="pass" id="pass" class="form-control @error('pass'){{'is-invalid'}}@enderror" value="{{old('pass')}}">
                                @error('pass')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            @endif
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-dark">Save</button>
                        </div>
                    </form>
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
<!-- Page specific script -->
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        bsCustomFileInput.init();
    });

    $(document).ready(function() {

        var sekolahID = $('#sekolah').val();
        var oldKelas = "{{ old('kelas',$user->grade_id) }}";
        var oldJurusan = "{{ old('jurusan',$user->major_id) }}";
        var url = "{{ Request :: segment(2) }}";
        // console.log(oldKelas);
        console.log('Sekolah ID : ',sekolahID);
        $.ajax({
            url: '/sch/'+sekolahID,
            type: "GET",
            success:function(data){
                console.log('Data Kelas : ', data);
                $('#kelas').empty();
                $('#kelas').append('<option value="" hidden>-- Pilih Kelas --</option>'); 
                $.each(data, function(id, kelas){
                    if (oldKelas == kelas.id){
                        $('select[name="kelas"]').append('<option selected value="'+ kelas.id +'">' + kelas.grade_name+ '</option>');
                        // console.log('Kelas ID selected : ', kelas.id, ' - ', oldKelas);
                    }else{
                        // console.log('Kelas ID : ',kelas.id)
                        $('select[name="kelas"]').append('<option value="'+ kelas.id +'">' + kelas.grade_name+ '</option>');
                    }
                });
            }
        });
        $.ajax({
            type: "get",
            url: '/maj/'+sekolahID+"?url="+url,
            success: function (data) {
                console.log('Data Jurusan : ', data);
                $('#jurusan').empty();
                $('#jurusan').append('<option value="" hidden>-- Pilih jurusan --</option>'); 
                $.each(data, function(index, jurusan){
                    console.log(jurusan);
                    if (oldJurusan == jurusan.id){
                        $('select[name="jurusan"]').append('<option selected value="'+ jurusan.id +'">' + jurusan.maj_name + " - "+jurusan.educations.edu_name+ '</option>');
                        console.log('Jurusan ID selected : ', jurusan.id, ' - ', oldJurusan);
                    }else{
                        console.log('Jurusan ID : ',jurusan.id)
                        $('select[name="jurusan"]').append('<option value="'+ jurusan.id +'">' + jurusan.maj_name + " - "+jurusan.educations.edu_name+ '</option>');
                    }
                });
            }
        });

        $('#sekolah').on('change', function() {
            var sekolahID = $(this).val();
            console.log(sekolahID);
            var url = "{{ Request :: segment(2) }}";
            $.ajax({
                url: '/sch/'+sekolahID,
                type: "GET",
                success:function(data)
                {
                    console.log('on change data : ',data);
                    $('#kelas').empty();
                    $('#kelas').append('<option value="" hidden>-- Pilih Kelas --</option>'); 
                    $.each(data, function(id, kelas){
                        $('select[name="kelas"]').append('<option value="'+ kelas.id +'">' + kelas.grade_name+ '</option>');
                    });
                }
            });
            $.ajax({
                type: "get",
                url: "/maj/"+sekolahID+"?url="+url,
                success: function (data) {
                    console.log('on chang data jurusan :', data);
                    $('#jurusan').empty();
                    $('#jurusan').append('<option value="" hidden>-- Pilih jurusan --</option>'); 
                    $.each(data, function(index, jurusan){
                        $('select[name="jurusan"]').append('<option value="'+ jurusan.id +'">' + jurusan.maj_name + " - "+jurusan.educations.edu_name+ '</option>');
                    });
                }
            });
        });

    });

</script> 
@endsection
