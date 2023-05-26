<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">外注者編集完了</div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container">
            <div class="max-w-xl mx-auto">
                <div class="alert alert-primary mt-2 text-center" role="alert">編集内容の登録が完了しました。</div>
                    <div class="text-center my-5">
                        <a class="btn btn-lg btn-success btn-wide" href="{{ route('menu') }}">TOPに戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- min-h-screen -->
</x-app-layout>
