<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">外注者一覧</div>
    </x-slot>

    <div class="min-h-screen">
        <!-- 検索情報入力 -->
        <div class="mx-2">
            <div class="max-w-xl mx-auto">
                <div class="my-2 px-2 py-2 rounded-lg border-gray-300 border-1 bg-white">
                    <form name="search" class="mx-auto" method="GET" action="{{ route('list.out-soucer.search') }}">
@csrf
                        <div class="input-group">
                            <label for="name_kana" class="col-form-label mx-2">名前検索</label>
                            <input type="search" class="form-control"  pattern="^[ｧ-ﾝﾞﾟ]+$" placeholder="半角カナを入力" value="{{ old('name_kana') }}" id="name_kana" name="name_kana">
                            <button class="btn btn-primary mx-2" type="submit"> 検&emsp;索 </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 検索結果表示 -->
        <div class="mx-2">
            <div class="alert alert-info mt-4 mx-auto max-w-3xl text-center text-sm md:text-xl" role="alert">検索結果：{{ $user_count }}人</div>
        </div>
        <div class="max-w-5xl mx-auto">
            <div class="table-responsive-md mx-2 mt-4 text-nowrap">
                <table class="table table-bordered table-striped table-light table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th></th>
                            <th>ユーザID</th>
                            <th>外注者名</th>
                            <th>外注者名（カナ）</th>
                            <th>メールアドレス</th>
                            <th>状態</th>
                        </tr>
                    </thead>
                    <tbody>
@foreach ($users as $user)
                        <tr>
                            <td>
                                <form name="edit{{ $user->id }}" method="GET" action="{{ route('edit.out-soucer.index') }}">
    @csrf
                                    <input type="hidden" class="form-control" value="{{ $user->id }}" id="user_id" name="user_id">
                                    <div class="text-center">
                                        <button class="btn btn-primary btn-sm" type="submit">編&nbsp;集</button>
                                    </div>
                                </form>
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->name_kana }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_status == 1 ? "有効" : "無効"}}</td>
                        </tr>
@endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- pagenation -->
        <div class="pt-2">{{ $users->appends(Request::all())->links() }}</div>

    </div><!-- min-h-screen -->

</x-app-layout>
