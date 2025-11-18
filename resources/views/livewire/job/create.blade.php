<x-form-layout title="Create Role">
    <x-dynamic-form :fields="$formFields" form-data="formData" col="3" />
</x-form-layout>

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js">
</script>
<script>
let editorInstance;

$(document).ready(function () {
    $('.select2').select2();
});

document.addEventListener('DOMContentLoaded', function () {
let typingTimer;
const doneTypingDelay = 1500;
ClassicEditor
    .create(document.querySelector('#description'))
    .then(editor => {
        editorInstance = editor;
        editor.model.document.on('change:data', () => {
            clearTimeout(typingTimer);
            @this.set('description', editor.getData());
            typingTimer = setTimeout(() => {
                $('#createModal .select2').select2({
                    dropdownParent: $('#createModal'),
                    width: '100%'
                });
            }, doneTypingDelay);
        });
    })
    .catch(error => {
        console.error(error);
    });

   $('#createModal .select2').on('change', function (e) {
        const model = $(this).data('model');
        const value = $(this).val();
        if (model) {
            @this.set(model, value);
            setTimeout(() => {
                console.log('test2');
                $('#createModal .select2').select2({
                    dropdownParent: $('#createModal'),
                    width: '100%'
                });
            }, 500);
        }
    });
});
</script>
@endpush
