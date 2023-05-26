<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitNumber;
use Auth;
use Exception;
use Log;

class UnitNoController extends Controller
{
    /**
     * 号機名登録・編集 初期画面表示
     *
     * @return View
     */
    public function listIndex()
    {
        $unitNumbers = UnitNumber::where('is_delete_flg', '=', false)->paginate(30);
        return View('config.unit-no.index', ['unitNumbers' => $unitNumbers, 'total_count' => $unitNumbers->total()]);
    }

    /**
     * 号機名登録・編集 検索結果表示画面
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request)
    {
        $request->flash();
        $unitNumbers = UnitNumber::where('is_delete_flg', '=', false)->where('unit_no_name', 'LIKE', "%$request->unit_name%")->paginate(30);
        return View('config.unit-no.index', ['unitNumbers' => $unitNumbers, 'total_count' => $unitNumbers->total()]);
    }

    /**
     * 号機名登録・編集を行う
     *
     * @param Request $request
     * @return void
     */
    public function upsert(Request $request)
    {
        try {
            foreach ($request->values as $id => $value) {
                if ($id > 0) {
                    // 号機名の更新処理
                    if (empty($value['unit_no_name'])) {
                        // 登録済の場合は空欄不可(メッセージはblade側で表示)
                        return back();
                    }

                    // 号機名称が変更されているかチェック
                    $unit_number = UnitNumber::find($id);
                    $isUpdateNoName = ($unit_number->unit_no_name == $value['unit_no_name']) ? false : true;
                    if (!$isUpdateNoName) {
                        // DB更新
                        $this->update($id, $value);
                    } else {
                        // 号機名称が変更されている場合は号機名称の重複チェック
                        $isDuplicated = (UnitNumber::where('unit_no_name', '=', $value['unit_no_name'])->get()->count() > 0) ? true : false;
                        if ($isDuplicated) {
                            session()->flash('is_error', true);
                            return back();
                        }
                    }

                } else {
                    // 号機名の新規登録
                    if (!empty($value['unit_no_name'])) {
                        $isDuplicated = (UnitNumber::where('unit_no_name', '=', $value['unit_no_name'])->get()->count() > 0) ? true : false;
                        if ($isDuplicated) {
                            session()->flash('is_error', true);
                            return back();
                        }
                        // DB登録
                        $this->insert($value['unit_no_name']);
                    }
                }
            }
            session()->flash('is_error', false);

        } catch (Exception $e) {
            report($e);
            Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
            session()->flash('is_error', true);
        }

        return redirect()->to('config/unit-no/complete');

    }

    /**
     * 号機名のDBレコード更新
     *
     * @param integer $id
     * @param array $value
     * @return void
     */
    private function update(int $id, array $value)
    {
        $unitNumber = UnitNumber::find($id);
        $unitNumber->unit_no_name = $value['unit_no_name'];
        $unitNumber->is_delete_flg = ($value['is_delete'] == 0) ? false : true;
        $unitNumber->last_update_user_id = Auth::user()->id;
        $unitNumber->save();
    }

    /**
     * 号機名にDBレコード追加
     *
     * @param string $unit_no_name
     * @return void
     */
    private function insert(string $unit_no_name)
    {
        $unitNumber = new UnitNumber;
        $unitNumber->unit_no_name = $unit_no_name;
        $unitNumber->last_update_user_id = Auth::user()->id;
        $unitNumber->save();
    }
}
