<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">外注者新規登録確認</div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container">
            <div class="max-w-xl mx-auto">
                <div class="alert alert-primary mt-2 text-center" role="alert">
                    以下の内容で登録が完了しました。
                  </div>
                <div class="my-2 px-2 py-2 rounded-lg border-gray-300 border-1 bg-white">

                    <div class="col-sm mb-2">
                        <label for="user_name" class="col-form-label">ユーザID</label>
                        <div>{{ $user_id }}</div>
                    </div>

                    <div class="col-sm mb-2">
                        <label for="user_name" class="col-form-label">名前</label>
                        <div>{{ $postData->user_name }}</div>
                    </div>

                    <div class="col-sm mb-2">
                        <label for="user_name_kana" class="col-form-label">フリガナ</label>
                        <div>{{ $postData->user_name_kana }}</div>
                    </div>

                    <div class="col-sm mb-2">
                        <label for="email" class="col-form-label">メールアドレス</label>
                        <div>{{ $postData->email }}</div>
                    </div>

                    <div class="col-sm mb-2">
                        <label for="password" class="col-form-label">パスワード</label>
                            <div class="text-primary col-form-label-sm"><i class="fas fa-exclamation-circle"></i>&nbsp;セキュリティ上、パスワードは表示されません</div>
                    </div>

                    <div class="col-sm mb-2">
                        <label for="user_status" class="col-form-label">ユーザ状態</label>
@if($postData->user_status == true)
                        <div>有効</div>
@else
                        <div>無効</div>
@endif
                    </div>

                    <div class="text-center my-5">
                        <a class="btn btn-lg btn-success btn-wide" href="{{ route('menu') }}">TOPに戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- min-h-screen -->
</x-app-layout>
