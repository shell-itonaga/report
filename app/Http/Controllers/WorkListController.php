<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\SerialNumber;
use App\Models\UnitNumber;
use App\Models\WorkClass;
use App\Models\WorkDetail;
use App\Models\WorkTime;
use App\Models\WorkType;

class WorkListController extends Controller
{
    /**
     * 選択用各種データを取得する
     *
     * @return void
     */
    private function getSelectInfo() {
        //得意先情報取得
        $customers = Customer::OrderBy('customer_name')->get();
        // 受注番号情報取得
        $orders = Order::where('is_delete_flg', false)->orderBy('order_no')->get();
        // 製番情報取得
        $serialNumbers = SerialNumber::leftJoin('orders', 'orders.order_no', '=', 'serial_numbers.order_no')->
                                       where('orders.is_delete_flg', false)->
                                       where('serial_numbers.is_delete_flg', false)->
                                       select('serial_numbers.*', 'orders.id as order_id')->
                                       orderBy('serial_numbers.serial_no')->get();
        // 号機情報取得
        $unitNumbers = UnitNumber::where('is_delete_flg', false)->orderBy('unit_no_name')->get();
        // 作業分類取得
        $workTypes = WorkType::where('is_delete_flg', false)->orderBy('id')->get();
        // 作業区分取得
        $workClasses = WorkClass::where('is_delete_flg', false)->orderBy('id')->get();
        // 作業内容取得
        $workDetails = WorkDetail::where('is_delete_flg', false)->orderBy('id')->get();

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
     * 日報一覧 初期画面表示
     *
     * @return View
     */
    public function index(Request $request) {

        // NOTE: 他の画面から遷移した際に設定されているoldの値を削除
        $request->session()->flash('_old_input');

        $params   = $this->getSelectInfo();
        $summarys = array('summarys' => []);
        $params   = array_merge($params, $summarys);
        $params   = array_merge($params, ['is_nothing' => false]);
        $params   = array_merge($params, array('total_count' => 0));
        $params   = array_merge($params, array('total_time' => 0));
        return View('report.list.index', $params);
    }

    /**
     * 日報一覧 検索処理
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request : ".var_export($request, true));

        $request->flash();

        // 検索結果ページへリターンする選択用設定値を取得
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
                            where('work_times.is_delete_flg', '=', false)->
                            where('work_times.user_id', '=', Auth::user()->id);

        if (!empty($request->date_from)) {
            $search->where('work_date', '>=', $request->date_from);
        }
        if (!empty($request->date_to)) {
            $search->where('work_date', '<=', $request->date_to);
        }
        if ($request->customer_code > 0) {
            $search->where('work_times.customer_code', '=', $request->customer_code);
        }
        if ($request->order_id > 0) {
            $search->where('work_times.order_id', '=', $request->order_id);
        }
        if ($request->serial_id > 0) {
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
        if ($request->work_detail > 0) {
            $search->where('work_times.work_detail_id', '=', $request->work_detail);
        }
        // 検索結果取得
        $summarys = $search->orderBy('work_times.work_date')->
                             orderBy('work_times.customer_code')->
                             orderBy('work_times.order_id')->
                             orderBy('work_times.serial_id')->
                             orderBy('work_times.work_type_id')->
                             orderBy('work_times.work_class_id')->
                             orderBy('work_times.work_detail_id')->
                             paginate(20);

        $params = array_merge($params, array('summarys' => $summarys));
        $totalTime = $search->sum('work_time');
        $totalCount = $summarys->total();

        if ($request->has('page')) {
            // ページネイション 2ページ以降
            $request->session()->keep('total_count', $totalCount);
            $request->session()->keep('total_time', $totalTime);
            Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "]");
        } else {
            // 1ページ目
            if ($totalCount > 0) {
                // 条件に該当するデータあり
                $request->session()->flash('total_count', $totalCount);
                $request->session()->flash('total_time', $totalTime);
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "]");
            } else {
                // 条件に該当するデータなし
                $params = array_merge($params, ['is_nothing' => true]);
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "]");
            }
        }
        return View('report.list.index', $params);
    }
}
