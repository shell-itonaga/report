<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ Auth::user()->name }}さん【作業者No：{{ Auth::user()->id }}】</div>
    </x-slot>

    <div class="flex flex-col sm:justify-center items-center py-2 sm:py-2">
        <div class="container-sm">
@if(session()->has('is_error') && session('is_error') == true)
            <div class="alert alert-danger text-center my-5 text-xl" role="alert"><i class="fas fa-exclamation-circle"></i>&nbsp;日報の登録にてエラーが発生しました。管理者までお知らせください</div>
@else
            <div class="alert alert-success text-center my-5 text-xl" role="alert"><i class="fas fa-info-circle"></i>&nbsp;日報の登録が完了しました</div>
@endif
            <form class="max-w-3xl mx-auto px-3" method="POST">
    @csrf
                <div class="form-group py-4 ml-4">
                        <input type="hidden" value="{{ old('work_date') }}"     id="work_date" name="work_date">
                        <input type="hidden" value="{{ old('customer_code') }}" id="customer_code" name="customer_code">
                        <input type="hidden" value="{{ old('order_id') }}"      id="order_id" name="order_id">
                        <input type="hidden" value="{{ old('serial_id') }}"     id="serial_id" name="serial_id">
                        <input type="hidden" value="{{ old('unit_id') }}"       id="unit_id" name="unit_id">
                        <input type="hidden" value="{{ old('model_name') }}"    id="model_name" name="model_name">
                </div><!-- form-Group -->

                <div class="text-center">
                    <a class="btn btn-lg btn-success btn-wide" href="{{ route('menu') }}">TOPに戻る</a>
                    <button type="submit" name="continue" value="continue" class="btn btn-lg btn-primary mx-4 my-2">続けて入力</button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
