$(document).ready(function () {
    tinySetup({
        editor_selector: "textarea",
        setup: function (ed) {
            ed.on('loadContent', function (ed, e) {
                handleCounterTiny(tinymce.activeEditor.id);
            });
            ed.on('change', function (ed, e) {
                tinyMCE.triggerSave();
                handleCounterTiny(tinymce.activeEditor.id);
            });
            ed.on('blur', function (ed) {
                tinyMCE.triggerSave();
            });
        }
    });

    function handleCounterTiny(id) {
        let textarea = $('#' + id);
        let counter = textarea.attr('counter');
        let counter_type = textarea.attr('counter_type');
        let max = tinyMCE.activeEditor.getBody().textContent.length;

        textarea.parent().addClass('bio-content');
        textarea.parent().find('span.currentLength').text(max);
        if ('recommended' !== counter_type && max > counter) {
            textarea.parent().find('span.maxLength').addClass('is-danger');
        } else {
            textarea.parent().find('span.maxLength').removeClass('is-danger');
        }
    }
});
