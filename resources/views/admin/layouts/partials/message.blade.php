@if( $msg = session('msg'))
    <script>
        iziToast.{{ $msg['status'] }}({
            title: '{{ $msg['title'] }}',
            message: '{{ $msg['message'] }}',
            'position': 'topLeft'
        });
    </script>
@endif
