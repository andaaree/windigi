<!DOCTYPE html>
@extends('/admin/body')
@section('title', 'Tambah Key - WDT (Windows Digital Tracker)')
@section('ext-css')
<!-- Select2 -->
<link rel="stylesheet" href="/assets/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="/assets/css/admin.css">
@endsection
@section('container')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="display-4">Tambah Key</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="/keys">Key</a></li>
                    <li class="breadcrumb-item">Tambah Key</li>
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
                        <h3 class="card-title">Tambah Key</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="ct-file">Key File</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input name="file" type="file" class="custom-file-input" value="{{old('file')}}" id="ct-file" accept=".zip">
                                            <label class="custom-file-label" for="ct-file" aria-describedby="ct-file-desc">Choose Key</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="ct-file-desc">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <a href="" class="form-control" id="your-file"></a>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a href="" id="save-file" type="submit" class="btn btn-dark">Save</a>
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
<script src="/assets/js/resumable/resumable.js"></script>
<!-- Page specific script -->
<script type="text/javascript">
    $(document).ready(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        bsCustomFileInput.init();

        $('#your-file').hide();
        $('#save-file').addClass('disabled');

        let browseFile = $('#ct-file');

        let resumable = new Resumable({
        target: '/keys'
        , chunkSize: 10*1024*1024 // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        , query: {
            _token: '{{ csrf_token() }}',
        } // CSRF token
        , fileType: ['zip']
        , headers: {
            'Accept': 'application/json'
        }
        , testChunks: false
        , throttleProgressCallbacks: 1
        , });
        
        resumable.assignBrowse(browseFile);

        resumable.on('fileAdded', function(file, event) { // trigger when file picked
            showProgress();
            // let fSize = file.size / 1000000;
            resumable.upload() // to actually start uploading.
        });
        
        resumable.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
        });

        resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
            response = JSON.parse(response)
            $('#your-file').attr('href', response.path);
            $('#your-file').text(response.filename);
            $('#your-file').show();
            $('#save-file').removeClass('disabled');
            $('#save-file').attr('href', '/keys/'+response.url);
        });

        resumable.on('fileError', function(file, response) { // trigger when there is any error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response,
                timer: 1800
            });
        });


        let progress = $('.progress');

        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)
        }

        function hideProgress() {
            progress.hide();
        }
    });
</script>
@endsection
