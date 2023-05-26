<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\WorkClass;
use App\Models\WorkType;
use Exception;
use Illuminate\Support\Facades\Log;
use View;

class WorkClassController extends Controller
{
    /**
     * 作業区分 新規登録
     *
     * @return void
     */
    public function insertIndex()
    {
        // DBから作業分類を取得
        $workTypes = WorkType::where('is_delete_flg', '=', false)->orderBy('id')->get();
        return View('config.work-class.insert.index', ['workTypes' => $workTypes]);
    }

    /**
     * 作業区分の追加処理
     *
     * @param Request $request
     * @return void
     */
    public function insert(Request $request)
    {
        // 重複データチェック
        $workCheck = WorkClass::where('is_delete_flg', '=', false)->where('work_type_id', '=', $request->work_type)->where('work_class_name', '=', $request->work_class)->get();

        if (Count($workCheck) > 0) {
            $request->flash();
            session()->flash('is_duplicate', true);
            $workTypes = WorkType::where('is_delete_flg', '=', false)->orderBy('id')->get();
            return View('config.work-class.insert.index', ['workTypes' => $workTypes]);

        } else {
            try {
                // 新規登録
                $workClasses = new WorkClass;
                $workClasses->work_type_id = $request->work_type;
                $workClasses->work_class_name = $request->work_class;
                $workClasses->last_update_user_id = Auth::user()->id;
                $workClasses->save();
                session()->flash('is_error', false);

            } catch (Exception $e) {
                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
                session()->flash('is_error', true);
            }

            return redirect()->to('config/work-class/insert/complete');
        }
    }

    /**
     * 作業区分編集画面（一覧）表示
     *
     * @return View
     */
    public function listIndex()
    {
        $workClasses = WorkClass::where('is_delete_flg', '=', false)->orderBy('work_type_id')->orderBy('id')->paginate(30);
        $workTypes = WorkType::where('is_delete_flg', '=', 'false')->orderBy('id')->get();
        return View('config.work-class.edit.index', ['workClasses' => $workClasses, 'workTypes' => $workTypes, 'total_count' => $workClasses->total()]);
    }

    /**
     * 作業区分編集画面（一覧）絞り込み処理
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request)
    {
        $workClasses = WorkClass::where('is_delete_flg', '=', false);
        if ($request->has('workType')) {
            $workClasses = $workClasses->where('work_type_id', '=', $request->workType);
        }
        $workClasses = $workClasses->paginate(30);
        $workTypes = WorkType::where('is_delete_flg', '=', 'false')->orderBy('id')->get();
        return View('config.work-class.edit.index', ['workClasses' => $workClasses, 'workTypes' => $workTypes, 'total_count' => $workClasses->total()]);
    }

    /**
     * 作業区分更新処理
     *
     * @param Request $request
     * @return redirect
     */
    public function update(Request $request)
    {
        try {
            // DBの作業区分を更新
            foreach ($request->values as $id => $value) {
                if ($this->isDuplicated($value['work_type_id'], $id, $value['work_class_name'])) {
                    session()->flash('is_duplicate', true);
                    return back();
                }
                $workClass = WorkClass::find($id);
                $workClass->is_delete_flg   = ($value['is_delete'] == 0) ? false : true;
                $workClass->work_type_id    = $value['work_type_id'];
                $workClass->work_class_name = $value['work_class_name'];
                $workClass->last_update_user_id = Auth::user()->id;
                $workClass->save();
            }
            session()->flash('is_error', false);

        } catch (Exception $e) {
            report($e);
            Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
            session()->flash('is_error', true);
        }

        return redirect()->to('config/work-class/edit/complete');
    }

    /**
     * 作業区分の重複チェック
     *
     * @param integer $workTypeId
     * @param string $workClassName
     * @return boolean
     */
    private function isDuplicated(int $workTypeId, int $workClassId, string $workClassName)
    {
        $workClasses = WorkClass::where('work_type_id',    '=', $workTypeId)->
                                  where('work_class_name', '=', $workClassName)->
                                  where('is_delete_flg',   '=', false)->
                                  get();
        $count = $workClasses->count();
        if ($count > 1) {
            return true;
        } elseif ($count == 1) {
            return ($workClasses[0]->id == $workClassId) ?  false : true;
        } else {
            return false;
        }
    }
}
