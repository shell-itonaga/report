<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ $postData->user_name }}さん</div>
        <div class="text-sm md:text-lg">日報修正処理確認</div>
    </x-slot>

    <div class="container mt-2 max-w-3xl">
        <div class="alert alert-primary text-center text-xl" role="alert">
            <i class="fas fa-question-circle"></i> 以下の内容で登録します。よろしいですか？
        </div>
    </div>

    <form class="max-w-3xl mx-auto px-3" method="POST">
@csrf
        <div class="form-group py-4 ml-4">

            <input type="hidden" class="form-control" value="{{ $postData->edit_id }}" id="edit_id" name="edit_id">

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
            <div class="row-auto border-bottom">
                <label for="work_type" class="col-form-label">作業分類<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $workType->work_type_name }}</p>
                <input type="hidden" value="{{ $postData->work_type }}" id="work_type" name="work_type">
            </div>


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
                <label for="remarks" class="col-form-label">備&emsp;考<span class="badge bg-secondary mx-2 my-0">必須</span></label>
                <p class="text-xl">{{ $postData->remarks }}</p>
                <input type="hidden" class="form-control" value="{{ $postData->remarks }}"id="remarks" name="remarks">
            </div>

            <div class="d-grid gap-2 d-md-block col-12 text-center my-2">
                <button type="button" class="btn btn-lg btn-primary mx-4 my-2" onclick="history.back()">修&emsp;正</button>
                <button type="submit" name="submit" value="update" class="btn btn-lg btn-primary mx-4 my-2">更&emsp;新</button>
            </div>

        </div><!-- form-Group -->
    </form>

</x-app-layout>
