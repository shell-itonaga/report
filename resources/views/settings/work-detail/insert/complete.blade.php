<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">作業内容登録処理結果</div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container">
            <div class="max-w-xl mx-auto">
                @if(session('is_error') == true)
                <div class="alert alert-danger mt-2 text-center" role="alert">作業内容の登録処理にて異常が発生しました</div>
@else
                <div class="alert alert-primary mt-2 text-center" role="alert">作業内容の登録処理が完了しました</div>
@endif
                    <div class="text-center my-5">
                        <a class="btn btn-lg btn-success btn-wide" href="{{ route('menu') }}">TOPに戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- min-h-screen -->
</x-app-layout>
