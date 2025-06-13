<script>
    $(document).ready(function() {
        function initSummernote(modal) {
            $(modal).find('.summernote').each(function() {
                if ($(this).next().hasClass('note-editor')) {
                    $(this).summernote('destroy');
                }

                $(this).summernote({
                    minHeight: 100,
                    dialogsInBody: true,
                    callbacks: {
                        onPaste: function(e) {
                            e.preventDefault(); // Stop HTML paste
                            const bufferText = ((e.originalEvent || e).clipboardData ||
                                window.clipboardData).getData('text/plain');

                            const editable = $(this);
                            setTimeout(() => {
                                editable.summernote('pasteHTML', bufferText.replace(
                                    /\n/g, '<br>'));
                            }, 10);
                        }
                    }
                });
            });
        }


        $('#createModal, #editModal').on('shown.bs.modal', function() {
            initSummernote(this);
        });

        $('#createModal, #editModal').on('hidden.bs.modal', function() {
            $(this).find('.summernote').each(function() {
                if ($(this).next().hasClass('note-editor')) {
                    $(this).summernote('destroy');
                }
                $(this).val('');
            });
        });
    });
</script>
