<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データをクリア
        DB::table('work_classes')->truncate();

        // 初期登録データ定義
        $workClasses = [
            // 作業分類：製造
            ['id'=> 1, 'work_class_name' => '組立',      'work_type_id' => 1, 'last_update_user_id' => 1111],
            ['id'=> 2, 'work_class_name' => '本体配線',  'work_type_id' => 1, 'last_update_user_id' => 1111],
            ['id'=> 3, 'work_class_name' => '出荷',      'work_type_id' => 1, 'last_update_user_id' => 1111],
            ['id'=> 4, 'work_class_name' => 'ｹｰﾌﾞﾙ制作', 'work_type_id' => 1, 'last_update_user_id' => 1111],
            ['id'=> 5, 'work_class_name' => '制御BOX',   'work_type_id' => 1, 'last_update_user_id' => 1111],
            ['id'=> 6, 'work_class_name' => '評価検証',  'work_type_id' => 1, 'last_update_user_id' => 1111],
            ['id'=> 7, 'work_class_name' => '立会い',    'work_type_id' => 1, 'last_update_user_id' => 1111],
            ['id'=> 8, 'work_class_name' => 'その他',    'work_type_id' => 1, 'last_update_user_id' => 1111],
            // 作業分類：電気設計
            ['id'=> 9, 'work_class_name' => 'ﾊｰﾄﾞ設計',  'work_type_id' => 2, 'last_update_user_id' => 1111],
            ['id'=> 10, 'work_class_name' => 'ｿﾌﾄ設計',  'work_type_id' => 2, 'last_update_user_id' => 1111],
            ['id'=> 11, 'work_class_name' => 'Debug',    'work_type_id' => 2, 'last_update_user_id' => 1111],
            ['id'=> 12, 'work_class_name' => '構想設計', 'work_type_id' => 2, 'last_update_user_id' => 1111],
            ['id'=> 13, 'work_class_name' => '動作確認', 'work_type_id' => 2, 'last_update_user_id' => 1111],
            ['id'=> 14, 'work_class_name' => '打合せ',   'work_type_id' => 2, 'last_update_user_id' => 1111],
            ['id'=> 15, 'work_class_name' => '書類作成', 'work_type_id' => 2, 'last_update_user_id' => 1111],
            ['id'=> 16, 'work_class_name' => '立上げ',   'work_type_id' => 2, 'last_update_user_id' => 1111],
            // 作業分類：機械設計
            ['id'=> 17, 'work_class_name' => '構想設計', 'work_type_id' => 3, 'last_update_user_id' => 1111],
            ['id'=> 18, 'work_class_name' => '詳細設計', 'work_type_id' => 3, 'last_update_user_id' => 1111],
            ['id'=> 19, 'work_class_name' => '打合せ',   'work_type_id' => 3, 'last_update_user_id' => 1111],
            ['id'=> 20, 'work_class_name' => '書類作成', 'work_type_id' => 3, 'last_update_user_id' => 1111],
            // 作業分類：基板
            ['id'=> 21, 'work_class_name' => '準備',      'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 22, 'work_class_name' => 'ｹｰﾌﾞﾙ制作', 'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 23, 'work_class_name' => '実装',      'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 24, 'work_class_name' => '修正',      'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 25, 'work_class_name' => '検査',      'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 26, 'work_class_name' => '加工',      'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 27, 'work_class_name' => '配線',      'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 28, 'work_class_name' => '出荷',      'work_type_id' => 4, 'last_update_user_id' => 1111],
            ['id'=> 29, 'work_class_name' => 'その他',    'work_type_id' => 4, 'last_update_user_id' => 1111],
        ];

        // データ登録
        foreach($workClasses as $workClass) {
            \App\Models\WorkClass::create($workClass);
        }
    }
}
