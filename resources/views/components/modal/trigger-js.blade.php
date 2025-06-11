<script>
    $(document).ready(function () {
        function initSummernote(modal) {
            $(modal).find('.summernote').each(function () {
                if ($(this).next().hasClass('note-editor')) {
                    $(this).summernote('destroy');
                }
                $(this).summernote({
                    minHeight: 100,
                    dialogsInBody: true
                });
            });
        }

        $('#createModal, #editModal').on('shown.bs.modal', function () {
            initSummernote(this);
        });

        $('#createModal, #editModal').on('hidden.bs.modal', function () {
            $(this).find('.summernote').each(function () {
                if ($(this).next().hasClass('note-editor')) {
                    $(this).summernote('destroy');
                }
                $(this).val('');
            });
        });
    });
</script>
