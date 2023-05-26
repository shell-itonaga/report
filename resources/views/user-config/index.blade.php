<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ Auth::user()->name }}さん【作業者No：{{ Auth::user()->id }}】</div>
        <div class="text-sm md:text-lg">ユーザ情報設定変更</div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container">
            <div class="max-w-xl mx-auto">
@if(Session::has('message'))
                <div class="alert alert-danger mt-2 text-center" role="alert">{{ session('message') }}</div>
@endif
                <div class="my-2 px-2 py-2 rounded-lg border-gray-300 border-1 bg-white">
                    <form name="input" class="mx-auto" method="POST" action="{{ route('user-config.confirm') }}">
                        @csrf
                        <div class="col-sm mb-2">
                            <label for="user_name" class="col-form-label">名前<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <input type="text" class="form-control" title="全角文字を入力してください" pattern="[^\x20-\x7e\uff61-\uff9f]*" placeholder="名前を入力してください  例）山田一郎" value="{{ empty(old('user_name')) ? $user->name : old('user_name') }}" id="user_name" name="user_name" required>
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 全角文字で入力してください</div>
                        </div>

                        <div class="col-sm mb-2">
                            <label for="user_name_kana" class="col-form-label">フリガナ<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <input type="text" class="form-control" title="半角カナで入力してください" pattern="^[ｧ-ﾝﾞﾟ]+$" placeholder="半角カナで入力してください  例）ﾔﾏﾀﾞｲﾁﾛｳ" value="{{ empty(old('user_name_kana')) ? $user->name_kana : old('user_name_kana') }}" id="user_name_kana" name="user_name_kana" required>
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;半角カナで入力してください</div>
                        </div>

                        <div class="col-sm mb-2">
                            <label for="email" class="col-form-label">メールアドレス<span class="badge bg-secondary mx-2 my-0">任意</span>
                                <div class="col-form-label-sm text-primary"><i class="fas fa-info-circle"></i>&nbsp;未設定の場合、メールによるパスワードのリセット機能は利用出来ません</div>
                            </label>
                            <input type="email" class="form-control" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="メールアドレスを入力" value="{{ empty(old('email')) ? $user->email : old('email') }}" id="email" name="email">
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;正しいメールアドレス形式で入力してください</div>
                        </div>

                        <div class="col-sm mb-2">
                            <label for="password" class="col-form-label">パスワード
                                <div class="badge bg-secondary mx-2 my-0">任意</div>
                                <div class="col-form-label-sm text-danger"><i class="fas fa-exclamation-circle"></i>&nbsp;変更する場合のみ入力してください</div>
                            </label>
                            <input type="password" class="form-control" pattern="^([a-zA-Z0-9]{8,})$" minlength="8" placeholder="半角英数字8文字以上で入力してください" value="" id="password" name="password" autocomplete="off">
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;半角英数字8文字以上で入力してください</div>
                            <input type="checkbox" id="password-check">
                            <label for="password-check" class="col-form-label-sm">パスワード表示</label>
                            <script>
                                const pwd1 = document.getElementById('password');
                                const pwdCheck1 = document.getElementById('password-check');
                                pwdCheck1.addEventListener('change', function() {
                                    if(pwdCheck1.checked) {
                                        pwd1.setAttribute('type', 'text');
                                    } else {
                                        pwd1.setAttribute('type', 'password');
                                    }
                                }, false);
                            </script>
                        </div>

                        <div class="col-sm mb-2">
                            <label for="password_confirmation" class="col-form-label">パスワード(再入力)
                                <div class="badge bg-secondary mx-2 my-0">任意</div><br>
                                <div class="col-form-label-sm text-danger"><i class="fas fa-exclamation-circle"></i>&nbsp;変更する場合のみ入力してください</div>
                            </label>
                            <input type="password" class="form-control" pattern="^([a-zA-Z0-9]{8,})$" minlength="8" placeholder="パスワードを再入力" value="" id="password_confirmation" name="password_confirmation" autocomplete="off">
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;半角英数字8文字以上で入力してください</div>
                            <input type="checkbox" id="password-confirmation-check">
                            <label for="password-confirmation-check" class="col-form-label-sm">パスワード表示</label>
                            <span class="mx-2 font-bold" id="CheckPasswordMatch"></span>
                            <script>
                                const pwd2 = document.getElementById('password_confirmation');
                                const pwdCheck2 = document.getElementById('password-confirmation-check');
                                pwdCheck2.addEventListener('change', function() {
                                    if(pwdCheck2.checked) {
                                        pwd2.setAttribute('type', 'text');
                                    } else {
                                        pwd2.setAttribute('type', 'password');
                                    }
                                }, false);
                            </script>
                        </div>

                        <div class="mx-auto my-2 text-center">
                            <a class="btn btn-lg btn-primary mx-4 my-2" href="{{ route('menu') }}">戻&emsp;る</a>
                            <button class="btn btn-primary btn-lg mx-2" type="submit" id="submit" name="submit" value="confirm">登録確認</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div><!-- min-h-screen -->

</x-app-layout>
