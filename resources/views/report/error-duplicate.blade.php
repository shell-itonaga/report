<x-app-layout>
    <x-slot name="header">
        <div class="text-base md:text-2xl">{{ Auth::user()->name }}さん【作業者No：{{ Auth::user()->id }}】</div>
    </x-slot>

    <div class="min-h-screen flex flex-col py-5 sm:py-2">
        <div class="container-sm">
            <div class="alert alert-danger text-center my-5 text-xl" role="alert"><i class="fas fa-exclamation-circle"></i> 同じデータが登録済です。</div>
            <div class="text-center my-5">
                <a class="btn btn-lg btn-success btn-wide" href="{{ route('menu') }}">TOPに戻る</a>
            </div>
        </div>
    </div>

</x-app-layout>
