<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">社員情報 新規登録</div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container">
            <div class="max-w-xl mx-auto">
@if(Session::has('message'))
                <div class="alert alert-danger mt-2 text-center" role="alert">{{ session('message') }}</div>
@endif
                <div class="my-2 px-2 py-2 rounded-lg border-gray-300 border-1 bg-white">
                    <form name="input" class="mx-auto needs-validation" novalidate method="POST" action="{{ route('employee.insert-confirm') }}">
@csrf
                        <!-- ユーザID -->
                        <div class="col-sm mb-2">
                            <label for="user_id" class="col-form-label">ユーザID<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <input type="text" class="form-control" title="ユーザID（半角数字4桁）を入力してください" minlength="4" maxlength="4" pattern="^([0-9]{4,})$" placeholder="ユーザID(TechsログインID)を入力してください" value="{{ old('user_id') }}" id="user_id" name="user_id" required>
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 半角数字（4桁）で入力してください</div>
                        </div>

                        <!-- 名前 -->
                        <div class="col-sm mb-2">
                            <label for="user_name" class="col-form-label">名前<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <input type="text" class="form-control" title="全角文字を入力してください" pattern="[^\x20-\x7e\uff61-\uff9f]*" placeholder="名前を入力してください  例）山田一郎" value="{{ old('user_name') }}" id="user_name" name="user_name" required>
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 全角文字で入力してください</div>
                        </div>

                        <!-- 名前（フリガナ） -->
                        <div class="col-sm mb-2">
                            <label for="user_name_kana" class="col-form-label">フリガナ<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <input type="text" class="form-control" title="半角カナで入力してください" pattern="^[ｧ-ﾝﾞﾟ]+$" placeholder="半角カナで入力してください  例）ﾔﾏﾀﾞｲﾁﾛｳ" value="{{ old('user_name_kana') }}" id="user_name_kana" name="user_name_kana" required>
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 半角カナで入力してください</div>
                        </div>

                        <!-- ユーザ権限 -->
                        <div class="col-sm mb-2">
                            <label for="user_authority" class="col-form-label">ユーザ権限<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <div class="border border-1 border-gray-500 rounded-lg p-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="user_authority_manager" name="user_authority" value="1" @if (!empty(old('user_authority')) && old('user_authority') == 1) checked @endif>
                                    <label class="form-check-label" for="user_authority_manager">管理者</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="user_authority_employee" name="user_authority" value="2" @if (empty(old('user_authority')) || old('user_authority') == 2) checked @endif>
                                    <label class="form-check-label" for="user_authority_employee">一般</label>
                                </div>
                            </div>
                        </div>

                        <!-- メールアドレス -->
                        <div class="col-sm mb-2">
                            <label for="email" class="col-form-label">メールアドレス<span class="badge bg-secondary mx-2 my-0">任意</span><br><span class="col-form-label-sm text-primary"><i class="fas fa-exclamation-circle"></i> 未入力の場合、メールによるパスワードのリセットは利用出来ません</span></label>
                            <input type="email" class="form-control" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="メールアドレスを入力" value="{{ old('email') }}" id="email" name="email">
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 正しいメールアドレス形式で入力してください</div>
                        </div>

                        <!-- パスワード -->
                        <div class="col-sm mb-2">
                            <label for="password" class="col-form-label">パスワード<span class="badge bg-danger mx-2 my-0">必須</span><span class="col-form-label-sm text-primary"></label>
                            <input type="password" class="form-control" pattern="^([a-zA-Z0-9]{8,})$" minlength="8" placeholder="半角英数字8文字以上で入力してください" value="" id="password" name="password" autocomplete="off" required>
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 半角英数字8文字以上で入力してください</div>
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

                        <!-- パスワード（再入力） -->
                        <div class="col-sm mb-2">
                            <label for="password_confirmation" class="col-form-label">パスワード(再入力)<span class="badge bg-danger mx-2 my-0">必須</span><span class="col-form-label-sm text-primary"></label>
                            <input type="password" class="form-control" pattern="^([a-zA-Z0-9]{8,})$" minlength="8" placeholder="パスワードを再入力" value="" id="password_confirmation" name="password_confirmation" autocomplete="off" required>
                            <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 半角英数字8文字以上で入力してください</div>
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

                        <!-- ユーザ状態 -->
                        <div class="col-sm mb-2">
                            <label for="user_status" class="col-form-label">ユーザ状態<span class="badge bg-danger mx-2 my-0">必須</span><br><span class="col-form-label-sm text-primary"><i class="fas fa-exclamation-circle"></i> 無効で登録した場合、有効に更新するまでユーザはログイン出来ません</span></label>
                            <div class="border border-1 border-gray-500 rounded-lg p-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="user_status_on" name="user_status" value="1" @if (empty(old('user_status')) || old('user_status') == 1) checked @endif>
                                    <label class="form-check-label" for="user_status_on">有効</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="user_status_off" name="user_status" value="0" @if (!empty(old('user_status')) && old('user_status') == 0) checked @endif>
                                    <label class="form-check-label" for="user_status_off">無効</label>
                                </div>
                            </div>
                        </div>

                        <!-- ボタン群 -->
                        <div class="mx-auto my-2 text-center">
                            <a class="btn btn-lg btn-primary mx-4 my-2" href="{{ route('menu') }}">戻&emsp;る</a>
                            <a href="{{ route('employee.insert') }}"><button class="btn btn-primary btn-lg mx-2" type="button"> ク リ ア </button></a>
                            <button class="btn btn-primary btn-lg mx-2" type="submit" id="submit" name="submit" value="confirm">登録確認</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div><!-- min-h-screen -->

</x-app-layout>
