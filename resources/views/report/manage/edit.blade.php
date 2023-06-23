<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ $selection->user_name }}さん</div>
        <div class="text-sm md:text-lg">日報修正中</div>
    </x-slot>

@if (session()->has('is_duplicated'))
    <div class="text-center mx-2">
        <div class="alert alert-danger max-w-3xl mx-auto mt-2 text-sm md:text-xl" role="alert">同じ内容の日報が既に登録済みです。</div>
    </div>
@endif
<!-- 受注Noと製番の不一致チェックの追加対応 2023/6/23 -->
@if (session()->has('is_not_equal'))
    <div class="text-center mx-2">
        <div class="alert alert-danger max-w-3xl mx-auto mt-2 text-sm md:text-xl" role="alert">受注番号と製番が一致していません。</div>
    </div>
@endif

    <form name="input" class="max-w-3xl mx-auto px-3 needs-validation" novalidate method="POST" action="{{ route('manage.confirm') }}">
@csrf
        <div class="form-group py-4">

            <input type="hidden" class="form-control" value="{{ old('edit_id', $selection->id) }}" id="edit_id" name="edit_id">
            <input type="hidden" class="form-control" value="{{ old('user_id', $selection->user_id) }}" id="user_id" name="user_id">
            <input type="hidden" class="form-control" value="{{ old('user_name', $selection->user_name) }}" id="user_name" name="user_name">

            <div class="row-auto">
                <x-label for="work_date" class="col-form-label">作業日付<span class="badge bg-danger mx-2 my-0">必須</span></x-label>
                <input type="date" class="form-control " max="{{ date('Y-m-d') }}" required value="{{ old('work_date', $selection->work_date) }}" id="work_date" name="work_date">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 日付が指定されていないか、入力値が無効です</div>
            </div>

            <!-- 得意先名 -->
            <div class="row-auto">
                <label for="customer_code" class="col-form-label">得意先名<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-customer select2-form form-select" id="customer_code" name="customer_code" required>
                    <option selected disabled value="">得意先名を選択してください</option>
@foreach ($customers as $customer)
                    <option value="{{ $customer->customer_code }}" @if (old('customer_code', $selection->customer_code) == $customer->customer_code) selected @endif>{{ $customer->customer_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;得意先が選択されていません</div>
            </div>

            <!-- 受注番号 -->
            <div class="row-auto">
                <label for="order_id" class="col-form-label">受注番号<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-order select2-form form-select" id="order_id" name="order_id" required>
                    <option selected value="">受注番号を選択してください</option>
@foreach ($orders as $order)
                    <option data-val="{{ $order->customer_code }}" value="{{ $order->id }}" @if ((empty(old('order_id')) && $selection->order_id == $order->id) || (old('order_id') == $order->id)) selected @endif>{{ $order->order_no.' '.$order->order_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;受注番号が選択されていません</div>
            </div>

            <!-- 製番選択 -->
            <div class="row-auto">
                <label for="serial_id" class="col-form-label">製&emsp;番<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select_serial select2-form form-select" id="serial_id" name="serial_id" required>
                    <option selected value="">製番を選択してください</option>
@foreach ($serialNumbers as $serialNumber)
                    <option data-val="{{ $serialNumber->order_id }}" value="{{ $serialNumber->id }}" @if ((empty(old('serial_id')) && $selection->serial_id == $serialNumber->id) || (old('serial_id') == $serialNumber->id)) selected @endif>{{ $serialNumber->serial_no.' '.$serialNumber->serial_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i>&nbsp;製番が選択されていません</div>
            </div>

            <div class="row-auto">
                <label for="unit_id" class="col-form-label">号&emsp;機<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="form-select" id="unit_id" name="unit_id" required>
                    <option selected disabled value="">号機を選択してください</option>
@foreach ($unitNumbers as $unitNumber)
                    <option value="{{ $unitNumber->id }}" @if (old('unit_id') == $unitNumber->id || $selection->unit_id == $unitNumber->id) selected @endif>{{ $unitNumber->unit_no_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 号機が選択されていません</div>
            </div>

            <div class="row-auto">
                <label for="model_name" class="col-form-label">型　式<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                <input type="text" pattern="^[0-9A-Za-z-_]+$" class="form-control" placeholder="型式を入力してください" autocomplete="on" value="{{ empty(old('model_name')) ? $selection->device_name : old('model_name') }}" id="model_name" name="model_name">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 半角英数字及び「-_」以外は入力できません</div>
            </div>

            <div class="row-auto">
                <label for="unit_name" class="col-form-label">ユニット名<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                <input type="text" pattern="^[0-9A-Za-z-_]+$" class="form-control" placeholder="型式を入力してください" autocomplete="on" value="{{ empty(old('unit_name')) ? $selection->unit_name : old('unit_name') }}" id="unit_name" name="unit_name">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 半角英数字及び「-_」以外は入力できません</div>
            </div>

            <div class="row-auto">
                <label for="work_type" class="col-form-label">作業分類<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-work-type select2-form form-select" id="work_type" name="work_type" required>
                    <option selected disabled value="">作業分類を選択してください</option>
@foreach ($workTypes as $workType)
                    <option value="{{ $workType->id }}" @if ((empty(old('work_type')) && $selection->work_type_id == $workType->id) || old('work_type') == $selection->work_type_id) selected @endif>{{ $workType->work_type_name }}</option>
@endforeach
                </select>
            </div>

            <div class="row-auto">
                <label for="work_class" class="col-form-label">作業区分<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-work-class select2-form form-select" id="work_class" name="work_class" required>
                    <option selected value="">作業区分を選択してください</option>
@foreach ($workClasses as $workClass)
                    <option data-val="{{ $workClass->work_type_id }}" value="{{ $workClass->id }}" @if ((empty(old('work_class')) && $selection->work_class_id == $workClass->id || (old('work_class') == $workClass->id))) selected @endif>{{ $workClass->work_class_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 作業区分が選択されていません</div>
            </div>

            <div class="row-auto">
                <label for="work_detail" class="col-form-label">作業内容<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="select-work-detail select2-form form-select" id="work_detail" name="work_detail" required>
                    <option selected value="">作業内容を選択してください</option>
@foreach ($workDetails as $workDetail)
                    <option data-val="{{ $workDetail->work_class_id }}" value="{{ $workDetail->id }}" @if ((empty(old('work_detail')) && $selection->work_detail_id == $workDetail->id) || old('work_detail') == $workDetail->id) selected @endif>{{ $workDetail->work_detail_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 作業内容が選択されていません</div>
            </div>

            <div class="row-auto">
                <label for="work_time" class="col-form-label">作業時間<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <input type="number" class="form-control" value="{{ empty(old('work_time')) ? $selection->work_time : old('work_time') }}" placeholder="作業時間を0.25h単位で入力してください" min="0.25" step="0.25" required id="work_time" name="work_time">
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 作業時間が入力されていません</div>
            </div>

            <div class="row-auto">
                <label for="remarks" class="col-form-label">備考<span class="badge bg-secondary mx-2 my-0">任意</span></label>
                <textarea class="form-control" rows="3" maxlength="256" placeholder="最大256文字まで入力可能" id="remarks" name="remarks">{{ empty(old('remarks')) ? $selection->remarks : old('remarks') }}</textarea>
            </div>
            <div class="d-grid gap-2 d-md-block text-center mx-auto my-4">
                <button type="button" class="btn btn-lg btn-primary mx-2 my-2" onclick="history.back()">戻&emsp;る</button>
                <button class="btn btn-primary btn-lg mx-2" type="submit" name="submit" id="delete" value="delete">削&emsp;除</button>
                <button class="btn btn-primary btn-lg mx-2" type="submit" name="submit" id="comfirm" value="comfirm">修正確認</button>
            </div>

        </div><!-- form-Group -->
    </form>
</x-app-layout>

