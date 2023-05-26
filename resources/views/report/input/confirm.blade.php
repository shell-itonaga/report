<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ Auth::user()->name }}さん【作業者No：{{ Auth::user()->id }}】</div>
    </x-slot>

    <div class="container mt-2">
        <div class="alert alert-primary text-center text-xl" role="alert">
            <i class="fas fa-question-circle"></i> 以下の内容で登録します。よろしいですか？
        </div>
    </div>

    <form class="max-w-3xl mx-auto px-3" method="POST">
@csrf
        <div class="form-group py-4 ml-4">

            <div class="row-auto border-bottom">
                <x-label for="work_date" class="col-form-label">作業日付<span class="badge bg-danger mx-2 my-0">必須</span></x-label>
                <p class="text-xl">{{ $postData->work_date }}</p>
                <input type="hidden" class="form-control" value="{{ $postData->work_date }}" id="work_date" name="work_date">
            </div>

            <div class="row-auto border-bottom">
                <label for="customer_code" class="col-form-label">得意先名<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $customer->customer_name }}</p>
                <input type="hidden" value="{{ $postData->customer_code }}" id="customer_code" name="customer_code">
            </div>

            <div class="row-auto border-bottom">
                <label for="order_id" class="col-form-label">受注番号<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $order->order_no."【".$order->order_name."】" }}</p>
                <input type="hidden" value="{{ $postData->order_id }}" id="order_id" name="order_id">
            </div>

            <div class="row-auto border-bottom">
                <label for="serial_id" class="col-form-label">製&emsp;番<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $serialNumber->serial_no."【".$serialNumber->serial_name."】" }}</p>
                <input type="hidden" value="{{ $postData->serial_id }}" id="serial_id" name="serial_id">
            </div>

            <div class="row-auto border-bottom">
                <label for="unit_id" class="col-form-label">号&emsp;機<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $unitNumber->unit_no_name }}</p>
                <input type="hidden" value="{{ $postData->unit_id }}" id="unit_id" name="unit_id">
            </div>

            <div class="row-auto border-bottom">
                <label for="model_name" class="col-form-label">型&emsp;式<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                <p class="text-xl">{{ $postData->model_name }}</p>
                <input type="hidden" pattern="^[0-9A-Za-z-_]+$" class="form-control" value="{{ $postData->model_name }}" id="model_name" name="model_name">
            </div>

            <div class="row-auto border-bottom">
                <label for="unit_name" class="col-form-label">ユニット名<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                <p class="text-xl">{{ $postData->unit_name }}</p>
                <input type="hidden" class="form-control" value="{{ $postData->unit_name }}" id="unit_name" name="unit_name">
            </div>

            <input type="hidden" value="{{ $postData->work_type }}" id="work_type" name="work_type">

            <div class="row-auto border-bottom">
                <label for="work_class" class="col-form-label">作業区分<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $workClass->work_class_name }}</p>
                <input type="hidden" value="{{ $postData->work_class }}" id="work_class" name="work_class">
            </div>

            <div class="row-auto border-bottom">
                <label for="work_detail" class="col-form-label">作業内容<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $workDetail->work_detail_name }}</p>
                <input type="hidden" value="{{ $postData->work_detail }}" id="work_detail" name="work_detail">
            </div>

            <div class="row-auto border-bottom">
                <label for="work_time" class="col-form-label">作業時間<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ sprintf('%.2fh', $postData->work_time) }}</p>
                <input type="hidden" class="form-control" value="{{ $postData->work_time }}"id="work_time" name="work_time">
            </div>

            <div class="row-auto border-bottom">
                <label for="remarks" class="col-form-label">備&emsp;考<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                <p class="text-xl">{{ $postData->remarks }}</p>
                <input type="hidden" class="form-control" value="{{ $postData->remarks }}"id="remarks" name="remarks">
            </div>

            <div class="d-grid gap-2 d-md-block col-12 text-center my-2">
                <button type="button" class="btn btn-lg btn-success mx-4 my-2" onclick="history.back()">修&emsp;正</button>
                <button type="submit" name="insert" value="insert" class="btn btn-lg btn-primary mx-4 my-2">登&emsp;録</button>
            </div>

        </div><!-- form-Group -->
    </form>

    <p class="registed mx-4 text-lg">登録状況（{{ date('Y年m月d日') }}分）<br><span class="text-red-500"><i class="fas fa-exclamation-circle"></i>過去の日付で入力した場合、下記は表示されません</span></p>
    <div class="table-responsive mx-4">
        <table class="table table-bordered table-striped table-success text-nowrap">
            <thead>
                <tr>
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
<!-- 登録済情報の表示 -->
@foreach ($timeDetailViews as $timeDetailView)
    @if ($timeDetailView->work_date = date('Y-m-d'))
        @php $totalTime += $timeDetailView->work_time; @endphp
            <tr>
                <td scope="row">{{ $timeDetailView->order_no }}</td>
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
    @endif
@endforeach
<!-- 新規登録情報の表示 -->
@if ($postData->work_date == date('Y-m-d'))
            <tr>
                <td scope="row">{{ $order->order_no }}</td>
                <td>{{ $order->order_name }}</td>
                <td>{{ $serialNumber->serial_no }}</td>
                <td>{{ $serialNumber->serial_name }}</td>
                <td>{{ $unitNumber->unit_no_name }}</td>
                <td>{{ $postData->model_name }}</td>
                <td>{{ $postData->unit_name }}</td>
                <td>{{ $workType->work_type_name }}</td>
                <td>{{ $workClass->work_class_name }}</td>
                <td>{{ $workDetail->work_detail_name }}</td>
                <td>{{ sprintf("%.2f", $postData->work_time) }}</td>
@php $totalTime += $postData->work_time @endphp
                <td>{{ $postData->remarks }}</td>
            </tr>
@endif
            </tbody>
        </table>
    </div>
    <div class="alert {{ ($totalTime >= 8.0) ? "alert-info" : "alert-danger" }} text-center mx-4 mt-2" role="alert">
        <span class="text-2xl text-bold">合計作業時間：{{ sprintf("%.2f", $totalTime)."h" }}</span>
@if(($totalTime < 8.0))
    <br><span><i class="fas fa-exclamation-triangle"></i>合計作業時間が8.0h未満です</span>
@endif
    </div>

</x-app-layout>
