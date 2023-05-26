<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\SerialNumber;
use App\Models\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * ユーザ情報取得
 */
Route::middleware('auth:api')->get('/user', function (Request $request)
{
    return $request->user();
});

/***
 * Techs受注データ取得 API
 */
Route::middleware('auth:api')->post('/order-update', function (Request $request)
{
    Log::info("API order-update start");
    // 受信した受注番号データをJSON型にデコード
    $content = $request->getContent();
    $jsons = json_decode($content, true) ?? [];
    try {
        // DBに登録・更新
        foreach($jsons as $json) {
            // 既に登録済データか否かを判断(登録済の場合はアップデート)
            $searchOrder = Order::where('order_no', '=', $json['order_no'])->get();
            $order = null;
            if(Count($searchOrder) == 0) {
                $order = new Order();
                $order->order_no = $json['order_no'];
            } else {
                $order = $searchOrder->first();
            }

            $order->order_name = $json['order_name'];
            $order->customer_code = $json['customer_code'];

            if ($json['sales_complete_date'] != "9999-12-31") {
                // NOTE: 受注番号データの売上日が[9999-12-31]の場合は売上完了日を設定しない(null設定)
                $order->sales_complete_date = $json['sales_complete_date'];
                $order->is_complete_flg = true;
            }
            $order->last_update_user_id = Auth::user()->id;
            $order->save();

            // 作業時間テーブルの得意先コードを更新
            $workTimes = WorkTime::where('order_id', '=', $order->order_id)->get();
            foreach($workTimes as $workTime) {
                $workTime->customer_code = $json['customer_code'];
                $workTime->save();
            }
        }
        Log::info("API order-update end");

    } catch(Exception $e) {
        report($e);
        throw $e;
    }
});

/**
 * Techs製番データ取得 API
 */
Route::middleware('auth:api')->post('/serial-update', function(Request $request)
{
    Log::info("API serial-update start");

    // 受信した製番データをJSON型にデコード
    $content = $request->getContent();
    $jsons = json_decode($content, true) ?? [];
    try {
        foreach ($jsons as $json) {
            // 既に登録済データか否かを判定(登録済の場合はアップデート)
            $serial = null;
            $searchSerial = SerialNumber::where('serial_no', '=', $json['serial_no'])->get();

            if (Count($searchSerial) == 0) {
                $serial = new SerialNumber();
                $serial->serial_no = $json['serial_no'];
            } else {
                $serial = $searchSerial->first();
            }
            $serial->serial_name = $json['serial_name'];
            $serial->order_no    = $json['order_no'];
            $serial->last_update_user_id = Auth::user()->id;
            $serial->save();
        }
        Log::info("API serial-update end");

    } catch (Exception $e) {
        report($e);
        throw $e;
    }
});

/**
 * Techs得意先データ取得 API
 */
Route::middleware('auth:api')->post('/customer-update', function(Request $request)
{
    Log::info("API customer-update start");
    // 受信した製番データをJSON型にデコード
    $content = $request->getContent();
    $jsons = json_decode($content, true) ?? [];
    try {
        foreach ($jsons as $json) {
            // 既に登録済データか否かを判定(登録済の場合はアップデート)
            $customer = null;
            $searchCustomer = Customer::where('customer_code', '=', $json['customer_code'])->get();
            if (Count($searchCustomer) == 0) {
                $customer = new Customer();
            } else {
                $customer = $searchCustomer->first();
            }
            $customer->customer_code = $json['customer_code'];
            $customer->customer_name = $json['customer_name'];
            $customer->last_update_user_id = Auth::user()->id;
            $customer->save();
        }
        Log::info("API customer-update end");

    } catch (Exception $e) {
        report($e);
        throw $e;
    }
});

/**
 * 作業時間テーブル 得意先コード更新
 */
Route::middleware('auth:api')->get('/worktime-update', function ()
{
    Log::info("API worktime-update start");
    try {
        $workTimes = WorkTime::whereNull('customer_code')->get();
        foreach ($workTimes as $workTime) {
            $order = Order::find($workTime->order_id);
            $workTime->customer_code = $order->customer_code;
            $workTime->save();
        }

    } catch (Exception $e) {
        report($e);
        throw $e;
    }
    Log::info("API worktime-update end");
});
