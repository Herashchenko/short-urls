import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min'
import 'bootstrap-datepicker/dist/locales/bootstrap-datepicker.uk.min'

jQuery(document).ready(function () {
    jQuery('.input-group.date').datepicker({
        format: 'dd.mm.yyyy',
        startDate: 'now',
        language: 'uk',
    }).on('show', function(e) {
        jQuery('.datepicker-dropdown').css('top', (jQuery(this).offset().top + jQuery(this).height()) + 'px');
    });

    jQuery('.copy-btn').click(function() {
        let copyText = jQuery(this).parent().parent().find('.copy-link').text();
        let elem = document.createElement('input');
        elem.value = copyText;
        document.body.appendChild(elem);
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);
    });
})
