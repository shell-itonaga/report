<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">号機名追加・編集完了</div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container">
            <div class="max-w-xl mx-auto">
                @if(session('is_error') == true)
                <div class="alert alert-danger mt-2 text-center" role="alert">号機名の追加・編集処理にて異常が発生しました</div>
@else
                <div class="alert alert-primary mt-2 text-center" role="alert">号機名の追加・編集処理が完了しました</div>
@endif
                    <div class="text-center my-5">
                        <a class="btn btn-lg btn-success btn-wide" href="{{ route('menu') }}">TOPに戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- min-h-screen -->
</x-app-layout>
