<script type="text/javascript">
    @if($message = Session::get('alert'))
        Swal.fire({
            title: '<strong>{{$message}}</u></strong>',
            type: 'success',
            imageHeight: 100,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonColor: '#003D99',
            confirmButtonText: 'ปิดหน้าต่าง',
        });
    @elseif($message = Session::get('alerterror'))
        Swal.fire({
            title: '<strong>{{$message}}</u></strong>',
            type: 'error',
            imageHeight: 100,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonColor: '#003D99',
            confirmButtonText: 'ปิดหน้าต่าง',
        });
    @endif
</script>