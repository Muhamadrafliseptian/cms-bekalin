@push('js')
<script>
    $(document).on('click', '.btn-delete-alert', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');
        swal({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>
@endpush
