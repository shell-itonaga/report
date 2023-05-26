$(function() {
    history.pushState(null, null, null); //ブラウザバック無効化
    //ブラウザバックボタン押下時
    $(window).on("popstate", function(event) {
        history.pushState(null, null, null);
        window.alert('ブラウザのバックはできません');
    });
});