<script type="text/javascript">
    @if (count($errors) > 0)
    $(document).ready(function(e) {
        e.preventDefault;
        $('#modal-add').modal('show');
    });
    @endif
</script>
@if (session('success'))
<script type="text/javascript">
    $(document).ready(function(e) {
        e.preventDefault;
        var data = '<?= session("success") ?>';
        var js = JSON.parse(data);
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            html: js.message,
            timer: 1700
        });
    });
</script>
@endif
@if (session('error'))
<script type="text/javascript">
    $(document).ready(function(e) {
        e.preventDefault;
        var data = '<?= session("error"); ?>';
        var js = JSON.parse(data);
        let msg = js.message;
        if (msg.includes("div")) {
            msg = msg.replace(/<[^>]+>/g, '<br>');
        }else{
            msg = js.message;
        }
        console.log(data);
        console.log(js);
        Swal.fire({
            icon: 'error',
            title: 'Error !',
            html: msg,
            timer: 3000
        });
    });
</script>
@endif