<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SerialNumber;
use App\Models\WorkClass;
use App\Models\WorkDetail;
use App\Models\UnitNumber;
use App\Models\WorkTime;
use App\Models\WorkType;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Auth;
use Exception;
use View;

class EditController extends Controller
{
    /**
     * 作業日付検索結果表示処理
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request)
    {
        $request->flash();

        // GETパラメータ設定値により検索条件開始
        $timeDetailViews = WorkTime::leftJoin('orders',         'work_times.order_id',       '=', 'orders.id')->
                                     leftJoin('serial_numbers', 'work_times.serial_id',      '=', 'serial_numbers.id')->
                                     leftJoin('unit_numbers',   'work_times.unit_id',        '=', 'unit_numbers.id')->
                                     leftJoin('work_types',     'work_times.work_type_id',   '=', 'work_types.id')->
                                     leftJoin('work_classes',   'work_times.work_class_id',  '=', 'work_classes.id')->
                                     leftJoin('work_details',   'work_times.work_detail_id', '=', 'work_details.id')->
                                     leftJoin('customers',      'work_times.customer_code',  '=', 'customers.customer_code')->
                                     where('work_times.is_delete_flg', '=', false)->
                                     where('work_times.user_id',   '=', Auth::user()->id)->
                                     where('work_times.work_date', '=', $request->date_edit)->
                                     select("work_times.id",
                                            "work_times.work_date",
                                            "customers.customer_name",
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
                                            "work_times.remarks")->get();

        $TimeDetailCount = Count($timeDetailViews);
        if ($TimeDetailCount <= 0) {
            session()->flash('is_no_data', '指定された日付に該当するデータがありません');
        }
        return View('report.edit.index', ['TimeDetailViews' => $timeDetailViews, 'listCount' => $TimeDetailCount]);
    }

    /**
     * 登録内容修正画面処理
     *
     * @param Request $request
     * @return View
     */
    public function fix(Request $request)
    {
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] start request:".var_export($request, true));

        // GETパラメータ設定値により検索開始
        $selection = WorkTime::leftJoin('orders',         'work_times.order_id',       '=', 'orders.id')->
                               leftJoin('serial_numbers', 'work_times.serial_id',      '=', 'serial_numbers.id')->
                               leftJoin('unit_numbers',   'work_times.unit_id',        '=', 'unit_numbers.id')->
                               leftJoin('work_types',     'work_times.work_type_id',   '=', 'work_types.id')->
                               leftJoin('work_classes',   'work_times.work_class_id',  '=', 'work_classes.id')->
                               leftJoin('work_details',   'work_times.work_detail_id', '=', 'work_details.id')->
                               leftJoin('customers',      'work_times.customer_code',  '=', 'customers.customer_code')->
                               where('work_times.is_delete_flg', '=', false)->
                               where('work_times.id', '=', $request->edit_id)->
                               select("work_times.id as edit_id",
                                      "customers.customer_code",
                                      "work_times.work_date",
                                      "work_times.order_id",
                                      "work_times.serial_id",
                                      "work_times.unit_id",
                                      "work_times.device_name",
                                      "work_times.unit_name",
                                      "work_times.work_type_id",
                                      "work_times.work_class_id",
                                      "work_times.work_detail_id",
                                      "work_times.work_time",
                                      "work_times.remarks")->
                               first();

        // セレクトボックス用情報取得

        // 得意先名取得
        $customers = Customer::orderBy('customer_name')->get();
        // 受注番号情報取得
        // NOTE:完了フラグがfalse、または売上完了日が1か月以内のものを表示
        $orders = Order::where('is_delete_flg', '=', false)->
                         orWhere('sales_complete_date', '>=', Date('Y-m-d', strtotime("-1 month")))->
                         orderBy('order_no')->
                         get();
        // NOTE: 取得した受注番号情報から受注番号を取り出し1次配列に並列化
        $orderNoArray = Arr::pluck($orders, 'order_no');
        // 製番情報を取得(前処理で取得した受注番号情報に紐づく製番情報を取得する)
        $serialNumbers = SerialNumber::leftJoin('orders', 'serial_numbers.order_no', '=', 'orders.order_no')->
                                       where('serial_numbers.is_delete_flg', '=', false)->
                                       whereIn('serial_numbers.order_no', $orderNoArray)->
                                       orderBy('serial_no')->
                                       select('serial_numbers.*', 'orders.id as order_id')->
                                       get();
        // 号機情報取得
        $unitNumbers = UnitNumber::where('is_delete_flg', false)->get();
        // 作業分類取得
        $workTypes = WorkType::where('is_delete_flg', false)->get();
        // 作業区分取得
        $workClasses = WorkClass::Where('is_delete_flg', false)->get();
        // 作業内容取得
        $workDetails = WorkDetail::where('is_delete_flg', false)->get();

        $params = ['selection'     => $selection,
                   'customers'     => $customers,
                   'orders'        => $orders,
                   'serialNumbers' => $serialNumbers,
                   'unitNumbers'   => $unitNumbers,
                   'workTypes'     => $workTypes,
                   'workClasses'   => $workClasses,
                   'workDetails'   => $workDetails,
        ];
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] params:".var_export($params, true));
        return View('report.edit.fix', $params);
    }

    /**
     * 登録確認画面 処理
     *
     * @param Request $request
     * @return void
     */
    public function confirm(Request $request)
    {
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request:".var_export($request, true));

        if ($request->submit == 'delete') {
            try {
                // データ削除
                $this->delete($request->edit_id);
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
            } catch (Exception $e) {
                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
                session()->flash('error_msg', '日報データの削除処理で異常が発生しました');
            }

            Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
            return redirect()->to('report/edit/complete');

        } elseif ($request->submit == 'edit') {
            // データ２重登録チェック
            $isDuplicate = $this->isDuplicated($request);
            if ($isDuplicate == true) {
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
                session()->flash('is_duplicated', true);
                return back()->withInput();

            } else {
                // 登録確認画面表示
                $customer     = Customer::where("customer_code", "=", $request->customer_code)->first();
                $order        = Order::find($request->order_id);
                $serialnumber = SerialNumber::find($request->serial_id);
                $unitNumber   = UnitNumber::find($request->unit_id);
                $workType     = WorkType::find($request->work_type);
                $workClasses  = WorkClass::find($request->work_class);
                $workDetail   = WorkDetail::find($request->work_detail);

                $params = ['selection'    => $request,
                           'customer'     => $customer,
                           'order'        => $order,
                           'serialnumber' => $serialnumber,
                           'unitNumber'   => $unitNumber,
                           'workType'     => $workType,
                           'workClass'    => $workClasses,
                           'workDetail'   => $workDetail
                        ];

                // $request->session()->all();
                // Log::debug("[".__FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] session = " . var_export($request->session(), true));
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
                return View('report.edit.confirm', $params);
            }

        } else {
            // 登録内容更新
            try {
                $this->update($request);
            } catch (Exception $e) {
                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
                session()->flash('error_msg', '日報データの変更処理で異常が発生しました');
            }
            Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
            return redirect()->to('report/edit/complete');
        }
    }

    /**
     * 日報データを削除（論理削除）する
     *
     * @param integer $delete_id
     * @return void
     */
    private function delete(int $delete_id)
    {
        $workTime = WorkTime::find($delete_id);
        $workTime->is_delete_flg = true;
        $workTime->last_update_user_id = Auth::user()->id;
        $workTime->save();
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
        $registedCount = WorkTime::where('id', '!=', $request->edit_id)->
                                   where('user_id', Auth::user()->id)->
                                   where('is_delete_flg',  '=', false)->
                                   where('order_id',       '=', $request->order_id)->
                                   where('serial_id',      '=', $request->serial_id)->
                                   where('unit_id',        '=', $request->unit_id)->
                                   where('work_type_id',   '=', $request->work_type)->
                                   where('work_class_id',  '=', $request->work_class)->
                                   where('work_detail_id', '=', $request->work_detail)->
                                   where('work_date',      '=', $request->work_date)->
                                   count();
        return ($registedCount > 0) ? true : false;
    }

    /**
     * DBデータ更新
     *
     * @param Request $request
     * @return void
     */
    private function update(Request $request)
    {
        $workTime = WorkTime::find($request->edit_id);
        $workTime->customer_code  = $request->customer_code;
        $workTime->order_id       = $request->order_id;
        $workTime->serial_id      = $request->serial_id;
        $workTime->device_name    = $request->model_name;
        $workTime->unit_id        = $request->unit_id;
        $workTime->work_type_id   = $request->work_type;
        $workTime->work_class_id  = $request->work_class;
        $workTime->work_detail_id = $request->work_detail;
        $workTime->unit_name      = $request->unit_name;
        $workTime->work_date      = $request->work_date;
        $workTime->work_time      = $request->work_time;
        $workTime->remarks        = $request->remarks;
        $workTime->last_update_user_id = Auth::user()->id;
        $workTime->save();
    }
}
