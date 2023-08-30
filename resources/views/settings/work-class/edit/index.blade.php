<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">作業区分編集</div>
    </x-slot>

    <div class="min-h-screen">
@if (session()->has('is_duplicate'))
        <div class="alert alert-danger max-w-3xl mt-3 mx-auto text-center" role="alert">
            <i class="fas fa-exclamation-triangle"></i>&nbsp;編集した作業分類にて同じ作業区分名が登録済みです
        </div>
@endif
        <!-- 検索情報入力 -->
        <div class="mx-2">
            <div class="max-w-xl mx-auto">
                <div class="my-2 px-2 py-2 rounded-lg text-center border-gray-300 border-1 bg-white">
                    <form name="search" class="mx-auto" method="GET" action="{{ route('edit.work-class.search') }}">
@csrf
                        <div><label for="unit_name" class="col-form-label">作業分類で絞り込み</label></div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="workType" id="workType1" value="1">
                            <label class="form-check-label text-lg" for="workType1">製造</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="workType" id="workType2" value="2">
                            <!-- <label class="form-check-label text-lg" for="workType2">電気設計</label> -->
                            <label class="form-check-label text-lg" for="workType2">設計</label>
                        </div>
                        <!-- <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="workType" id="workType3" value="3">
                            <label class="form-check-label text-lg" for="workType3">機械設計</label>
                        </div> -->
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="workType" id="workType4" value="4">
                            <label class="form-check-label text-lg" for="workType4">基板</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="workType" id="workType3" value="3">
                            <label class="form-check-label text-lg" for="workType3">間接業務</label>
                        </div>
                        <div>
                            <button class="btn btn-primary mx-auto my-1" type="submit"><i class="fas fa-search"></i>&nbsp;検&nbsp;索</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 検索結果表示 -->
        <div class="mx-2">
            <div class="alert alert-info mt-4 mx-auto max-w-xl text-center text-lg" role="alert">検索結果：{{ $total_count }}件</div>
        </div>
        <form method="POST" action="{{ route('edit.work-class.update') }}">
            @csrf
            <div class="mx-2">
                <div class="table-responsive-md mx-auto mt-4 text-nowrap max-w-xl">
                    <table class="table table-bordered table-striped table-light table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>削除</th>
                                <th>作業分類</th>
                                <th>作業区分</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach ($workClasses as $workClass)
                            <tr>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="hidden" value="0" name="values[{{ $workClass->id }}][is_delete]">
                                        <input class="form-check-input" type="checkbox" value="1" name="values[{{ $workClass->id }}][is_delete]">
                                    </div>
                                </td>
                                <td>
                                    <select class="form-select text-lg sm:text-xs" name="values[{{ $workClass->id }}][work_type_id]" required>
    @foreach ($workTypes as $workType)
                                        <option value="{{ $workType->id }}" @if ($workType->id == $workClass->work_type_id) selected  @endif>{{ $workType->work_type_name }}</option>
    @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control text-lg sm:text-xs" type="text" name="values[{{ $workClass->id }}][work_class_name]" value="{{ $workClass->work_class_name }}" required>
                                </td>
                        </tr>
@endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a class="btn btn-lg btn-primary mx-4 my-2" href="{{ route('menu') }}">戻&emsp;る</a>
                        <button class="btn btn-primary btn-lg mx-2" type="submit" id="send"> 更&emsp;新 </button>
                    </div>
                </div>
            </div>
        </form>
        <!-- pagenation -->
        <div class="pt-2">{{ $workClasses->appends(Request::all())->links() }}</div>

    </div><!-- min-h-screen -->

</x-app-layout>
