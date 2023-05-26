<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データをクリア
        DB::table('work_details')->truncate();

        // 初期登録データ定義
        $WorkDetails = [
            /**** 作業分類：製造 ****/
            // 作業区分：組立
            ['work_detail_name' => '受入れ・仕入れ',        'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '段取り',                'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ﾕﾆｯﾄ組立',              'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ﾄﾞｯｷﾝｸﾞ作業',           'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '総組',                  'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '配管',                  'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '追加作業',              'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '不具合対応',            'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '追加工',                'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '組立ﾁｪｯｸ',              'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            ['work_detail_name' => '配管ﾁｪｯｸ',              'work_type_id' => 1,    'work_class_id' => 1, 'last_update_user_id' => 1111],
            // 作業区分：本体配線
            ['work_detail_name' => 'ｼｰﾙ、ﾏｰｸﾁｭｰﾌﾞ作成',     'work_type_id' => 1,    'work_class_id' => 2, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ﾁｪｯｸ、後処理',          'work_type_id' => 1,    'work_class_id' => 2, 'last_update_user_id' => 1111],
            ['work_detail_name' => '配線',                  'work_type_id' => 1,    'work_class_id' => 2, 'last_update_user_id' => 1111],
            ['work_detail_name' => '修正',                  'work_type_id' => 1,    'work_class_id' => 2, 'last_update_user_id' => 1111],
            ['work_detail_name' => '不具合対応',            'work_type_id' => 1,    'work_class_id' => 2, 'last_update_user_id' => 1111],
            ['work_detail_name' => '配線ﾁｪｯｸ',              'work_type_id' => 1,    'work_class_id' => 2, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'I/Oﾁｪｯｸ',               'work_type_id' => 1,    'work_class_id' => 2, 'last_update_user_id' => 1111],
            // 作業区分：出荷
            ['work_detail_name' => '出荷準備',              'work_type_id' => 1,    'work_class_id' => 3, 'last_update_user_id' => 1111],
            ['work_detail_name' => '出荷対応',              'work_type_id' => 1,    'work_class_id' => 3, 'last_update_user_id' => 1111],
            // 作業区分：ｹｰﾌﾞﾙ制作
            ['work_detail_name' => 'ｹｰﾌﾞﾙ制作',             'work_type_id' => 1,    'work_class_id' => 4, 'last_update_user_id' => 1111],
            ['work_detail_name' => '配線ﾁｪｯｸ',              'work_type_id' => 1,    'work_class_id' => 4, 'last_update_user_id' => 1111],
            // 作業区分：制御BOX
            ['work_detail_name' => 'ｹｰﾌﾞﾙ加工',             'work_type_id' => 1,    'work_class_id' => 5, 'last_update_user_id' => 1111],
            ['work_detail_name' => '加工',                  'work_type_id' => 1,    'work_class_id' => 5, 'last_update_user_id' => 1111],
            ['work_detail_name' => '取付け',                'work_type_id' => 1,    'work_class_id' => 5, 'last_update_user_id' => 1111],
            ['work_detail_name' => '配線',                  'work_type_id' => 1,    'work_class_id' => 5, 'last_update_user_id' => 1111],
            ['work_detail_name' => '配線ﾁｪｯｸ',              'work_type_id' => 1,    'work_class_id' => 5, 'last_update_user_id' => 1111],
            // 作業区分：評価検証
            ['work_detail_name' => '調整',                  'work_type_id' => 1,    'work_class_id' => 6, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ﾗﾝﾆﾝｸﾞ',                'work_type_id' => 1,    'work_class_id' => 6, 'last_update_user_id' => 1111],
            ['work_detail_name' => '測定・評価・ﾃﾞｰﾀ取り',  'work_type_id' => 1,    'work_class_id' => 6, 'last_update_user_id' => 1111],
            // 作業区分：立会い
            ['work_detail_name' => '社内立会い',            'work_type_id' => 1,    'work_class_id' => 7, 'last_update_user_id' => 1111],
            ['work_detail_name' => '客先立会い',            'work_type_id' => 1,    'work_class_id' => 7, 'last_update_user_id' => 1111],
            // 作業区分：その他
            ['work_detail_name' => '移動',                  'work_type_id' => 1,    'work_class_id' => 8, 'last_update_user_id' => 1111],
            ['work_detail_name' => '立上げ',                'work_type_id' => 1,    'work_class_id' => 8, 'last_update_user_id' => 1111],
            ['work_detail_name' => '教育・実習',            'work_type_id' => 1,    'work_class_id' => 8, 'last_update_user_id' => 1111],

            /**** 作業分類：電気設計 ****/
            // 作業区分：ﾊｰﾄﾞ設計
            ['work_detail_name' => '電装BOX設計',           'work_type_id' => 2,    'work_class_id' => 9, 'last_update_user_id' => 1111],
            ['work_detail_name' => '本体電装回路設計',      'work_type_id' => 2,    'work_class_id' => 9, 'last_update_user_id' => 1111],
            ['work_detail_name' => '部品手配',              'work_type_id' => 2,    'work_class_id' => 9, 'last_update_user_id' => 1111],
            // 作業区分：ｿﾌﾄ設計
            ['work_detail_name' => 'ﾀｯﾁﾊﾟﾈﾙ設計',           'work_type_id' => 2,    'work_class_id' => 10, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'PLCｿﾌﾄ設計',            'work_type_id' => 2,    'work_class_id' => 10, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'PCｿﾌﾄ設計(通信含む)',   'work_type_id' => 2,    'work_class_id' => 10, 'last_update_user_id' => 1111],
            // 作業区分：Debug
            ['work_detail_name' => 'Debug作業',             'work_type_id' => 2,    'work_class_id' => 11, 'last_update_user_id' => 1111],
            // 作業区分：構想設計
            ['work_detail_name' => '構想設計',              'work_type_id' => 2,    'work_class_id' => 12, 'last_update_user_id' => 1111],
            // 作業区分：動作確認
            ['work_detail_name' => '動作確認作業',          'work_type_id' => 2,    'work_class_id' => 13, 'last_update_user_id' => 1111],
            ['work_detail_name' => '客先立会い確認',        'work_type_id' => 2,    'work_class_id' => 13, 'last_update_user_id' => 1111],
            // 作業区分：打合せ
            ['work_detail_name' => 'DR・仕様打合せ',        'work_type_id' => 2,    'work_class_id' => 14, 'last_update_user_id' => 1111],
            // 作業区分：書類作成
            ['work_detail_name' => '取扱説明書作成',        'work_type_id' => 2,    'work_class_id' => 15, 'last_update_user_id' => 1111],
            // 作業区分：立上げ
            ['work_detail_name' => '現地立上げ作業',        'work_type_id' => 2,    'work_class_id' => 16, 'last_update_user_id' => 1111],

            /**** 作業分類：機械設計 ****/
            // 作業区分：構想設計
            ['work_detail_name' => '構想設計',              'work_type_id' => 3,    'work_class_id' => 17, 'last_update_user_id' => 1111],
            // 作業区分：詳細設計
            ['work_detail_name' => '詳細設計',              'work_type_id' => 3,    'work_class_id' => 18, 'last_update_user_id' => 1111],
            ['work_detail_name' => '部品手配',              'work_type_id' => 3,    'work_class_id' => 18, 'last_update_user_id' => 1111],
            // 作業区分：打合せ
            ['work_detail_name' => 'DR・仕様打合せ',        'work_type_id' => 3,    'work_class_id' => 19, 'last_update_user_id' => 1111],
            // 作業区分：書類作成
            ['work_detail_name' => '取扱説明書作成',        'work_type_id' => 3,    'work_class_id' =>20, 'last_update_user_id' => 1111],
            ['work_detail_name' => '提出書類作成',          'work_type_id' => 3,    'work_class_id' =>20, 'last_update_user_id' => 1111],

            /**** 作業分類：基板 ****/
            // 作業区分：準備
            ['work_detail_name' => '提出書類作成',          'work_type_id' => 4,    'work_class_id' =>21, 'last_update_user_id' => 1111],
            ['work_detail_name' => '部材調達',              'work_type_id' => 4,    'work_class_id' =>21, 'last_update_user_id' => 1111],
            ['work_detail_name' => '用具調達',              'work_type_id' => 4,    'work_class_id' =>21, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ﾏｳﾝﾀｰﾃﾞｰﾀ作成',         'work_type_id' => 4,    'work_class_id' =>21, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ﾏｳﾝﾀｰ設定',             'work_type_id' => 4,    'work_class_id' =>21, 'last_update_user_id' => 1111],
            // 作業区分：ケーブル制作
            ['work_detail_name' => 'ﾏｰｸﾁｭｰﾌﾞ・ｼｰﾙ作成',                   'work_type_id' => 4,    'work_class_id' =>22, 'last_update_user_id' => 1111],
            ['work_detail_name' => '収縮ﾁｭｰﾌﾞ・ﾃﾌﾟﾗ作成',                 'work_type_id' => 4,    'work_class_id' =>22, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ｶｯﾄ・皮むき',                         'work_type_id' => 4,    'work_class_id' =>22, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ｹｰﾌﾞﾙ加工(かしめ、はんだ、同軸加工)', 'work_type_id' => 4,    'work_class_id' =>22, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ｺｹｸﾀ処理(はんだ付け、圧着、かしめ)',  'work_type_id' => 4,    'work_class_id' =>22, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ｶﾊﾞｰ取付け',                          'work_type_id' => 4,    'work_class_id' =>22, 'last_update_user_id' => 1111],
            // 作業区分：実装
            ['work_detail_name' => 'ﾌﾗｯｸｽ',                 'work_type_id' => 4,    'work_class_id' =>23, 'last_update_user_id' => 1111],
            ['work_detail_name' => '部品実装',              'work_type_id' => 4,    'work_class_id' =>23, 'last_update_user_id' => 1111],
            ['work_detail_name' => '印刷',                  'work_type_id' => 4,    'work_class_id' =>23, 'last_update_user_id' => 1111],
            ['work_detail_name' => '表面実装',              'work_type_id' => 4,    'work_class_id' =>23, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ﾘｰﾄﾞ品はんだ付け',      'work_type_id' => 4,    'work_class_id' =>23, 'last_update_user_id' => 1111],
            // 作業区分：修正
            ['work_detail_name' => '修正・部品交換',        'work_type_id' => 4,    'work_class_id' =>24, 'last_update_user_id' => 1111],
            // 作業区分：検査
            ['work_detail_name' => '導通',                  'work_type_id' => 4,    'work_class_id' =>25, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ｲﾝｻｰｷｯﾄﾃｽﾀｰ',           'work_type_id' => 4,    'work_class_id' =>25, 'last_update_user_id' => 1111],
            ['work_detail_name' => '目視検査',              'work_type_id' => 4,    'work_class_id' =>25, 'last_update_user_id' => 1111],
            // 作業区分：加工
            ['work_detail_name' => '基板加工',              'work_type_id' => 4,    'work_class_id' =>26, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'BOX加工',               'work_type_id' => 4,    'work_class_id' =>26, 'last_update_user_id' => 1111],
            // 作業区分：配線
            ['work_detail_name' => '配線作業',              'work_type_id' => 4,    'work_class_id' =>27, 'last_update_user_id' => 1111],
            // 作業区分：出荷
            ['work_detail_name' => '出荷準備',              'work_type_id' => 4,    'work_class_id' =>28, 'last_update_user_id' => 1111],
            // 作業区分：その他
            ['work_detail_name' => '資料確認',              'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
            ['work_detail_name' => '写真',                  'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
            ['work_detail_name' => '検討',                  'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
            ['work_detail_name' => '説明',                  'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
            ['work_detail_name' => '客先問合せ・対応',      'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
            ['work_detail_name' => '加工練習',              'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
            ['work_detail_name' => 'ICﾃﾞｰﾀ書込み',          'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
            ['work_detail_name' => '資料整理',              'work_type_id' => 4,    'work_class_id' =>29, 'last_update_user_id' => 1111],
        ];

        // データ登録
        foreach($WorkDetails as $WorkDetail) {
            \App\Models\WorkDetail::create($WorkDetail);
        }
    }
}
