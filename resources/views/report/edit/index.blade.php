<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ Auth::user()->name }}さん【作業者No：{{ Auth::user()->id }}】</div>
        <div class="text-sm md:text-lg">日報修正</div>
    </x-slot>

    <div class="min-h-screen">
        <!-- 検索日付入力 -->
        <div class="mx-2">
            <div class="max-w-lg mx-auto">
                <div class="my-2 px-2 py-2 rounded-lg border-gray-300 border-1 bg-white">
                    <form name="input" class="mx-auto" method="GET" action="{{ route('edit.search') }}">
@csrf
                        <label for="date_edit" class="col-form-label mr-2"><i class="fas fa-info-circle text-blue-700"></i> 日付を選択して下さい（７日前まで選択可）</label>
                        {{-- <input type="date" class="form-control" min="{{ date('Y-m-d', strtotime("-1 week")) }}" max="{{ date('Y-m-d') }}" value="{{ empty(old('date_edit')) ? date('Y-m-d') : old('date_edit') }}" id="date_edit" name="date_edit" required> --}}
                        <input type="date" class="form-control" min="{{ date('Y-m-d', strtotime("-1 month")) }}" max="{{ date('Y-m-d') }}" value="{{ empty(old('date_edit')) ? date('Y-m-d') : old('date_edit') }}" id="date_edit" name="date_edit" required>
                        <div class="mx-auto mt-4 text-center">
                            <button class="btn btn-primary btn-lg mx-2" type="submit"> 検&emsp;索 </button>
                        </div>
                    </form>
                </div>

            </div>
@if(Session::has('is_no_data'))
            <div class="alert alert-danger text-center max-w-xl my-4 mx-auto text-sm md:text-lg" role="alert">
                <i class="fas fa-exclamation-triangle"></i>&nbsp;{{ session('is_no_data') }}
            </div>
@elseif ($listCount > 0)
            <div class="alert alert-info mt-4 mx-auto max-w-2xl text-center text-lg" role="alert">
                <i class="fas fa-info-circle"></i>&nbsp;該当レコード数：{{ $listCount }}件
            </div>
            <!-- 検索結果表示 -->
            <div class="table-responsive-md mx-2 mt-4 text-nowrap">
                <table class="table table-bordered table-striped table-light table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th></th>
                            <th>作業日</th>
                            <th>得意先名</th>
                            <th>受注番号</th>
                            <th>受注品名</th>
                            <th>製番</th>
                            <th>製番品名</th>
                            <th>号機</th>
                            <th>型式</th>
                            <th>ユニット名</th>
                            <th>作業分類</th>
                            <th>作業区分</th>
                            <th>作業内容</th>
                            <th>作業時間</th>
                            <th>備考</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach ($TimeDetailViews as $TimeDetailView)
                        <tr>
                            <td>
                                <form name="edit" method="GET" action="{{ route('edit.fix')}}">
        @csrf
                                    <input type="hidden" class="form-control" value="{{ $TimeDetailView->id }}" id="edit_id" name="edit_id">
                                    <div class="text-center">
                                        <button class="btn btn-primary btn-sm" type="submit">修&nbsp;正</button>
                                    </div>
                                </form>
                            </td>
                            <td>{{ $TimeDetailView->work_date }}</td>
                            <td>{{ $TimeDetailView->customer_name }}</td>
                            <td>{{ $TimeDetailView->order_no }}</td>
                            <td>{{ $TimeDetailView->order_name }}</td>
                            <td>{{ $TimeDetailView->serial_no }}</td>
                            <td>{{ $TimeDetailView->serial_name }}</td>
                            <td>{{ $TimeDetailView->unit_no_name }}</td>
                            <td>{{ $TimeDetailView->device_name }}</td>
                            <td>{{ $TimeDetailView->unit_name }}</td>
                            <td>{{ $TimeDetailView->work_type_name }}</td>
                            <td>{{ $TimeDetailView->work_class_name }}</td>
                            <td>{{ $TimeDetailView->work_detail_name }}</td>
                            <td>{{ sprintf("%.2f", $TimeDetailView->work_time).'h' }}</td>
                            <td>{{ $TimeDetailView->remarks }}</td>
                        </tr>
    @endforeach
                    </tbody>
                </table>
            </div>
@endif
        </div>

    </div><!-- min-h-screen -->

</x-app-layout>
