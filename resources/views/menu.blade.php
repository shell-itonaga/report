<x-app-layout>
    <x-slot name="header">
        <div class="text-sm md:text-xl">{{ Auth::user()->name }}さん【作業者No：{{ Auth::user()->id }}】</div>
    </x-slot>

    <!-- 通常メニュー -->
    <div class="container my-4">
        <div class="row">
            <div class="mx-1">
                <div class="alert alert-info text-center text-sm md:text-lg" role="alert"><i class="fas fa-info-circle"></i> 実行するメニューをクリックしてください</div>
            </div>
            <!-- メニューボタン -->
            <div class="d-grid gap-2 d-md-block col-12 text-center my-3">
                <a class="btn btn-lg btn-primary btn-wide m-2 text-nowrap" href="{{ route('input.index') }}">日報入力</a>
                <a class="btn btn-lg btn-primary btn-wide m-2 text-nowrap" href="{{ route('edit.index') }}">日報修正</a>
                <a class="btn btn-lg btn-primary btn-wide m-2 text-nowrap" href="{{ route('list.index') }}">日報一覧</a>
                <a class="btn btn-lg btn-primary btn-wide m-2 text-nowrap" href="{{ route('user-config.index') }}">ユーザ設定</a>
            </div>
        </div>
@if (Auth::user()->user_authority < 2)
        <!-- 管理者用メニュー -->
        <div class="row-auto mt-3">
            <div class="d-grid gap-2 d-md-block col-12 text-center">
                <a class="btn btn-lg btn-success btn-wide m-2" href="{{ route('summary.index') }}">日報集計</a>
                <a class="btn btn-lg btn-success btn-wide m-2" href="{{ route('manage.index') }}">日報管理</a>
                <button id="config" type="button" class="btn btn-lg btn-success btn-wide m-2 text-nowrap dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">ユーザ一覧</button>
                <ul class="dropdown-menu" aria-labelledby="user-list">
                    <li><a class="dropdown-item" href="{{ route('employee.list') }}">社員一覧</a></li>
                    <li><a class="dropdown-item" href="{{ route('list.out-soucer.index') }}">外注者一覧</a></li>
                </ul>
                <button id="config" type="button" class="btn btn-lg btn-success btn-wide m-2 text-nowrap dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">各種設定</button>
                <ul class="dropdown-menu" aria-labelledby="config">
                    <li><a class="dropdown-item" href="{{ route('employee.insert') }}">社員新規登録</a></li>
                    <li><a class="dropdown-item" href="{{ route('insert.out-soucer.index') }}">外注者新規登録</a></li>
                    <li><a class="dropdown-item" href="{{ route('list.unit-no.index') }}">号機登録・編集</a></li>
                    <li><a class="dropdown-item" href="{{ route('insert.work-class.index') }}">作業区分登録</a></li>
                    <li><a class="dropdown-item" href="{{ route('edit.work-class.index') }}">作業区分編集</a></li>
                    <li><a class="dropdown-item" href="{{ route('insert.work-detail.index') }}">作業内容登録</a></li>
                    <li><a class="dropdown-item" href="{{ route('edit.work-detail.index') }}">作業内容編集</a></li>
                </ul>

                </div>
            </div>
        </div>
@endif
    </div>

</x-app-layout>
