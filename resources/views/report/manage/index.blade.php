<x-app-layout>

    <x-slot name="header">
        <div class="text-sm md:text-lg">日報管理</div>
    </x-slot>

    <div class="min-h-screen">
        <!-- 集計用検索条件 -->
        <div class="accordion max-w-3xl mx-auto pt-2" id="accordionPanels">
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsOpen-heading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsOpen-collapse" aria-expanded="true" aria-controls="panelsOpen-collapse">
                    絞り込み検索条件
                    </button>
                </h2>
                <div id="panelsOpen-collapse" class="accordion-collapse collapse show" aria-labelledby="panelsOpen-heading">
                    <div class="accordion-body">
                        <form name="input" class="mx-auto" method="GET" action="{{ route('manage.search') }}">
@csrf
                            <div class="row g-3 align-items-center">
                                <div class="col-sm-4">
                                    <label for="name_kana" class="col-form-label">作業者名</label>
                                    <input type="search" class="form-control" pattern="^[ｧ-ﾝﾞﾟ]+$" placeholder="半角カナで入力" title="半角カナで入力して下さい" value="{{ old('name_kana') }}" id="name_kana" name="name_kana">
                                </div>
                                <div class="col-sm-4">
                                    <label for="date_from" class="col-form-label">作業日付(From)</label>
                                    <input type="date" class="form-control date" max="{{ date('Y-m-d') }}" value="{{ old('date_from') }}" id="date_from" name="date_from">
                                </div>
                                <div class="col-sm-4">
                                    <label for="date_to" class="col-form-label">作業日付(To)</label>
                                    <input type="date" class="form-control date" max="{{ date('Y-m-d') }}" value="{{ old('date_to') }}" id="date_to" name="date_to">
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-sm-12">
                                    <label for="customer_code" class="col-form-label">得意先名</label>
                                    <select class="select-customer select2-form form-select" id="customer_code" name="customer_code">
                                        <option value="0" selected>未選択</option>
@foreach ($customers as $customer)
                                        <option value="{{ $customer->customer_code }}" @if (old('customer_code') == $customer->customer_code) selected @endif>{{ $customer->customer_name }}</option>
@endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-sm-12">
                                    <label for="order_id" class="col-form-label">受注番号</label>
                                    <select class="select-order select2-form form-select" id="order_id" name="order_id">
                                        <option value="0" selected>未選択</option>
@foreach ($orders as $order)
                                        <option data-val="{{ $order->customer_code }}" value="{{ $order->id }}" @if (old('order_id') == $order->id) selected @endif>{{ $order->order_no.'　'.$order->order_name }}</option>
@endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-sm-12">
                                    <label for="serial_id" class="col-form-label">製&emsp;番</label>
                                    <select class="select_serial select2-form form-select" id="serial_id" name="serial_id">
                                        <option value="0" selected>未選択</option>
@foreach ($serialNumbers as $serialNumber)
                                        <option data-val="{{ $serialNumber->order_id }}" value="{{ $serialNumber->id }}" @if (old('serial_id') == $serialNumber->id) selected @endif>{{ $serialNumber->serial_no.' '.$serialNumber->serial_name }}</option>
@endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-sm-3">
                                    <label for="unit_id" class="col-form-label">号&emsp;機</label>
                                    <select class="form-select" id="unit_id" name="unit_id">
                                        <option value="0" selected>未選択</option>
@foreach ($unitNumbers as $unitNumber)
                                        <option value="{{ $unitNumber->id }}" @if (old('unit_id') == $unitNumber->id) selected @endif>{{ $unitNumber->unit_no_name }}</option>
@endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="work_type" class="col-form-label">作業分類</label>
                                    <select class="select-work-type select2-form form-select" id="work_type" name="work_type">
                                        <option value="0" selected>未選択</option>
@foreach ($workTypes as $workType)
                                        <option value="{{ $workType->id }}" @if (old('work_type') == $workType->id) selected @endif>{{ $workType->work_type_name }}</option>
@endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="work_class" class="col-form-label">作業区分</label>
                                    <select class="select-work-class select2-form form-select" id="work_class" name="work_class">
                                        <option value="0" selected>未選択</option>
@foreach ($workClasses as $workClass)
                                        <option data-val="{{ $workClass->work_type_id }}" value="{{ $workClass->id }}" @if (old('work_class') == $workClass->id) selected @endif>{{ $workClass->work_class_name }}</option>
@endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="work_detail" class="col-form-label">作業内容</label>
                                    <select class="select-work-detail select2-form form-select" id="work_detail" name="work_detail">
                                        <option value="0" selected>未選択</option>
@foreach ($workDetails as $workDetail)
                                        <option data-val="{{ $workDetail->work_class_id }}" value="{{ $workDetail->id }}" @if (old('work_detail') == $workDetail->id) selected @endif>{{ $workDetail->work_detail_name }}</option>
@endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mx-auto mt-4 text-center">
                                <a href="{{ route('manage.index') }}"><button class="btn btn-primary btn-lg mx-2" type="button"> クリア </button></a>
                                <button class="btn btn-primary btn-lg mx-2" type="submit"> 検&emsp;索 </button>
                            </div>
                        </form>

                    </div><!-- accordion-body -->
                </div><!-- accordion-collapse -->
            </div><!-- accordion-item -->
        </div><!-- accordion -->

@if(count($summarys) > 0)
        <!-- 検索結果表示 -->
        <div class="alert alert-info mt-4 mx-auto max-w-3xl text-center text-sm md:text-2xl" role="alert">該当全レコード数：{{ session('total_count') }}件</div>
        <div class="table-responsive-md mx-4 mt-4 text-nowrap">
            <table class="table table-bordered table-striped table-light table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th></th>
                        <th>作業者</th>
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
    @foreach ($summarys as $summary)
                    <tr>
                        <td>
                            <form method="GET" action="{{ route('manage.edit') }}">
                                @csrf
                                <input type="hidden" id="edit_id" name="edit_id" value="{{ $summary->id }}">
                                <button class="btn btn-primary btn-sm" type="submit" name="submit" value="edit">編集</button>
                            </form>
                        </td>
                        <td>{{ $summary->name }}</td>
                        <td>{{ $summary->work_date }}</td>
                        <td>{{ $summary->customer_name }}</td>
                        <td>{{ $summary->order_no }}</td>
                        <td>{{ $summary->order_name }}</td>
                        <td>{{ $summary->serial_no }}</td>
                        <td>{{ $summary->serial_name }}</td>
                        <td>{{ $summary->unit_no_name }}</td>
                        <td>{{ $summary->device_name }}</td>
                        <td>{{ $summary->unit_name }}</td>
                        <td>{{ $summary->work_type_name }}</td>
                        <td>{{ $summary->work_class_name }}</td>
                        <td>{{ $summary->work_detail_name }}</td>
                        <td>{{ sprintf("%.2f", $summary->work_time).'h' }}</td>
                        <td>{{ $summary->remarks }}</td>
                    </tr>
    @endforeach
                </tbody>
            </table>
        </div>
        <!-- pagenation -->
        <div class="pt-2">{{ $summarys->appends(Request::all())->links() }}</div>

@elseif ($is_nothing)
        <div class="alert alert-danger m-5 text-center" role="alert"><i class="fas fa-exclamation-circle"></i> 条件に該当する情報が見つかりません</div>
@endif

    </div><!-- min-h-screen -->

</x-app-layout>
