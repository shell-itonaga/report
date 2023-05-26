<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 初期登録データ定義
        $Users = [
            // ユーザ：アドミニストレータ
            ['id' => 1111, 'name' => 'Administrator', 'name_kana' => 'ｱﾄﾞﾐﾆｽﾄﾚｰﾀ', 'password' => bcrypt('Admin1111'), 'user_authority' => 0, 'last_update_user_id' => 1111],
            // ユーザ：APIユーザ
            ['id' => 2222, 'name' => 'ApiUser',       'name_kana' => 'ｴｰﾋﾟｰｱｲﾕｰｻﾞ', 'password' => bcrypt('Api2222'), 'user_authority' => 0, 'api_token' => 'p1zQhxuL2EaNUVUZiMYYPi1iXLWW9R8RLwbMFHjBJmxLgUkkOn1DZApuuobo', 'last_update_user_id' => 1111],
            // ユーザ：社員
            ['id' => 3001, 'name' => '森竹隆広',     'name_kana' => 'ﾓﾘﾀｹﾀｶﾋﾛ',   'email' => 'moritake@shell-ele.com',             'password' => bcrypt('Shell3001'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3002, 'name' => '堤亮一',       'name_kana' => 'ﾂﾂﾐﾘｮｳｲﾁ',   'email' => 'ryoichi.tsutsumi002@shell-ele.com',  'password' => bcrypt('Shell3002'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3003, 'name' => '片山浩',       'name_kana' => 'ｶﾀﾔﾏﾋﾛｼ',    'email' => 'hiroshi.katayama3@shell-ele.com',    'password' => bcrypt('Shell3003'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3006, 'name' => '吉良行基',     'name_kana' => 'ｷﾗﾕｷﾓﾄ',     'email' => 'kira@shell-ele.com',                 'password' => bcrypt('Shell3006'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3007, 'name' => '岡部宏昭',     'name_kana' => 'ｵｶﾍﾞﾋﾛｱｷ',   'email' => 'okabe@shell-ele.com',                'password' => bcrypt('Shell3007'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3009, 'name' => '清松満',       'name_kana' => 'ｷﾖﾏﾂﾐﾂﾙ',    'email' => 'kiyomatsu@shell-ele.com',            'password' => bcrypt('Shell3009'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3010, 'name' => '日野伸治',     'name_kana' => 'ﾋﾉｼﾝｼﾞ',     'email' => 'shinji.hino@shell-ele.com',          'password' => bcrypt('Shell3010'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3011, 'name' => '一法師一輝',   'name_kana' => 'ｲｯﾎﾟｳｼｶｽﾞｷ', 'email' => 'ippoushi@shell-ele.com',             'password' => bcrypt('Shell3011'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3022, 'name' => '飯田正美',     'name_kana' => 'ｲｲﾀﾞﾏｻﾐ',                                                     'password' => bcrypt('Shell3022'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3024, 'name' => '羽田野淳',     'name_kana' => 'ﾊﾀﾞﾉｼﾞｭﾝ',   'email' => 'hadano@shell-ele.com',               'password' => bcrypt('Shell3024'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3030, 'name' => '志賀宏幸',     'name_kana' => 'ｼｶﾞﾋﾛﾕｷ',    'email' => 'hiroyuki.shiga@shell-ele.com' ,      'password' => bcrypt('Shell3030'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3034, 'name' => '遠藤京子',     'name_kana' => 'ｴﾝﾄﾞｳｷｮｳｺ',  'email' => 'kyoko.endo21@shell-ele.com',         'password' => bcrypt('Shell3034'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3038, 'name' => '糸永哲也',     'name_kana' => 'ｲﾄﾅｶﾞﾃﾂﾔ',   'email' => 'tetsuya.itonaga023@shell-ele.com',   'password' => bcrypt('Shell3038'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3041, 'name' => '是永拓郎',     'name_kana' => 'ｺﾚﾅｶﾞﾀｸﾛｳ',  'email' => 'takuro.korenaga@shell-ele.com',      'password' => bcrypt('Shell3041'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3042, 'name' => '大平新一',     'name_kana' => 'ｵｵﾋﾗｼﾝｲﾁ',   'email' => 'shinichi.ohira@shell-ele.com',       'password' => bcrypt('Shell3042'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            ['id' => 3043, 'name' => '橋本孝貴',     'name_kana' => 'ﾊｼﾓﾄﾀｶﾉﾘ',   'email' => 'takanori.hashimoto@shell-ele.com',   'password' => bcrypt('Shell3043'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3044, 'name' => '三股亮介',     'name_kana' => 'ﾐﾏﾀﾘｮｳｽｹ',   'email' => 'ryosuke.mimata@shell-ele.com',       'password' => bcrypt('Shell3044'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3045, 'name' => '石井秀樹',     'name_kana' => 'ｲｼｲﾋﾃﾞｷ',    'email' => 'h-ishii@shell-ele.com',              'password' => bcrypt('Shell3045'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3049, 'name' => '清末邦昭',     'name_kana' => 'ｷﾖｽｴｸﾆｱｷ',   'email' => 'kuniaki.kiyosue@shell-ele.com',      'password' => bcrypt('Shell3049'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3050, 'name' => '秋吉省吾',     'name_kana' => 'ｱｷﾖｼｼｮｳｺﾞ',                                                   'password' => bcrypt('Shell3050'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3051, 'name' => '大里一矢',     'name_kana' => 'ｵｵｻﾄｶｽﾞﾔ',   'email' => 'kazuya.osato@shell-ele.com',         'password' => bcrypt('Shell3051'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3052, 'name' => '関皓介',       'name_kana' => 'ｾｷｺｳｽｹ',                                                      'password' => bcrypt('Shell3052'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3113, 'name' => '河野宝子',     'name_kana' => 'ｶﾜﾉﾄﾐｺ',     'email' => 'tomiko.kawano025@shell-ele.com',     'password' => bcrypt('Shell3113'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3114, 'name' => '久東加奈',     'name_kana' => 'ｸﾄｳｶﾅ',      'email' => 'kana.kuto@shell-ele.com',            'password' => bcrypt('Shell3114'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3115, 'name' => '羽生梨江',     'name_kana' => 'ﾊﾆｭｳﾘｴ',     'email' => 'rie.hanyuu020@shell-ele.com',        'password' => bcrypt('Shell3115'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3116, 'name' => '佐久川亜吏紗', 'name_kana' => 'ｻｸｶﾞﾜｱﾘｻ',   'email' => 'arisa.sakugawa028@shell-ele.com',    'password' => bcrypt('Shell3116'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3118, 'name' => '一ノ宮理香',   'name_kana' => 'ｲﾁﾉﾐﾔﾘｶ',    'email' => 'rika.ichinomiya030@shell-ele.com',   'password' => bcrypt('Shell3118'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3226, 'name' => '若山時彦',     'name_kana' => 'ﾜｶﾔﾏﾄｷﾋｺ',   'email' => 'wakayama@shell-ele.com',             'password' => bcrypt('Shell3226'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3227, 'name' => '甲斐千香子',   'name_kana' => 'ｶｲﾁｶｺ',                                                       'password' => bcrypt('Shell3227'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3228, 'name' => '相濱眞由香',   'name_kana' => 'ｱｲﾊﾏﾏﾕｶ',    'email' => 'mayuka.aihama029@shell-ele.com',     'password' => bcrypt('Shell3228'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3229, 'name' => '小浜円',       'name_kana' => 'ｺﾊﾏﾏﾄﾞｶ',                                                     'password' => bcrypt('Shell3229'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3230, 'name' => '加藤章三',     'name_kana' => 'ｶﾄｳｼｮｳｿﾞｳ',                                                   'password' => bcrypt('Shell3230'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 3233, 'name' => '奥本典行',     'name_kana' => 'ｵｸﾓﾄﾉﾘﾕｷ',                                                    'password' => bcrypt('Shell3233'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            ['id' => 5002, 'name' => '吉賀裕二',     'name_kana' => 'ﾖｼｶﾞﾕｳｼﾞ',   'email' => 'yuji.yoshiga@shell-ele.com',         'password' => bcrypt('Shell5002'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            // テスト用：ユーザ（管理者）
            ['id' => 1234, 'name' => 'テストユーザ（管理者）', 'name_kana' => 'ﾃｽﾄﾕｰｻﾞｶﾝﾘｼｬ', 'password' => bcrypt('test1234'), 'user_authority' => 1, 'last_update_user_id' => 1111],
            // テスト用：ユーザ（一般）
            ['id' => 5678, 'name' => 'テストユーザ（一般）',   'name_kana' => 'ﾃｽﾄﾕｰｻﾞｲｯﾊﾟﾝ', 'password' => bcrypt('test5678'), 'user_authority' => 2, 'last_update_user_id' => 1111],
            // テスト用：ユーザ（外注）
            ['id' => 10000, 'name' => 'テストユーザ（外注）',  'name_kana' => 'ﾃｽﾄﾕｰｻﾞｶﾞｲﾁｭｳ', 'password' => bcrypt('test10000'), 'user_authority' => 10, 'last_update_user_id' => 1111],
            ];

        // データ登録
        foreach($Users as $User) {
            \App\Models\User::create($User);
        }
    }
}
