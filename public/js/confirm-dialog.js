$('#send').click(function() {
    if (!confirm('更新します。よろしいですか？')) {
        // submitボタンの効果をキャンセル
        return false;
    }
});
$('#delete').click(function() {
    if (!confirm('データ削除します。よろしいですか？')) {
        // submitボタンの効果をキャンセル
        return false;
    }
});