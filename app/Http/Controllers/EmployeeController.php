<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Enums\Role;
use Exception;
use View;

use function React\Promise\reduce;

class EmployeeController extends Controller
{
    /**
     * 社員リスト画面 初期表示
     *
     * @return View
     */
    public function list()
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        $users = User::where('is_delete_flg', '=', false)->
                       whereIn('user_authority', [Role::Manager, Role::Employee])->
                       orderBy('id')->
                       paginate(30);

        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
        return View('employee.list.index', ['users' => $users]);
    }

    /**
     * 社員リスト画面 名前検索
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        // 検索キーワードを入力欄に表示するためoldに設定
        $request->session()->flash('_old_input',['name_kana' => $request->name_kana]);

        $users = User::where('is_delete_flg', '=', false)->
                       whereIn('user_authority', [Role::Manager, Role::Employee])->
                       where('name_kana', 'LIKE', "%".$request->name_kana."%")->
                       orderBy('id')->
                       paginate(30);

        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
        return View('employee.list.index', ['users' => $users]);
    }

    /**
     * 社員情報 新規登録 確認・登録処理
     *
     * @param Request $request
     * @return void
     */
    public function insertConfirm(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        if ($request->submit == "confirm") {
            // 登録内容のチェック
            // ユーザIDの重複チェック
            if ($this->isUserIdDuplicate($request)) {
                session()->flash('message', "ユーザIDが重複しているため登録できません。");
                return back()->withInput();
            }
            // メールアドレス重複チェック
            if ($this->isEmailDuplicate($request)) {
                session()->flash('message', "メールアドレスが他の方と重複しているため登録できません。");
                return back()->withInput();
            }
            Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
            return View('employee.insert.confirm', ['user' => $request]);

        } else {
            // 新規登録処理
            try {
                $this->insert($request);
                Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
                return redirect()->to('employee/insert/complete');

            } catch (Exception $e) {
                Log::critical(__FILE__." [".__FUNCTION__."():".__LINE__."] ". $e);
                session()->flash('message', "メールアドレスが他の方と重複しているため登録できません。");
                return back()->withInput();
            }
        }
    }

    /**
     * ユーザID重複チェック
     *
     * @param Request $request
     * @return boolean
     */
    private function isUserIdDuplicate(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        $user = User::find($request->user_id);

        if (!empty($user)) {
            Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
            return true;

        }   else {
            Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
            return false;
        }
    }

    /**
     *社員 ユーザ情報 新規登録
     *
     * @param Request $request
     * @return void
     */
    private function insert(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        $user = new User();
        $user->id             = $request->user_id;
        $user->name           = $request->user_name;
        $user->name_kana      = $request->user_name_kana;
        $user->user_authority = $request->user_authority;
        $user->email          = $request->email;
        $user->password       = bcrypt($request->password);
        $user->user_status    = $request->user_status;
        $user->last_update_user_id = Auth::user()->id;
        $user->save();

        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
        return;
    }

    /**
     * ユーザ情報 更新画面 表示
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        // DB(ユーザ情報テーブル）から該当するユーザ情報を取得
        $user = User::find($request->user_id);

        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");

        return View('employee.edit.index', ['user' => $user]);
    }

    /**
     * ユーザ情報 更新確認処理
     *
     * @param Request $request
     * @return void
     */
    public function editConfirm(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        if ($request->submit == "confirm") {
            if($this->isEmailDuplicate($request)) {
                session()->flash('message', "メールアドレスが他の方と重複しているため登録できません。");
                return back();
            }

            Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
            // 登録確認画面表示
            return View('employee.edit.confirm', ['user' => $request]);

        } else {

            try {
                // DB更新処理
                $this->update($request);
                Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
                return redirect()->to('employee/edit/complete');

            } catch (Exception $e) {
                report($e);
                Log::error(__FILE__." [".__FUNCTION__."():".__LINE__."] Exception:".$e);
                session()->flash('message', "DBの更新処理にてエラーが発生しました。管理者までお知らせください");
                return back();
            }
        }
    }

    /**
     * メールアドレスの重複チェック
     *
     * @param Request $request
     * @return bool true：重複あり／false：重複無し
     */
    private function isEmailDuplicate(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        if (empty($request->email)) {
            Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
            return false;
        }

        $count = User::where('id', '!=', $request->user_id)->
                       where('email', '=', $request->email)->
                       get()->count();

        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
        return ($count > 0) ? true : false;
    }

    /**
     * ユーザ情報DB更新処理
     *
     * @param Request $request
     * @return void
     */
    private function update(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] start");

        $user = User::find($request->user_id);
        $user->name           = $request->user_name;
        $user->name_kana      = $request->user_name_kana;
        $user->user_authority = $request->user_authority;
        $user->email          = $request->email;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->user_status = ($request->user_status == true) ? true : false;
        $user->last_update_user_id = Auth::user()->id;
        $user->save();

        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] end");
    }
}
