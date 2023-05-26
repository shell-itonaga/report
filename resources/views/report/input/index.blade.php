<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ Auth::user()->name }}さん【作業者No：{{ Auth::user()->id }}】</div>
        <div class="text-sm md:text-lg">日報入力</div>
    </x-slot>

@if (session()->has('is_duplicated'))
    <div class="text-center mx-2">
        <div class="alert alert-danger max-w-3xl mx-auto mt-2 text-sm md:text-xl" role="alert">同じ内容の日報が既に登録済みです。</div>
    </div>
@endif

    <form name="input" class="max-w-3xl mx-auto px-3 needs-validation" novalidate method="POST" action="{{ route('input.confirm') }}">
@csrf
        <div class="form-group py-4">
            <!-- 日付入力 -->
            <div class="row-auto">
                <x-label for="work_date" class="col-form-label">作業日付<span class="badge bg-danger mx-2 my-0">必須</span></x-label>
                <!-- 一時的に1か月前まで入力可能とする 2012/10/1まで -->
                {{-- <input type="date" class="form-control" max="{{ date('Y-m-d') }}" min="{{ date('Y-m-d', strtotime("-1 week")) }}" required value="{{ empty(old('work_date')) ? date('Y-m-d') : old('work_date') }}" id="work_date" name="work_date"> --}}
                <input type="date" class="form-control" max="{{ date('Y-m-d') }}" min="{{ date('Y-m-d', strtotime("-1 month")) }}" required value="{{ old('work_date', date('Y-m-d')) }}" id="work_date" name="work_date">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;日付が指定されていないか、入力値が無効です</div>
            </div>

            <!-- 得意先名 -->
            <div class="row-auto">
                <label for="customer_code" class="col-form-label">得意先名<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-customer select2-form form-select" id="customer_code" name="customer_code" required>
                    <option value="" disabled selected="selected">得意先名を選択してください</option>
@foreach ($customers as $customer)
                    <option value="{{ $customer->customer_code }}" @if (old('customer_code') == $customer->customer_code) selected @endif>{{ $customer->customer_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;得意先が選択されていません</div>
            </div>

            <!-- 受注番号 -->
            <div class="row-auto">
                <label for="order_id" class="col-form-label">受注番号<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-order select2-form form-select" id="order_id" name="order_id" required>
                    <option value="" selected="selected">受注番号を選択してください</option>
@foreach ($orders as $order)
                    <option data-val="{{ $order->customer_code }}" value="{{ $order->id }}" @if (old('order_id') == $order->id) selected @endif>{{ $order->order_no.'　'.$order->order_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;受注番号が選択されていません</div>
            </div>

            <!-- 製番選択 -->
            <div class="row-auto">
                <label for="serial_id" class="col-form-label">製&emsp;番<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select_serial select2-form form-select" id="serial_id" name="serial_id" required>
                    <option value="" selected="selected">製番を選択してください</option>
@foreach ($serialNumbers as $serialNumber)
                    <option data-val="{{ $serialNumber->order_id }}" value="{{ $serialNumber->id }}" @if (old('serial_id') == $serialNumber->id) selected @endif>{{ $serialNumber->serial_no.'　'.$serialNumber->serial_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;製番が選択されていません</div>
            </div>

            <!-- 号機選択 -->
            <div class="row-auto">
                <label for="unit_id" class="col-form-label">号&emsp;機<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="form-select" id="unit_id" name="unit_id" required>
                    <option selected disabled value="">号機を選択してください</option>
@foreach ($unitNumbers as $unitNumber)
                    <option value="{{ $unitNumber->id }}" @if (old('unit_id') == $unitNumber->id) selected @endif>{{ $unitNumber->unit_no_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;号機が選択されていません</div>
            </div>

            <!--  型式入力 -->
            <div class="row-auto">
                <label for="model_name" class="col-form-label">型　式<span class="badge bg-secondary mx-2 my-0">任意</span><span class="text-gray-400">半角英数字、半角カナ及び記号「-_」のみ入力可能</span></label>
                <input type="text" pattern="^[ｧ-ﾝﾞﾟ0-9A-Za-z-_]+$" class="form-control " placeholder="型式を入力してください" value="{{ old('model_name') }}" id="model_name" name="model_name">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;半角英数字、半角カナ及び「-_」以外は入力できません</div>
            </div>

            <!-- ユニット名入力 -->
            <div class="row-auto">
                <label for="unit_name" class="col-form-label">ユニット名<span class="badge bg-secondary mx-2 my-0">任意</span><span class="text-gray-400">半角英数字、半角カナ及び記号「-_」のみ入力可能</span></label>
                <input type="text" pattern="^[ｧ-ﾝﾞﾟ0-9A-Za-z-_]+$" class="form-control " placeholder="ユニット名を入力してください" value="{{ old('unit_name') }}" id="unit_name" name="unit_name">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;半角英数字、半角カナ及び「-_」以外は入力できません</div>
            </div>

            <!-- 作業分類選択 -->
            <div class="row-auto">
                <label for="work_type" class="col-form-label">作業分類<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-work-type select2-form form-select" id="work_type" name="work_type" required>
                    <option value="" selected="selected">作業分類を選択してください</option>
@foreach ($workTypes as $workType)
                    <option value="{{ $workType->id }}" @if (old('work_type') == $workType->id) selected @endif>{{ $workType->work_type_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;作業分類が選択されていません</div>
            </div>

            <!-- 作業区分選択 -->
            <div class="row-auto">
                <label for="work_class" class="col-form-label">作業区分<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-work-class select2-form form-select" id="work_class" name="work_class" required>
                    <option value="" selected="selected">作業区分を選択してください</option>
@foreach ($workClasses as $workClass)
                    <option data-val="{{ $workClass->work_type_id }}" value="{{ $workClass->id }}" @if (old('work_class') == $workClass->id) selected @endif>{{ $workClass->work_class_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;作業区分が選択されていません</div>
            </div>

            <!-- 作業内容選択 -->
            <div class="row-auto">
                <label for="work_detail" class="col-form-label">作業内容<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-work-detail select2-form form-select" id="work_detail" name="work_detail" required>
                    <option value="" selected="selected">作業内容を選択してください</option>
@foreach ($workDetails as $workDetail)
                    <option data-val="{{ $workDetail->work_class_id }}" value="{{ $workDetail->id }}" @if (old('work_detail') == $workDetail->id) selected @endif>{{ $workDetail->work_detail_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 作業内容が選択されていません</div>
            </div>

            <!-- 作業時間入力 -->
            <div class="row-auto">
                <label for="work_time" class="col-form-label">作業時間<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <input type="number" class="form-control" value="{{ old('work_time') }}" placeholder="作業時間を0.25h単位で入力してください" min="0.25" step="0.25" required id="work_time" name="work_time">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 作業時間が未入力、または不正な値がされています</div>
            </div>

            <!-- 備考入力 -->
            <div class="row-auto">
                <label for="remarks" class="col-form-label">備考<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                <textarea class="form-control" rows="3" maxlength="256" placeholder="最大256文字まで入力可能" id="remarks" name="remarks">{{ old('remarks') }}</textarea>
            </div>

            <div class="d-grid gap-2 d-md-block text-center mx-auto my-4">
                <a class="btn btn-danger btn-lg mx-2" href="{{ route('menu') }}" role="button">キャンセル</a>
                <button class="btn btn-primary btn-lg mx-2" type="submit" name="comfirm" value="comfirm">登録確認</button>
            </div>

        </div><!-- form-Group -->
    </form>

    <!-- 本日分の登録状況表示 -->
    <p class="registed mx-4 text-lg">登録状況（{{ date('Y年m月d日') }}分）</p>
    <div class="table-responsive mx-4">
        <table class="table table-bordered table-striped table-info text-nowrap">
            <thead>
                <tr>
                    <th scope="col ">得意先名</th>
                    <th scope="col ">受注番号</th>
                    <th scope="col ">受注品名</th>
                    <th scope="col ">製番</th>
                    <th scope="col ">製番品名</th>
                    <th scope="col ">号機</th>
                    <th scope="col ">型式</th>
                    <th scope="col ">ユニット名</th>
                    <th scope="col ">作業分類</th>
                    <th scope="col ">作業区分</th>
                    <th scope="col ">作業内容</th>
                    <th scope="col ">作業時間</th>
                    <th scope="col ">備考</th>
                </tr>
            </thead>
            <tbody>
@php $totalTime = 0; @endphp
@foreach ($timeDetailViews as $timeDetailView)
@php $totalTime += $timeDetailView->work_time; @endphp
            <tr>
                <td scope="row">{{ $timeDetailView->customer_name }}</td>
                <td>{{ $timeDetailView->order_no }}</td>
                <td>{{ $timeDetailView->order_name }}</td>
                <td>{{ $timeDetailView->serial_no }}</td>
                <td>{{ $timeDetailView->serial_name }}</td>
                <td>{{ $timeDetailView->unit_no_name }}</td>
                <td>{{ $timeDetailView->device_name }}</td>
                <td>{{ $timeDetailView->unit_name }}</td>
                <td>{{ $timeDetailView->work_type_name }}</td>
                <td>{{ $timeDetailView->work_class_name }}</td>
                <td>{{ $timeDetailView->work_detail_name }}</td>
                <td>{{ sprintf("%.2f", $timeDetailView->work_time) }}</td>
                <td>{{ $timeDetailView->remarks }}</td>
            </tr>
@endforeach
            </tbody>
        </table>
    </div><!-- table-responsive -->

    <div class="alert {{ ($totalTime >= 8.0) ? "alert-info" : "alert-danger" }} text-center mx-4" role="alert">
        <span class="text-base md:text-2xl text-bold">合計作業時間：{{ sprintf("%.2f", $totalTime)."h" }}</span>
@if(($totalTime < 8.0))
    <br><span class="text-sm md:text-base"><i class="fas fa-exclamation-triangle"></i>&nbsp;合計作業時間が8.0h未満です</span>
@endif
    </div>
</x-app-layout>
