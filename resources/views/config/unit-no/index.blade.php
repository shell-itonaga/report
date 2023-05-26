<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">号機登録・編集</div>
    </x-slot>

    <div class="min-h-screen">
@if(session('is_error') == true)
        <div class="mx-2">
            <div class="alert alert-danger mt-4 mx-auto max-w-lg text-center text-lg" role="alert">
                <i class="fas fa-exclamation-circle"></i>&nbsp;号機名称が重複しているため、登録できません。
            </div>
        </div>
@endif
        <!-- 検索情報入力 -->
        <div class="mx-2">
            <div class="max-w-xl mx-auto">
                <div class="my-2 px-2 py-2 rounded-lg border-gray-300 border-1 bg-white">
                    <form name="search" class="mx-auto" method="GET" action="{{ route('list.unit-no.search') }}">
@csrf
                        <div class="input-group">
                            <label for="unit_name" class="col-form-label mx-2">号機名検索</label>
                            <input type="search" class="form-control" placeholder="号機名を入力してください" value="{{ old('unit_name') }}" id="unit_name" name="unit_name">
                            <button class="btn btn-primary btn-lg mx-2" type="submit"> 検&emsp;索 </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 検索結果表示 -->
        <div class="mx-2">
            <div class="alert alert-info mt-4 mx-auto max-w-lg text-center text-lg" role="alert">検索結果：{{ $total_count }}件</div>
        </div>
        <form class="needs-validation" novalidate method="POST" action="{{ route('list.unit-no.upsert') }}">
            @csrf
            <div class="table-responsive-md mx-auto mt-4 text-center max-w-lg">
                <table class="table table-bordered table-striped table-light table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>削除</th>
                            <th>号機名</th>
                        </tr>
                    </thead>
                    <tbody>
@foreach ($unitNumbers as $unitNumber)
                        <tr>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="hidden" value="0" name="values[{{ $unitNumber->id }}][is_delete]">
                                    <input class="form-check-input" type="checkbox" value="1" name="values[{{ $unitNumber->id }}][is_delete]">
                                </div>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="values[{{ $unitNumber->id }}][unit_no_name]" value="{{ $unitNumber->unit_no_name }}" required>
                                <div class="invalid-feedback bg-red-200 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;空欄は入力不可。不要な場合は削除をONにしてください</div>
                            </td>
                    </tr>
@endforeach
                    </tbody>
                </table>
                <div class="mx-auto text-center">
                    <a class="btn btn-lg btn-primary my-2 mx-2" href="{{ route('menu') }}">戻&emsp;る</a>
                    <button class="btn btn-primary btn-lg mx-2" type="button" id="addRow"> 行追加 </button>
                    <button class="btn btn-primary btn-lg mx-2" type="submit" id="send"> 登&emsp;録 </button>
                </div>
            </div>
        </form>
        <!-- pagenation -->
        <div class="pt-2">{{ $unitNumbers->appends(Request::all())->links() }}</div>

    </div><!-- min-h-screen -->

</x-app-layout>
