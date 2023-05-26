$(document).ready(function() {
    // パスワード一致するまで登録確認ボタンを無効化
    $("#password_confirmation").on('keyup', function() {
        var password = $("#password").val();
        var confirmPassword = $("#password_confirmation").val();
        if (password != confirmPassword) {
            $("#CheckPasswordMatch").html("パスワードが一致しません").css("color", "red");
            $("#submit").prop("disabled", true);
        } else {
            $("#CheckPasswordMatch").html("パスワードが一致しました").css("color", "green");
            $("#submit").prop("disabled", false);
        }
    });
});