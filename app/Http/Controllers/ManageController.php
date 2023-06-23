<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\SerialNumber;
use App\Models\UnitNumber;
use App\Models\WorkType;
use App\Models\WorkClass;
use App\Models\WorkDetail;
use App\Models\WorkTime;
use App\Models\Customer;
use Exception;
use View;

class ManageController extends Controller
{
    /**
     * 選択用各種データを取得する
     *
     * @return void
     */
    private function getSelectInfo() {
        // 得意先情報取得
        $customers = Customer::OrderBy('customer_name')->get();
        // 受注番号情報取得
        // ※受注番号からの選択開始対応により変更[変更前：$orders = Order::where('is_delete_flg', false)->orderBy('order_no')->get();]
        $orders = Order::OrderBy('order_no')->get();
        // 製番情報取得
        $serialNumbers = SerialNumber::leftJoin('orders', 'orders.order_no', '=', 'serial_numbers.order_no')->
                                       where('orders.is_delete_flg', false)->
                                       where('serial_numbers.is_delete_flg', false)->
                                       select('serial_numbers.*', 'orders.id as order_id')->
                                       orderBy('serial_numbers.serial_no')->get();
        // 号機情報取得
        $unitNumbers = UnitNumber::where('is_delete_flg', false)->get();
        // 作業分類取得
        $workTypes = WorkType::where('is_delete_flg', false)->get();
        // 作業区分取得
        $workClasses = WorkClass::where('is_delete_flg', false)->get();
        // 作業内容取得
        $workDetails = WorkDetail::where('is_delete_flg', false)->get();

        $selectInfos = [
            'customers'     => $customers,
            'orders'        => $orders,
            'serialNumbers' => $serialNumbers,
            'unitNumbers'   => $unitNumbers,
            'workTypes'     => $workTypes,
            'workClasses'   => $workClasses,
            'workDetails'   => $workDetails
        ];
        return $selectInfos;
    }

    /**
     * 日報管理 初期表示処理
     *
     * @return void
     */
    public function index(Request $request)
    {
        // NOTE: 他の画面から遷移した際に設定されているoldの値を削除
        $request->session()->flash('_old_input');

        $params   = $this->getSelectInfo();
        $summarys = array('summarys' => []);
        $params   = array_merge($params, $summarys);
        $params   = array_merge($params, ['is_nothing' => false]);
        return View('report.manage.index', $params);
    }

    /**
     * 絞込み検索処理
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request)
    {
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request:".var_export($request, true));

        $request->flash();

        // 検索結果ページのリターンする検索設定値を取得
        $params = $this->getSelectInfo();

        // GETパラメータ設定値により検索開始
        $search = WorkTime::leftJoin('users',          'work_times.user_id',        '=', 'users.id')->
                            leftJoin('customers',      'work_times.customer_code',  '=', 'customers.customer_code')->
                            leftJoin('orders',         'work_times.order_id',       '=', 'orders.id')->
                            leftJoin('serial_numbers', 'work_times.serial_id',      '=', 'serial_numbers.id')->
                            leftJoin('unit_numbers',   'work_times.unit_id',        '=', 'unit_numbers.id')->
                            leftJoin('work_types',     'work_times.work_type_id',   '=', 'work_types.id')->
                            leftJoin('work_classes',   'work_times.work_class_id',  '=', 'work_classes.id')->
                            leftJoin('work_details',   'work_times.work_detail_id', '=', 'work_details.id')->
                            where('work_times.is_delete_flg', '=', false);

        if (!empty($request->name_kana)) {
            $semi_kana = mb_convert_kana($request->name_kana, 'k');
            $search->where('users.name_kana', 'LIKE', "%$semi_kana%");
        }
        if (!empty($request->date_from)) {
            $search->where('work_times.work_date', '>=', $request->date_from);
        }
        if (!empty($request->date_to)) {
            $search->where('work_times.work_date', '<=', $request->date_to);
        }
        if ($request->customer_code > 0) {
            $search->where('work_times.customer_code', '=', $request->customer_code);
        }
        if ($request->order_id > 0) {
            $search->where('work_times.order_id', '=', $request->order_id);
        }
        if (!empty($request->serial_id) && $request->serial_id > 0) {
            $search->where('work_times.serial_id', '=', $request->serial_id);
        }
        if ($request->unit_id > 0) {
            $search->where('work_times.unit_id', '=', $request->unit_id);
        }
        if ($request->work_type > 0) {
            $search->where('work_times.work_type_id', '=', $request->work_type);
        }
        if ($request->work_class > 0) {
            $search->where('work_times.work_class_id', '=', $request->work_class);
        }
        if (!empty($request->work_detail) && $request->work_detail > 0) {
            $search->where('work_times.work_detail_id', '=', $request->work_detail);
        }
        // 検索結果取得
        $summarys = $search->select("work_times.id",
                                    "work_times.work_date",
                                    "customers.id as customers_id",
                                    "customers.customer_name",
                                    "users.name",
                                    "orders.order_no",
                                    "orders.order_name",
                                    "serial_numbers.serial_no",
                                    "serial_numbers.serial_name",
                                    "unit_numbers.unit_no_name",
                                    "work_times.device_name",
                                    "work_times.unit_name",
                                    "work_types.work_type_name",
                                    "work_classes.work_class_name",
                                    "work_details.work_detail_name",
                                    "work_times.work_time",
                                    "work_times.remarks")->
                             orderBy('work_times.work_date')->
                             orderBy('work_times.user_id')->
                             orderBy('work_times.customer_code')->
                             orderBy('work_times.order_id')->
                             orderBy('work_times.serial_id')->
                             orderBy('work_times.work_type_id')->
                             orderBy('work_times.work_class_id')->
                             orderBy('work_times.work_detail_id')->
                             paginate(20);

        $params = array_merge($params, array('summarys' => $summarys));
        $totalCount = $summarys->total();

        if ($request->has('page') && $request->page > 1) {
            // ページネイション 2ページ以降
            $request->session()->keep('total_count', $totalCount);
            Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "]");
        } else {
            // 1ページ目
            if ($totalCount > 0) {
                // 条件に該当するデータあり
                $params = array_merge($params, ['is_nothing' => false]);
                $request->session()->flash('total_count', $totalCount);
            } else {
                // 条件に該当するデータなし
                $params = array_merge($params, ['is_nothing' => true]);
            }
        }
        return View('report.manage.index', $params);
    }

    /**
     * 作業内容の重複登録をチェックする
     *
     * @param Request $request
     * @return boolean 登録済の場合：true
     */
    private function isDuplicated(Request $request)
    {
        // 同内容の作業が登録済が否かを判定
        $registedCount = WorkTime::where('id',             '!=', $request->edit_id)->
                                   where('user_id',        '=',  $request->user_id)->
                                   where('is_delete_flg',  '=',  false)->
                                   where('order_id',       '=',  $request->order_id)->
                                   where('unit_id',        '=',  $request->unit_id)->
                                   where('work_type_id',   '=',  $request->work_type)->
                                   where('work_class_id',  '=',  $request->work_class)->
                                   where('work_detail_id', '=',  $request->work_detail)->
                                   where('work_date',      '=',  $request->work_date)->
                                   count();
        return ($registedCount > 0) ? true : false;
    }

    /**
     * 受注Noと製番の不一致をチェックする
     *   ※受注Noと製番の不一致チェックの追加対応 2023/6/23
     * @param Request $request
     * @return boolean 不一致の場合：true
     */
    private function isNotEqual(Request $request)
    {
        $order        = Order::find($request->order_id);
        $serialNumber = SerialNumber::find($request->serial_id);
        return (strpos($serialNumber->serial_no, $order->order_no) === false) ? true : false;
    }

    /**
     * 編集画面を表示する
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request)
    {
        $request->flash();

        // 選択データの更新確認
        $params = $this->getSelectInfo();

        $selection = WorkTime::leftJoin('users',          'work_times.user_id',        '=', 'users.id')->
                               leftJoin('customers',      'work_times.customer_code',  '=', 'customers.customer_code')->
                               leftJoin('orders',         'work_times.order_id',       '=', 'orders.id')->
                               leftJoin('serial_numbers', 'work_times.serial_id',      '=', 'serial_numbers.id')->
                               leftJoin('unit_numbers',   'work_times.unit_id',        '=', 'unit_numbers.id')->
                               leftJoin('work_types',     'work_times.work_type_id',   '=', 'work_types.id')->
                               leftJoin('work_classes',   'work_times.work_class_id',  '=', 'work_classes.id')->
                               leftJoin('work_details',   'work_times.work_detail_id', '=', 'work_details.id')->
                               where('work_times.id', '=', $request->edit_id)->
                               select("work_times.id",
                                      "work_times.user_id",
                                      "users.name as user_name",
                                      "work_times.work_date",
                                      "work_times.customer_code",
                                      "work_times.order_id",
                                      "orders.order_name",
                                      "work_times.serial_id",
                                      "work_times.unit_id",
                                      "unit_numbers.unit_no_name",
                                      "work_times.device_name",
                                      "work_times.unit_name",
                                      "work_times.work_type_id",
                                      "work_times.work_class_id",
                                      "work_times.work_detail_id",
                                      "work_times.work_time",
                                      "work_times.remarks")->
                              first();

        $params = array_merge($params, array('selection' => $selection));
        return View('report.manage.edit', $params);
    }

    /**
     * 変更確認画面を表示する
     *
     * @param Request $request
     * @return void
     */
    public function confirm(Request $request)
    {
        if ($request->submit == 'delete') {
            // 選択データの削除(論理削除)
            try {
                $this->delete($request->edit_id);

            } catch (Exception $e) {
                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:" . $e);
                session()->flash('error_msg', '作業データの削除に失敗しました。管理者までお知らせください。');
            }
            return redirect()->to('report/manage/complete');

        } elseif ($request->submit == 'comfirm') {
            // データ２重登録チェック
            $isDuplicate = $this->isDuplicated($request);
            if ($isDuplicate == true) {
                session()->flash('is_duplicated', true);
                return back()->withInput();

            } else {
                // 受注Noと製番が不一致していないかチェック  ※受注Noと製番の不一致チェックの追加対応 2023/6/23
                $isNotEqual = $this->isNotEqual($request);
                if ($isNotEqual == true) {
                    session()->flash('is_not_equal', true);
                    return back()->withInput();
                }

                // 登録確認画面表示
                $customer     = Customer::where('customer_code', '=', $request->customer_code)->first();
                $order        = Order::find($request->order_id);
                $serialNumber = SerialNumber::find($request->serial_id);
                $unitNumber   = UnitNumber::find($request->unit_id);
                $workType     = WorkType::find($request->work_type);
                $workClasses  = WorkClass::find($request->work_class);
                $workDetail   = WorkDetail::find($request->work_detail);

                $params = ['postData'     => $request,
                           'customer'     => $customer,
                           'order'        => $order,
                           'serialNumber' => $serialNumber,
                           'unitNumber'   => $unitNumber,
                           'workType'     => $workType,
                           'workClass'    => $workClasses,
                           'workDetail'   => $workDetail
                        ];

                return View('report.manage.confirm', $params);
            }

        } else {
            // 編集完了画面表示
            try {
                $this->update($request);

            } catch (Exception $e) {
                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
                session()->flash('error_msg', '作業データの更新に失敗しました。管理者までお知らせください。');
            }

            return redirect()->to('report/manage/complete');
        }
    }

    /**
     * 指定されたIDの作業データを削除（論理削除）する
     *
     * @param integer $edit_id
     * @return void
     */
    private function delete(int $edit_id)
    {
        $workTime = WorkTime::find($edit_id);
        $workTime->is_delete_flg = true;
        $workTime->last_update_user_id = Auth::user()->id;
        $workTime->save();
    }

    /**
     * DBの作業データを更新する
     *
     * @param Request $request
     * @return void
     */
    private function update(Request $request)
    {
        $workTime = WorkTime::find($request->edit_id);
        $workTime->customer_code  = $request->customer_code;    //2023-06-21追加
        $workTime->work_date      = $request->work_date;
        $workTime->order_id       = $request->order_id;
        $workTime->serial_id      = $request->serial_id;
        $workTime->unit_id        = $request->unit_id;
        $workTime->device_name    = $request->model_name;
        $workTime->unit_name      = $request->unit_name;
        $workTime->work_type_id   = $request->work_type;
        $workTime->work_class_id  = $request->work_class;
        $workTime->work_detail_id = $request->work_detail;
        $workTime->work_time      = $request->work_time;
        $workTime->remarks        = $request->remarks;
        $workTime->last_update_user_id = Auth::user()->id;
        $workTime->save();
    }
}
