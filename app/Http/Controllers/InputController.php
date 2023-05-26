<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use App\Models\Order;
use App\Models\WorkTime;
use App\Models\WorkClass;
use App\Models\WorkDetail;
use App\Models\UnitNumber;
use App\Models\WorkType;
use App\Models\SerialNumber;
use App\Models\Customer;
use Auth;
use Exception;
use View;

class InputController extends Controller
{
    /**
     * 日報入力初期画面表示
     *
     * @return void
     */
    public function index(Request $request)
    {
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] start");
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request : ".var_export($request, true));

        // 得意先を取得
        $customers   = Customer::orderBy('customer_name')->get();
        // 作業分類を取得
        $workTypes   = WorkType::where('is_delete_flg', '=', false)->orderBy('id')->get();
        // 作業区分を取得
        $workClasses = WorkClass::where('is_delete_flg', '=', false)->orderBy('work_type_id')->orderBy('id')->get();
        // 作業内容を取得
        $workDetails = WorkDetail::where('is_delete_flg', '=', false)->orderBy('work_type_id')->orderBy('work_class_id')->orderBy('id')->get();
        // 受注番号情報を取得（完了フラグがfalse、または売上完了日が1か月以内のものを取得する）
        $orders = Order::where('is_delete_flg', '=', false)->orWhere('sales_complete_date', '>=', Date('Y-m-d', strtotime("-1 month")))->orderBy('order_no')->get();

        // 製番情報を取得(前処理で取得した受注番号情報に紐づく製番情報を取得する)
        // NOTE: 取得した受注番号情報から受注番号を取り出し1次配列に並列化
        $oderNoArray = Arr::pluck($orders, 'order_no');
        $serialNumbers = SerialNumber::leftJoin('orders', 'serial_numbers.order_no', '=', 'orders.order_no')->
                                       where('serial_numbers.is_delete_flg', '=', false)->
                                       whereIn('serial_numbers.order_no', $oderNoArray)->
                                       orderBy('serial_no')->
                                       select('serial_numbers.*', 'orders.id as order_id')->get();
        // 号機情報
        $unitNumbers = UnitNumber::where('is_delete_flg', '=', false)->orderBy('id')->get();
        // 登録状況（当日分）
        $timeDetailViews = WorkTime::leftJoin('orders',         'work_times.order_id',       '=', 'orders.id')->
                                     leftJoin('serial_numbers', 'work_times.serial_id',      '=', 'serial_numbers.id')->
                                     leftJoin('unit_numbers',   'work_times.unit_id',        '=', 'unit_numbers.id')->
                                     leftJoin('work_types',     'work_times.work_type_id',   '=', 'work_types.id')->
                                     leftJoin('work_classes',   'work_times.work_class_id',  '=', 'work_classes.id')->
                                     leftJoin('work_details',   'work_times.work_detail_id', '=', 'work_details.id')->
                                     leftJoin('customers',      'work_times.customer_code',  '=', 'customers.customer_code')->
                                     where('user_id', '=', Auth::user()->id)->
                                     Where('work_date', date('Y-m-d'))->get();

        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
        return View('report.input.index', ['customers'       => $customers,
                                           'workTypes'       => $workTypes,
                                           'workClasses'     => $workClasses,
                                           'workDetails'     => $workDetails,
                                           'orders'          => $orders,
                                           'serialNumbers'   => $serialNumbers,
                                           'unitNumbers'     => $unitNumbers,
                                           'timeDetailViews' => $timeDetailViews
                                        ]);
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
        $registedCount = WorkTime::where('user_id', Auth::user()->id)->
                                   where('order_id', $request->order_id)->
                                   where('serial_id', $request->serial_id)->
                                   where('unit_id', $request->unit_id)->
                                   where('work_type_id', $request->work_type)->
                                   where('work_class_id', $request->work_class)->
                                   where('work_detail_id', $request->work_detail)->
                                   where('work_date', $request->work_date)->
                                   where('is_delete_flg', '=', false)->
                                   count();
        return ($registedCount > 0) ? true : false;
    }

    /**
     * 登録確認画面表示
     *
     * @param Request $request
     * @return void
     */
    public function confirm(Request $request)
    {
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] start");
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request : ".var_export($request, true));

        if ($request->has('comfirm')) {
            // 登録確認処理
            // 入力内容が２重登録にならないかチェック
            $isDuplicated = $this->isDuplicated($request);

            if ($isDuplicated == true) {
                session()->flash('is_duplicated', true);
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
                return back()->withInput();

            } else {
                // 登録確認画面表示処理
                $customer     = Customer::where('customer_code', '=', $request->customer_code)->first();
                $order        = Order::find($request->order_id);
                $serialNumber = SerialNumber::find($request->serial_id);
                $unitNumber   = UnitNumber::find($request->unit_id);
                $workType     = WorkType::find($request->work_type);
                $workClasses  = WorkClass::find($request->work_class);
                $workDetail   = WorkDetail::find($request->work_detail);

                // 現在の登録状況表示用に取得
                $timeDetailViews = WorkTime::leftJoin('orders', 'work_times.order_id', '=', 'orders.id')->
                                             leftJoin('serial_numbers', 'work_times.serial_id',      '=', 'serial_numbers.id')->
                                             leftJoin('unit_numbers',   'work_times.unit_id',        '=', 'unit_numbers.id')->
                                             leftJoin('work_types',     'work_times.work_type_id',   '=', 'work_types.id')->
                                             leftJoin('work_classes',   'work_times.work_class_id',  '=', 'work_classes.id')->
                                             leftJoin('work_details',   'work_times.work_detail_id', '=', 'work_details.id')->
                                             leftJoin('customers',      'orders.customer_code',      '=', 'customers.customer_code')->
                                             where('user_id', '=', Auth::user()->id)->
                                             Where('work_date', date('Y-m-d'))->get();

                $params = ['postData'     => $request,
                           'customer'     => $customer,
                           'order'        => $order,
                           'serialNumber' => $serialNumber,
                           'unitNumber'   => $unitNumber,
                           'workType'     => $workType,
                           'workClass'    => $workClasses,
                           'workDetail'   => $workDetail,
                           'timeDetailViews' => $timeDetailViews
                        ];
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
                return view('report.input.confirm', $params);
            }

        } else{

            // 登録処理
            try {
                $this->insert($request);
                session()->flash('is_error', false);

            } catch (Exception $e) {
                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception : ".$e);
                session()->flash('is_error', true);
            }

            Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] end");
            return redirect()->to(route('input.complete'))->withInput();
        }
    }

        /**
     * 入力情報登録
     *
     * @param Request $request
     * @return void
     */
    private function insert(Request $request)
    {
        // DBに日報データを登録
        $workTime = new WorkTime;
        // ユーザID
        $workTime->user_id = Auth::user()->id;
        // 得意先コード
        $workTime->customer_code = $request->customer_code;
        // 受注番号
        $workTime->serial_id = $request->serial_id;
        // 製番
        $workTime->order_id = $request->order_id;
        // 型式
        if (!empty($request->model_name)) {
            $workTime->device_name = $request->model_name;
        }
        // 号機
        if (!empty($request->unit_id)) {
            $workTime->unit_id = $request->unit_id;
        }
        // 作業分類
        $workTime->work_type_id = $request->work_type;
        // 作業区分
        $workTime->work_class_id = $request->work_class;
        // 作業内容
        $workTime->work_detail_id = $request->work_detail;
        // ユニット名
        if (!empty($request->unit_name)) {
            $workTime->unit_name = $request->unit_name;
        }
        // 作業日
        $workTime->work_date = $request->work_date;
        // 作業時間
        $workTime->work_time = $request->work_time;
        // 備考
        if (!empty($request->remarks)) {
            $workTime->remarks = $request->remarks;
        }
        $workTime->last_update_user_id = Auth::user()->id;
        $workTime->save();
    }

    /**
     * 入力完了処理
     *
     * @param Request $request
     * @return void
     */
    public function complete(Request $request)
    {
        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request : ".var_export($request, true));

        if ($request->has('continue')) {
            return redirect()->to(route('input.post.index'))->withInput();
        } else {
            return View(route('input.complete'));
        }
    }
}
