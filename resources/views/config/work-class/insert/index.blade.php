<x-app-layout>

    <x-slot name="header">
        <div class="text-base md:text-2xl">作業区分登録</div>
    </x-slot>

@if (session()->has('is_duplicate'))
    <div class="alert alert-danger max-w-3xl mt-3 mx-auto text-center" role="alert"><i class="fas fa-exclamation-triangle"></i>&nbsp;選択した作業分類にて同じ作業区分名が登録済みです</div>
@endif

    <form name="input" class="max-w-3xl mx-auto px-3 needs-validation" novalidate method="POST" action="{{ route('insert.work-class.insert') }}">
@csrf
        <div class="form-group py-4">
            <!-- 作業分類 -->
            <div class="row-auto">
                <label for="work_type" class="col-form-label">作業分類<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <select class="form-select form-select-lg" id="work_type" name="work_type" required>
                    <option selected disabled value="">作業分類を選択してください</option>
@foreach ($workTypes as $workType)
                    <option value="{{ $workType->id }}" @if (old('work_type') == $workType->id) selected @endif>{{ $workType->work_type_name }}</option>
@endforeach
                </select>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 作業分類が選択されていません</div>
            </div>

            <div class="row-auto">
                <label for="work_class" class="col-form-label">作業区分名<span class="badge bg-danger mx-2 my-0">必須</span></label>
                <input class="form-control" type="text" id="work_class" name="work_class" value="{{ old('work_class') }}" required>
                <div class="invalid-feedback bg-red-200 p-2 rounded"><i class="fas fa-exclamation-circle"></i> 作業区分名が入力されていません</div>
            </div>

            <div class="d-grid gap-2 d-md-block text-center mx-auto my-4">
                <a class="btn btn-lg btn-primary mx-4 my-2" href="{{ route('menu') }}">戻&emsp;る</a>
                <button class="btn btn-primary btn-lg mx-2" type="submit"> 登　録 </button>
            </div>
        </div>
    </form>

</x-app-layout>

