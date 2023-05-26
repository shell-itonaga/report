<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">外注者編集確認</div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container">
            <div class="max-w-xl mx-auto">
                <div class="alert alert-primary mt-2 text-center" role="alert">
                    以下の内容で変更します。よろしいですか？
                  </div>
                <div class="my-2 px-2 py-2 rounded-lg border-gray-300 border-1 bg-white">
                    <form name="input" class="mx-auto" method="POST">
@csrf
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->user_id }}">

                        <div class="col-sm mb-2">
                            <label for="user_name" class="col-form-label">名前<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <input type="text" class="form-control-plaintext" readonly value="{{ $user->user_name }}" id="user_name" name="user_name" required>
                        </div>

                        <div class="col-sm mb-2">
                            <label for="user_name_kana" class="col-form-label">フリガナ<span class="badge bg-danger mx-2 my-0">必須</span></label>
                            <input type="text" class="form-control-plaintext" readonly value="{{ $user->user_name_kana }}" id="user_name_kana" name="user_name_kana" required>
                        </div>

                        <div class="col-sm mb-2">
                            <label for="email" class="col-form-label">メールアドレス<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                            <input type="email" class="form-control-plaintext" readonly value="{{ $user->email }}" id="email" name="email">
                        </div>

                        <div class="col-sm mb-2">
                            <label for="password" class="col-form-label">パスワード<span class="badge bg-secondary mx-2 my-0">任意</span><span class="col-form-label-sm text-primary"></label>
@if(empty($user->password))
                            <div>変更なし</div>
@else
                            <div class="text-primary col-form-label-sm"><i class="fas fa-exclamation-circle"></i>&nbsp;セキュリティ上、パスワードは表示されません</div>
@endif
                            <input type="hidden" class="form-control" value="{{ $user->password }}" id="password" name="password" required>
                        </div>

                        <div class="col-sm mb-2">
                            <label for="user_status" class="col-form-label">ユーザ状態<span class="badge bg-danger mx-2 my-0">必須</span></label>

@if($user->user_status == 1)
                            <p>有効</p>
                            <input type="hidden" name="user_status" id="user_status" value="1">
@else
                            <p>無効</p>
                            <input type="hidden" name="user_status" id="user_status" value="0">
@endif
                        </div>

                        <div class="mx-auto my-2 text-center">
                            <button type="button" class="btn btn-lg btn-primary mx-4 my-2" onclick="history.back()">修&emsp;正</button>
                            <button class="btn btn-primary btn-lg mx-2" type="submit" name="submit" value="update">登&emsp;録</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div><!-- min-h-screen -->

</x-app-layout>
