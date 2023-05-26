$(document).ready(function() {
    $('.select2-form').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
        placeholder: $(this).data("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
        closeOnSelect: !$(this).attr("multiple"),
        language: 'ja',
    });
});
