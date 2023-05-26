$(function() {
    var addValues = 0;
    $('#addRow').click(function() {
        var html = '<tr><td><input class="form-check-input" type="hidden" value="0" name="values[' + addValues + '][is_delete]"></td><td><input class="form-control" type="text" name="values[' + addValues + '][unit_no_name]"></td></tr>';
        $('tbody').append(html);
        addValues -= 1;
    });
});