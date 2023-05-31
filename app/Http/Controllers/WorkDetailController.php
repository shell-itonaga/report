<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\WorkType;
use App\Models\WorkClass;
use App\Models\WorkDetail;
use Exception;
use Illuminate\Support\Facades\Log;
use View;

class WorkDetailController extends Controller
{
    /**
     * 作業内容新規登録 初期画面表示
     *
     * @return void
     */
    public function insertIndex()
    {
        // 作業分類・作業区分を取得
        $workTypes = WorkType::where('is_delete_flg', '=', false)->
                               orderBy('id')->
                               get();

        $workClasses = WorkClass::where('is_delete_flg', '=', false)->
                                  orderBy('work_type_id')->
                                  orderBy('id')->
                                  get();

        //return View('config.work-detail.insert.index',['workTypes' => $workTypes, 'workClasses' => $workClasses]);
        return View('settings.work-detail.insert.index',['workTypes' => $workTypes, 'workClasses' => $workClasses]);
    }

    /**
     * 作業内容をDBに新規登録する
     *
     * @param Request $request
     * @return View
     */
    public function insert(Request $request)
    {
        $isDuplicate = $this->isDetailDuplicateInsert($request);
        if ($isDuplicate == true) {
            // 重複有り
            $workTypes   = WorkType::where('is_delete_flg', '=', false)->orderBy('id')->get();
            $workClasses = WorkClass::where('is_delete_flg', '=', false)->orderBy('work_type_id')->orderBy('id')->get();
            $request->flash();
            session()->flash('is_duplicate', true);
            //return View('config.work-detail.insert.index',['workTypes' => $workTypes, 'workClasses' => $workClasses]);
            return View('settings.work-detail.insert.index',['workTypes' => $workTypes, 'workClasses' => $workClasses]);

        } else {

            try {
                // DBに登録
                $workDetails = new WorkDetail;
                $workDetails->work_detail_name = $request->work_detail;
                $workDetails->work_type_id     = $request->work_type;
                $workDetails->work_class_id    = $request->work_class;
                $workDetails->last_update_user_id = Auth::user()->id;
                $workDetails->save();
                session()->flash('is_error', false);

            } catch (Exception $e) {

                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
                session()->flash('is_error', true);
            }

            //return redirect()->to('config/work-detail/insert/complete');
            return redirect()->to('settings/work-detail/insert/complete');
        }
    }

    /**
     * 入力された作業内容が重複しているかチェックする
     *
     * @param Request $request
     * @return boolean true：重複あり ／ false：重複無し
     */
    private function isDetailDuplicateInsert(Request $request)
    {
        $workDetails = WorkDetail::where('is_delete_flg', '=', false)
                        ->where('work_type_id',     '=', $request->work_type)
                        ->where('work_class_id',    '=', $request->work_class)
                        ->where('work_detail_name', '=', $request->work_detail)->get();

        return (Count($workDetails) > 0) ? true : false;
    }

    /**
     * 作業内容編集画面 初期表示
     *
     * @return void
     */
    public function listIndex()
    {
        // 作業分類・作業区分を取得
        $workTypes   = WorkType::where('is_delete_flg',  '=', false)->orderBy('id')->get();
        $workClasses = WorkClass::where('is_delete_flg', '=', false)->orderBy('work_type_id')->orderBy('id')->get();
        // 作業内容をビューから取得
        $workDetailViews = WorkDetail::leftJoin('work_types',   'work_details.work_type_id',  '=', 'work_types.id')->
                                       leftJoin('work_classes', 'work_details.work_class_id', '=', 'work_classes.id')->
                                       where('work_details.is_delete_flg', '=', false)->
                                       select('work_details.*', 'work_types.work_type_name as work_type_name', 'work_classes.work_class_name as work_class_name');

        $workDetails = $workDetailViews->
                        orderBy('work_details.work_type_id')->
                        orderBy('work_details.work_class_id')->
                        orderBy('work_details.id')->
                        paginate(20);

        //return View('config.work-detail.edit.index',['workTypes' => $workTypes, 'workClasses' => $workClasses, 'workDetails' => $workDetails, 'total_count' => $workDetails->total()]);
        return View('settings.work-detail.edit.index',['workTypes' => $workTypes, 'workClasses' => $workClasses, 'workDetails' => $workDetails, 'total_count' => $workDetails->total()]);
    }

    /**
     * 作業内容一覧（絞り込み）画面
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $request->flash();
        $workDetailView = WorkDetail::leftJoin('work_types',   'work_details.work_type_id',  '=', 'work_types.id')->
                                      leftJoin('work_classes', 'work_details.work_class_id', '=', 'work_classes.id')->
                                      where('work_details.is_delete_flg', '=', false)->
                                      select('work_details.*', 'work_types.work_type_name as work_type_name', 'work_classes.work_class_name as work_class_name');

        if (!empty($request->work_type)) {
            $workDetailView->where('work_details.work_type_id', '=', $request->work_type);
        }
        if (!empty($request->work_class)) {
            $workDetailView->where('work_details.work_class_id', '=', $request->work_class);
        }

        $workDetails = $workDetailView->
                        orderBy('work_details.work_type_id')->
                        orderBy('work_details.work_class_id')->
                        orderBy('work_details.id')->
                        paginate(20);

        // 作業分類・作業区分を取得
        $workTypes   = WorkType::where('is_delete_flg',  '=', false)->orderBy('id')->get();
        $workClasses = WorkClass::where('is_delete_flg', '=', false)->orderBy('work_type_id')->orderBy('id')->get();

        //return View('config.work-detail.edit.index',['workTypes' => $workTypes, 'workClasses' => $workClasses, 'workDetails' => $workDetails, 'total_count' => $workDetails->total()]);
        return View('settings.work-detail.edit.index',['workTypes' => $workTypes, 'workClasses' => $workClasses, 'workDetails' => $workDetails, 'total_count' => $workDetails->total()]);
    }

    /***
     * 作業内容更新
     */
    public function update(Request $request)
    {
        try {
            foreach ($request->values as $id => $value) {
                // 作業内容の重複チェック
                $workTypeId  = $value['work_type'];
                $workClassId = $value['work_class'];
                $workDetailName = $value['work_detail'];

                if ($this->isDetailDuplicateUpdate($id, $workTypeId, $workClassId, $workDetailName)) {
                    session()->flash('is_duplicate', true);
                    return back();
                }
                // DB更新
                $workDetail = WorkDetail::find($id);
                $workDetail->is_delete_flg    = ($value['is_delete'] == 0) ? false : true;
                $workDetail->work_detail_name = $value['work_detail'];
                $workDetail->last_update_user_id = Auth::user()->id;
                $workDetail->save();
            }
            session()->flash('is_error', false);

        } catch (Exception $e) {
            report($e);
            Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
            session()->flash('is_error', true);
        }

        //return redirect()->to('config/work-detail/edit/complete');
        return redirect()->to('settings/work-detail/edit/complete');
    }

    /**
     * 作業内容が重複しているかをチェック
     *
     * @param integer $id
     * @param integer $workTypeId
     * @param integer $workClassId
     * @param string $workDetailName
     * @return boolean
     */
    private function isDetailDuplicateUpdate(int $workDetailId, int $workTypeId, int $workClassId, string $workDetailName)
    {
        $workDetails = WorkDetail::where('is_delete_flg',    '=', false)->
                                   where('work_type_id',     '=', $workTypeId)->
                                   where('work_class_id',    '=', $workClassId)->
                                   where('work_detail_name', '=', $workDetailName)->get();

        $count = $workDetails->count();

        if ($count > 1) {
            return true;
        } elseif ($count == 1) {
            return ($workDetails[0]->id == $workDetailId) ? false : true;
        } else {
            return false;
        }
    }
}
