<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00008b">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('menu') }}">
            <img src="{{ asset('img/logo_mark.png') }}" alt="" width="30" height="24" class="d-inline-block align-text-top">
            日報管理システム
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('input.index') }}"><i class="fas fa-keyboard"></i>&nbsp;日報入力</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('edit.index') }}"><i class="fas fa-edit"></i>&nbsp;日報修正</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('list.index') }}"><i class="fas fa-list-ol"></i>&nbsp;日報一覧</a>
                </li>
@if (Auth::user()->user_authority < 2)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('summary.index') }}"><i class="fas fa-archive"></i>&nbsp;日報集計</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('manage.index') }}"><i class="fas fa-list-alt"></i>&nbsp;日報管理</a>
                </li>
                <li class="nav-item  dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-address-book"></i>&nbsp;ユーザ一覧</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('employee.list') }}">社員一覧</a></li>
                        <li><a class="dropdown-item" href="{{ route('list.out-soucer.index') }}">外注者一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item  dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i>&nbsp;各種設定</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('employee.insert') }}">社員新規登録</a></li>
                        <li><a class="dropdown-item" href="{{ route('insert.out-soucer.index') }}">外注者新規登録</a></li>
                        <li><a class="dropdown-item" href="{{ route('list.unit-no.index') }}">号機登録・編集</a></li>
                        <li><a class="dropdown-item" href="{{ route('insert.work-class.index') }}">作業区分登録</a></li>
                        <li><a class="dropdown-item" href="{{ route('edit.work-class.index') }}">作業区分編集</a></li>
                        <li><a class="dropdown-item" href="{{ route('insert.work-detail.index') }}">作業内容登録</a></li>
                        <li><a class="dropdown-item" href="{{ route('edit.work-detail.index') }}">作業内容編集</a></li>
                    </ul>
                </li>
@endif
                <li class="nav-item">
                <a class="nav-link" href="{{ route('user-config.index') }}"><i class="fas fa-user-cog"></i>&nbsp;ユーザ設定</a>
                </li>
            </ul>
            <!-- ログアウト -->
            <form class="d-flex" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-primary" onclick="event.preventDefault(); this.closest('form').submit();" type="submit">ログアウト</button>
            </form>
        </div>
    </div>
</nav>
