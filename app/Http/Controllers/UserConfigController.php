<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Exception;

class UserConfigController extends Controller
{
    /**
     * ユーザ設定画面 初期表示
     *
     * @return View
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return View('user-config.index', ['user' => $user]);
    }

    /**
     * 確認画面 処理
     *
     * @param Request $request
     * @return void
     */
    public function confirm(Request $request)
    {
        if ($request->submit == 'confirm') {

            if (!empty($request->email)) {
                // メールアドレスの２重登録チェック
                $isEmailDuplicate = $this->isEmailDuplicated($request->email);
                if ($isEmailDuplicate == true) {
                    session()->flash('message', 'メールアドレスが他の方と重複しているため登録できません');
                    return back()->withInput();
                }
            }
            // 確認画面表示
            return View('user-config.confirm', ['user' => $request]);

        } else {
            // DB ユーザ情報更新
            try {
                $user = User::find(Auth::user()->id);
                $user->name      = $request->user_name;
                $user->name_kana = $request->user_name_kana;
                $user->email     = $request->email;
                if (!empty($request->password)) {
                    $user->password  = bcrypt($request->password);
                }
                $user->last_update_user_id = Auth::user()->id;
                $user->save();

            } catch (Exception $e) {
                report($e);
                Log::critical("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "] Exception:".$e);
                session()->flash('error_msg', 'ユーザデータの更新に失敗しました。管理者までお知らせください。');
            }
            return redirect()->to('user-config/complete');
        }
    }

    /**
     * 有効なユーザのメールアドレスが登録済か否かを判定する
     *
     * @param string $email
     * @return boolean
     */
    private function isEmailDuplicated(string $email)
    {
        if (empty($email)) return false;

        $user = User::where('id', '!=', Auth::user()->id)->where('email', '=', $email)->get();
        return (Count($user) > 0) ? true : false;
    }
}
