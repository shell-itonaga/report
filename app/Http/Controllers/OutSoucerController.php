<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\Role;
use Exception;
use Illuminate\Support\Facades\Log;
use View;

class OutSoucerController extends Controller
{
    /**
     * 登録データ確認
     *
     * @param Request $request
     * @return View
     */
    public function insertConfirm(Request $request)
    {
        if ($request->submit == 'confirm') {

            $isEmailDuplicate = $this->emailDuplicateCheck($request);
            if ($isEmailDuplicate) {
                // 同メールアドレスが登録済み
                return View('config.out-soucer.error', ['postData' => $request]);
            }
            // 確認画面の表示
            return View('config.out-soucer.insert.confirm', ['postData' => $request]);

        } else {

            try {
                // ユーザ登録
                $user_id = $this->insertData($request);
                return View('config.out-soucer.insert.complete', ['postData' => $request, 'user_id' => $user_id]);
            } catch (Exception $e) {
                report($e);
                Log::error("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
                session()->flash('message', "DBの登録に失敗しました:");
                return View('config.out-soucer.insert.complete');
            }
        }
    }

    /**
     * ユーザをDBに登録する
     *
     * @param Request $request
     * @return user_id ユーザID
     */
    private function insertData(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] Request:".var_export($request, true));

        $user_id = User::query()->max('id');
        $user_id += 1;

        $insert = new User();
        $insert->id = $user_id;
        $insert->name = $request->user_name;
        $insert->name_kana = $request->user_name_kana;
        if (!empty($request->email)) {
            $insert->email = $request->email;
        }
        $insert->password = bcrypt($request->password);
        $insert->user_authority = Role::Outsourcer;
        $insert->user_status = $request->user_status;
        $insert->last_update_user_id = Auth::user()->id;
        $insert->save();

        return $user_id;
    }

    /**
     * 外注者一覧画面 初期画面
     *
     * @return View
     */
    public function listIndex()
    {
        $users = User::where('is_delete_flg', '=', false)->where('user_authority', '=', Role::Outsourcer)->paginate(50);
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] Request:".var_export($users, true));
        /*return View('config.out-soucer.list.index', ['users' => $users, 'user_count' => $users->total()]);*/
        return View('settings.out-soucer.list.index', ['users' => $users, 'user_count' => $users->total()]);
    }

    /**
     * 外注者一覧画面 検索処理
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request)
    {
        $request->flash();
        $users = User::where('is_delete_flg', '=', false)->where('user_authority', '=', Role::Outsourcer)->where('name_kana', 'LIKE', "%$request->name_kana%")->paginate(50);
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] Request:".var_export($users, true));
        return View('config.out-soucer.list.index', ['users' => $users, 'user_count' => $users->total()]);
    }

    /**
     * 外注者編集画面
     *
     * @param Request $request
     * @return View
     */
    public function editIndex(Request $request)
    {
        $user = User::find($request->user_id);
        return View('config.out-soucer.edit.index', ['user' => $user]);
    }

    /**
     * 外注者編集確認画面および編集内容登録処理
     *
     * @param Request $request
     * @return View
     */
    public function editConfirm(Request $request)
    {
        Log::debug(__FILE__." [".__FUNCTION__."():".__LINE__."] Request:".var_export($request, true));
        if ($request->submit == "confirm") {
            // メールアドレスの重複ﾁｪｯｸ
            $isEmailDuplicate = $this->emailDuplicateCheck($request);
            if ($isEmailDuplicate == true) {
                $request->flash();
                session()->flash('message', "メールアドレスが他の方と重複しているため登録できません。");
                return View('config.out-soucer.edit.index', ['user' => $request]);
            }
            // 編集確認画面
            return View('config.out-soucer.edit.confirm', ['user' => $request]);

        } else {
            // 編集内容登録処理
            $this->update($request);
            return redirect()->to('config/out-soucer/edit/complete');
        }
    }

    /**
     * メールアドレスの重複チェック
     *
     * @param Request $request
     * @return bool true：重複あり／false：重複無し
     */
    private function emailDuplicateCheck(Request $request)
    {
        if (empty($request->email)) return false;
        $user = User::where('id', '!=', $request->user_id)->where('email', '=', $request->email)->get();
        return (Count($user) > 0) ? true : false;
    }

    /**
     * ユーザ情報DB登録処理
     *
     * @param Request $request
     * @return void
     */
    private function update(Request $request)
    {
        $user = User::find($request->user_id);
        $user->name      = $request->user_name;
        $user->name_kana = $request->user_name_kana;
        $user->email     = $request->email;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->user_status = $request->user_status;
        $user->last_update_user_id = Auth::user()->id;
        $user->save();
    }
}
