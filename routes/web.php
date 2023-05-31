<?php

use App\Http\Controllers\EditController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\OutSoucerController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\UnitNoController;
use App\Http\Controllers\UserConfigController;
use App\Http\Controllers\WorkClassController;
use App\Http\Controllers\WorkDetailController;
use App\Http\Controllers\WorkListController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return View('auth.login');
});

Route::get('/menu', function () {
    return view('menu');
})->middleware(['auth'])->name('menu');

Route::prefix('other-config')->group(function() {
    // 404 NOT FOUND対策
    Route::get('/', function () { return redirect('/menu'); });
    Route::prefix('out-soucer')->group(function() {
        Route::prefix('list')->group(function() {
            Route::get('/', [OutSoucerController::class, 'listIndex'])->middleware(['auth'])->name('list.out-soucer.index');
        });
    });
});

// 各種設定(管理者のみ)
Route::prefix('config')->group(function() {
    // 404 NOT FOUND対策
    Route::get('/', function () { return redirect('/menu'); });
    // 外注
    Route::prefix('out-soucer')->group(function() {
        // 外注新規登録
        Route::prefix('insert')->group(function() {
            Route::get('/', function () { return View('config.out-soucer.insert.index'); })->middleware(['auth'])->name('insert.out-soucer.index');
            Route::post('confirm', [OutSoucerController::class, 'insertConfirm'])->middleware(['auth'])->name('insert.out-soucer.confirm');
        });
        // 外注一覧
        Route::prefix('list')->group(function() {
            //Route::get('/', [OutSoucerController::class, 'listIndex'])->middleware(['auth'])->name('list.out-soucer.index');
            Route::get('search', [OutSoucerController::class, 'search'])->middleware(['auth'])->name('list.out-soucer.search');
        });
        // 外注編集
        Route::prefix('edit')->group(function() {
            Route::get('/', [OutSoucerController::class, 'editIndex'])->middleware(['auth'])->name('edit.out-soucer.index');
            Route::post('confirm', [OutSoucerController::class, 'editConfirm'])->middleware(['auth'])->name('edit.out-soucer.confirm');
            Route::get('complete', function () { return View('config.out-soucer.edit.complete'); })->middleware(['auth'])->name('edit.out-soucer.complete');
        });
    });

    // 号機登録・編集
    Route::prefix('unit-no')->group(function() {
        Route::get('/', [UnitNoController::class, 'listIndex'])->middleware(['auth'])->name('list.unit-no.index');
        Route::get('search', [UnitNoController::class, 'search'])->middleware(['auth'])->name('list.unit-no.search');
        Route::post('upsert', [UnitNoController::class, 'upsert'])->middleware(['auth'])->name('list.unit-no.upsert');
        Route::get('complete', function () { return View('config.unit-no.complete'); })->middleware(['auth'])->name('list.unit-no.complete');
    });

    // 作業区分
    Route::prefix('work-class')->group(function() {
        // 新規登録
        Route::prefix('insert')->group(function() {
            Route::get('/', [WorkClassController::class, 'insertIndex'])->middleware(['auth'])->name('insert.work-class.index');
            Route::post('data-insert', [WorkClassController::class, 'insert'])->middleware(['auth'])->name('insert.work-class.insert');
            Route::get('complete', function() { return View('config.work-class.insert.complete'); })->middleware(['auth'])->name('insert.work-class.complete');
        });
        // 編集
        Route::prefix('edit')->group(function() {
            Route::get('/', [WorkClassController::class, 'listIndex'])->middleware(['auth'])->name('edit.work-class.index');
            Route::get('search', [WorkClassController::class, 'search'])->middleware(['auth'])->name('edit.work-class.search');
            Route::post('update', [WorkClassController::class, 'update'])->middleware(['auth'])->name('edit.work-class.update');
            Route::get('complete', function() { return View('config.work-class.edit.complete'); })->middleware(['auth'])->name('edit.work-class.complete');
        });
    });

    // 作業内容
    Route::prefix('work-detail')->group(function() {
        // 新規登録
        Route::prefix('insert')->group(function() {
            Route::get('/', [WorkDetailController::class, 'insertIndex'])->middleware(['auth'])->name('insert.work-detail.index');
            Route::post('data-insert', [WorkDetailController::class, 'insert'])->middleware(['auth'])->name('insert.work-detail.insert');
            Route::get('complete', function() { return View('config.work-detail.insert.complete'); })->middleware(['auth'])->name('insert.work-detail.complete');
        });
        // 編集
        Route::prefix('edit')->group(function() {
            Route::get('/', [WorkDetailController::class, 'listIndex'])->middleware(['auth'])->name('edit.work-detail.index');
            Route::get('search', [WorkDetailController::class, 'search'])->middleware(['auth'])->name('edit.work-detail.search');
            Route::post('update', [WorkDetailController::class, 'update'])->middleware(['auth'])->name('edit.work-detail.update');
            Route::get('complete', function() { return View('config.work-detail.edit.complete'); })->middleware(['auth'])->name('edit.work-detail.complete');
        });
    });
});

// 日報登録・編集
Route::prefix('report')->group(function () {
    // 404 NOT FOUND対策
    Route::get('/', function () { return redirect('/menu'); });
    Route::get('error-duplicate', function(){ return redirect('report/error-duplicate'); })->middleware(['auth'])->name('report.error-duplicate');
    // 日報入力
    Route::prefix('input')->group(function () {
        Route::get('/', [InputController::class, 'index'])->middleware(['auth'])->name('input.index');
        Route::post('/', function(){ return View('report.input.index');})->middleware(['auth'])->name('input.post.index');
        Route::post('confirm', [InputController::class, 'confirm'])->middleware(['auth'])->name('input.confirm');
        Route::get('complete', function () { return View('report.input.complete'); })->middleware(['auth'])->name('input.complete');
        Route::post('complete', [InputController::class, 'complete'])->middleware(['auth'])->name('input.complete.post');
    });
    // 日報編集
    Route::prefix('edit')->group( function() {
        Route::get('/', function () { return View('report.edit.index', ['listCount' => 0]); })->middleware(['auth'])->name('edit.index');
        Route::get('search', [EditController::class, 'search'])->middleware(['auth'])->name('edit.search');
        Route::get('fix', [EditController::class, 'fix'])->middleware(['auth'])->name('edit.fix');
        Route::post('confirm', [EditController::class, 'confirm'])->middleware(['auth'])->name('edit.confirm');
        Route::get('complete', function() { return View('report.edit.complete'); })->middleware(['auth'])->name('edit.complete');
    });
    // 日報一覧
    Route::prefix('list')->group( function() {
        Route::get('/', [WorkListController::class, 'index'])->middleware(['auth'])->name('list.index');
        Route::get('search', [WorkListController::class, 'search'])->middleware(['auth'])->name('list.search');
    });

    // 日報集計(管理者のみ)
    Route::prefix('summary')->group(function () {
        Route::get('/', [SummaryController::class, 'index'])->middleware(['auth'])->name('summary.index');
        Route::get('search', [SummaryController::class, 'search'])->middleware(['auth'])->name('summary.search');
        // CSV出力ボタン追加対応
        Route::post('csvoutput', [SummaryController::class, 'csvoutput'])->middleware(['auth'])->name('summary.csvoutput');
    });
    // 日報管理(管理者のみ)
    Route::prefix('manage')->group(function () {
        Route::get('/', [ManageController::class, 'index'])->middleware(['auth'])->name('manage.index');
        Route::get('search', [ManageController::class, 'search'])->middleware(['auth'])->name('manage.search');
        Route::get('edit', [ManageController::class, 'edit'])->middleware(['auth'])->name('manage.edit');
        Route::post('confirm', [ManageController::class, 'confirm'])->middleware(['auth'])->name('manage.confirm');
        Route::get('complete', function() { return View('report.manage.complete'); })->middleware(['auth'])->name('manage.complete');
    });
});

// 社員情報
Route::prefix('employee')->group(function() {
    // 404 NOT FOUND対策
    Route::get('/', function () { return redirect('/menu'); });
    // 社員情報 一覧
    Route::prefix('list')->group( function() {
        Route::get('/', [EmployeeController::class, 'list'])->middleware(['auth'])->name('employee.list');
        Route::get('search', [EmployeeController::class, 'search'])->middleware(['auth'])->name('employee.search');
    });
    // 社員情報 新規登録
    Route::prefix('insert')->group( function() {
        Route::get('/', function() { return View('employee.insert.index'); })->middleware(['auth'])->name('employee.insert');
        Route::post('confirm', [EmployeeController::class, 'insertConfirm'])->middleware(['auth'])->name('employee.insert-confirm');
        Route::get('complete', function() { return View('employee.insert.complete'); })->middleware(['auth'])->name('employee.insert-complete');
    });
    // 社員情報 更新
    Route::prefix('edit')->group( function() {
        Route::get('/', [EmployeeController::class, 'edit'])->middleware(['auth'])->name('employee.edit');
        Route::post('confirm', [EmployeeController::class, 'editConfirm'])->middleware(['auth'])->name('employee.edit-confirm');
        Route::get('complete', function() { return View('employee.edit.complete'); })->middleware(['auth'])->name('employee.edit-complete');
    });
});

// ユーザ情報 設定
Route::prefix('user-config')->group(function () {
    Route::get('/', [UserConfigController::class, 'index'])->middleware(['auth'])->name('user-config.index');
    Route::post('confirm', [UserConfigController::class, 'confirm'])->middleware(['auth'])->name('user-config.confirm');
    Route::get('complete', function() { return View('user-config.complete'); })->middleware(['auth'])->name('user-config.complete');
});

require __DIR__.'/auth.php';

