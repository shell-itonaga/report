<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">作業内容編集</div>
    </x-slot>

    <div class="min-h-screen">
        <!-- 検索情報入力 -->
        <div class="mx-2">
            <div class="max-w-xl mx-auto">
@if (session()->has('is_duplicate'))
                <div class="alert alert-danger max-w-3xl mt-3 mx-auto text-center" role="alert"><i class="fas fa-exclamation-triangle"></i>&nbsp;選択した作業分類・作業区分にて同じ作業内容が登録されています</div>
@endif
                <div class="my-2 px-2 py-2 rounded-lg text-center border-gray-300 border-1 bg-white">
                    <form name="search" class="mx-auto" method="GET" action="{{ route('edit.work-detail.search') }}">
@csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-sm-4">
                                <label for="work_type" class="col-form-label">作業分類</label>
                                <select class="form-select" id="work_type" name="work_type" required>
                                    <option value="0" @if (old('work_type') == 0 || empty(old('work_type'))) selected @endif>未選択</option>
@foreach ($workTypes as $workType)
                                    <option value="{{ $workType->id }}" @if (old('work_type') == $workType->id) selected @endif>{{ $workType->work_type_name }}</option>
@endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="work_class" class="col-form-label">作業区分</label>
                                <select class="form-select" id="work_class" name="work_class">
                                    <option value="0" @if (old('work_class') == 0 || empty(old('work_class'))) selected @endif>未選択</option>
@foreach ($workClasses as $workClass)
                                    <option class="{{ $workClass->work_type_id }}" value="{{ $workClass->id }}" @if (old('work_class') == $workClass->id) selected @endif>{{ $workClass->work_class_name }}</option>
@endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-primary btn-lg" type="submit">絞込み検索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 検索結果表示 -->
        <div class="mx-2">
            <div class="alert alert-info my-4 mx-auto max-w-xl text-center text-lg" role="alert">検索結果：{{ $total_count }}件</div>
        </div>
        <form method="POST" action="{{ route('edit.work-detail.update') }}">
            @csrf
            <div class="mx-2">
                <div class="table-responsive mx-auto text-nowrap text-break max-w-2xl">
                    <table class="table table-sm table-bordered table-striped table-light table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>削除</th>
                                <th>作業分類</th>
                                <th>作業区分</th>
                                <th>作業内容</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // dd($workDetails);
                            @endphp
@foreach ($workDetails as $workDetail)
                            <tr>
                                <!-- 削除ﾁｪｯｸ -->
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="hidden" value="0" name="values[{{ $workDetail->id }}][is_delete]">
                                        <input class="form-check-input" type="checkbox" value="1" name="values[{{ $workDetail->id }}][is_delete]">
                                    </div>
                                </td>
                                <!-- 作業分類 -->
                                <td>{{ $workDetail->work_type_name }}</td>
                                <input type="hidden" name="values[{{ $workDetail->id }}][work_type]" value="{{ $workDetail->work_type_id }}"/>

                                <!-- 作業区分 -->
                                <td>{{ $workDetail->work_class_name }}</td>
                                <input type="hidden" name="values[{{ $workDetail->id }}][work_class]" value="{{ $workDetail->work_class_id }}"/>

                                <!-- 作業内容 -->
                                <td>
                                    <input class="form-control text-sm md:text-lg" type="text" name="values[{{ $workDetail->id }}][work_detail]" value="{{ $workDetail->work_detail_name }}" required>
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
        <div class="pt-2">{{ $workDetails->appends(Request::all())->links() }}</div>

    </div><!-- min-h-screen -->

</x-app-layout>
