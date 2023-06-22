<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\SerialNumber;
use App\Models\UnitNumber;
use App\Models\WorkClass;
use App\Models\WorkDetail;
use App\Models\WorkTime;
use App\Models\WorkType;
use App\Models\Customer;

class SummaryController extends Controller
{
    /**
     * 選択項目用データ収集
     *
     * @return void
     */
    private function getSelectInfo() {
        // 得意先情報取得
        $customers = Customer::OrderBy('customer_name')->get();
        // 受注番号情報取得
        // ※受注番号からの選択開始対応により変更[変更前：$orders = Order::where('is_delete_flg', false)->get();]
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

        $serachInfos = [
            'customers'     => $customers,
            'orders'        => $orders,
            'serialNumbers' => $serialNumbers,
            'unitNumbers'   => $unitNumbers,
            'workTypes'     => $workTypes,
            'workClasses'   => $workClasses,
            'workDetails'   => $workDetails
        ];
        return $serachInfos;
    }

    /**
     * 日報集計 初期表示処理
     *
     * @param Request $request
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

        $params = array_merge($params, ['total_count' => 0]);
        $params = array_merge($params, ['total_time'  => 0]);

        return View('report.summary.index', $params);
    }

    /**
     * 日報集計 検索処理
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request) {

        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request:".var_export($request, true));

        $request->flash();

        // 検索結果ページのリターンする検索設定値を取得
        $params = $this->getSelectInfo();

        // GETパラメータ設定値により検索条件開始
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
            //$search->where('name_kana', 'LIKE', "%$semi_kana%");
            $search->where('users.name_kana', 'LIKE', "%$semi_kana%");
        }
        if (!empty($request->date_from)) {
            //$search->where('work_date', '>=', $request->date_from);
            $search->where('work_times.work_date', '>=', $request->date_from);
        }
        if (!empty($request->date_to)) {
            //$search->where('work_date', '<=', $request->date_to);
            $search->where('work_times.work_date', '<=', $request->date_to);
        }
        if ($request->customer_code > 0) {
            $search->where('work_times.customer_code', '=', $request->customer_code);
        }
        if ($request->order_id > 0) {
            $search->where('work_times.order_id', '=', $request->order_id);
        }
        //if ($request->serial_id > 0) {
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
        //if ($request->work_detail > 0) {
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
                             orderBy('work_times.customer_code')->
                             orderBy('work_times.user_id')->
                             orderBy('work_times.order_id')->
                             orderBy('work_times.serial_id')->
                             orderBy('work_times.work_type_id')->
                             orderBy('work_times.work_class_id')->
                             orderBy('work_times.work_detail_id')->
                             paginate(20);

        $params = array_merge($params, array('summarys' => $summarys));
        $totalTime = $search->sum('work_time');
        $totalCount = $summarys->total();

        if ($request->has('page') && $request->page > 1) {
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
            }
        }

        return View('report.summary.index', $params);
    }

    /**
     * 日報集計 CSV出力処理
     *  ※CSV出力ボタン追加対応
     * @param Request $request
     * @return void
     */
    public function csvoutput(Request $request) {

        Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] request:".var_export($request, true));

        $filename = 'report_summary.csv';
        $headers = ['Content-type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                    'Pragma' => 'no-cache',
                    'Cache-Control' => 'must-revalidate, post-check~0, pre-check=0',
                    'Expires' => '0',
        ];

        $callback = function() use ($request) {
            $createCsvFile = fopen('php://output', 'w');

            $columns = ['作業者','作業日','得意先名','受注番号','受注品名','製番','製番品名','号機','型式','ユニット名','作業分類','作業区分','作業内容','作業時間[h]','備考'];
            mb_convert_variables('SJIS-win', 'UTF-8', $columns);
            fputcsv($createCsvFile, $columns);

            $request->flash();

            // GETパラメータ設定値により検索条件開始
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
                //$search->where('name_kana', 'LIKE', "%$semi_kana%");
                $search->where('users.name_kana', 'LIKE', "%$semi_kana%");
            }
            if (!empty($request->date_from)) {
                //$search->where('work_date', '>=', $request->date_from);
                $search->where('work_times.work_date', '>=', $request->date_from);
            }
            if (!empty($request->date_to)) {
                //$search->where('work_date', '<=', $request->date_to);
                $search->where('work_times.work_date', '<=', $request->date_to);
            }
            if ($request->customer_code > 0) {
                $search->where('work_times.customer_code', '=', $request->customer_code);
            }
            if ($request->order_id > 0) {
                $search->where('work_times.order_id', '=', $request->order_id);
            }
            //if ($request->serial_id > 0) {
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
            //if ($request->work_detail > 0) {
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
                                 orderBy('work_times.customer_code')->
                                 orderBy('work_times.user_id')->
                                 orderBy('work_times.order_id')->
                                 orderBy('work_times.serial_id')->
                                 orderBy('work_times.work_type_id')->
                                 orderBy('work_times.work_class_id')->
                                 orderBy('work_times.work_detail_id')->
                                 get();

            if ($summarys->count() > 0) {
                // 条件に該当するデータあり
                $errcnt = 0;
                foreach ($summarys as $val) {
                    if (strpos($val->serial_no, $val->order_no) === false) {
                        $errcnt ++;
                    }
                    $csv = [
                        $val->name,
                        $val->work_date,
                        $val->customer_name,
                        $val->order_no,
                        $val->order_name,
                        $val->serial_no,
                        $val->serial_name,
                        $val->unit_no_name,
                        $val->device_name,
                        $val->unit_name,
                        $val->work_type_name,
                        $val->work_class_name,
                        $val->work_detail_name,
                        sprintf("%.2f", $val->work_time),
                        $val->remarks,
                    ];    
                    mb_convert_variables('SJIS-win', 'UTF-8', $csv);
                    fputcsv($createCsvFile, $csv);
                }
                if ($errcnt > 0) {
                    $columns = [''];
                    fputcsv($createCsvFile, $columns);
                    $columns = ['！！！エラーデータ検出！！！'];
                    mb_convert_variables('SJIS-win', 'UTF-8', $columns);
                    fputcsv($createCsvFile, $columns);

                    foreach ($summarys as $val) {
                        if (strpos($val->serial_no, $val->order_no) === false) {
                            $csv = [
                                $val->name,
                                $val->work_date,
                                $val->customer_name,
                                $val->order_no,
                                $val->order_name,
                                $val->serial_no,
                                $val->serial_name,
                                $val->unit_no_name,
                                $val->device_name,
                                $val->unit_name,
                                $val->work_type_name,
                                $val->work_class_name,
                                $val->work_detail_name,
                                sprintf("%.2f", $val->work_time),
                                $val->remarks,
                            ];    
                            mb_convert_variables('SJIS-win', 'UTF-8', $csv);
                            fputcsv($createCsvFile, $csv);
                        }
                    }
                }
            }

            fclose($createCsvFile);
        };

        return response()->stream($callback, 200, $headers);
    }
}
