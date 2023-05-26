<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">日報修正処理結果</div>
    </x-slot>

    <div class="flex flex-col sm:justify-center items-center py-2 sm:py-2">
        <div class="container-sm">
@if(session()->has('error_msg'))
            <div class="alert alert-danger text-center my-5 text-xl" role="alert"><i class="fas fa-exclamation-circle"></i>&nbsp;{{ session('error_msg') }}</div>
@else
            <div class="alert alert-success text-center my-5 text-xl" role="alert"><i class="fas fa-info-circle"></i>&nbsp;日報の変更・削除が完了しました</div>
@endif
            <div class="text-center my-5">
                <a class="btn btn-lg btn-success btn-wide" href="{{ route('menu') }}">TOPに戻る</a>
            </div>
        </div>
    </div>

</x-app-layout>
