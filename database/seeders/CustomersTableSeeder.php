<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 初期登録データ定義
        $Customers = [
            ['customer_code' => '00100000', 'customer_name' => '未登録取引先会社',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100001', 'customer_name' => 'ﾌｪｲｽｼｰﾙﾄﾞ販売',                             'last_update_user_id' => 1111],
            ['customer_code' => '00100002', 'customer_name' => '補助金関連（売上計上）',                    'last_update_user_id' => 1111],
            ['customer_code' => '00100003', 'customer_name' => 'ｴｱｰﾘｱ販売',                                 'last_update_user_id' => 1111],
            ['customer_code' => '00100010', 'customer_name' => '東芝ﾃﾞﾊﾞｲｽ&ｽﾄﾚｰｼﾞ株式会社(MC)',             'last_update_user_id' => 1111],
            ['customer_code' => '00100011', 'customer_name' => '東芝ﾃﾞﾊﾞｲｽ&ｽﾄﾚｰｼﾞ株式会社',                 'last_update_user_id' => 1111],
            ['customer_code' => '00100012', 'customer_name' => '東芝ﾃﾞﾊﾞｲｽ&ｽﾄﾚｰｼﾞ株式会社(姫路半導体工場)', 'last_update_user_id' => 1111],
            ['customer_code' => '00100020', 'customer_name' => 'ﾀｶｷ製作所株式会社',                         'last_update_user_id' => 1111],
            ['customer_code' => '00100030', 'customer_name' => '株式会社日本ﾏｲｸﾛﾆｸｽ',                       'last_update_user_id' => 1111],
            ['customer_code' => '00100040', 'customer_name' => '株式会社江藤製作所',                        'last_update_user_id' => 1111],
            ['customer_code' => '00100050', 'customer_name' => '宝永電機株式会社',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100060', 'customer_name' => '株式会社石井工作研究所',                    'last_update_user_id' => 1111],
            ['customer_code' => '00100061', 'customer_name' => '株式会社石井工作研究所(外注)',              'last_update_user_id' => 1111],
            ['customer_code' => '00100070', 'customer_name' => '緑屋電気株式会社',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100080', 'customer_name' => '東芝ﾃﾞｨｽｸﾘｰﾄﾃｸﾉﾛｼﾞｰ株式会社',               'last_update_user_id' => 1111],
            ['customer_code' => '00100090', 'customer_name' => 'ｿﾆｰ･太陽株式会社',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100100', 'customer_name' => '株式会社ｱﾑｺｰ･ﾃｸﾉﾛｼﾞｰ･ｼﾞｬﾊﾟﾝ',               'last_update_user_id' => 1111],
            ['customer_code' => '00100110', 'customer_name' => 'ｶﾐﾏﾙ株式会社',                              'last_update_user_id' => 1111],
            ['customer_code' => '00100120', 'customer_name' => '株式会社大分県ｾｷｭﾘﾃｨｾﾝﾀｰ',                  'last_update_user_id' => 1111],
            ['customer_code' => '00100130', 'customer_name' => '株式会社S･A･P',                             'last_update_user_id' => 1111],
            ['customer_code' => '00100140', 'customer_name' => '東芝EIｺﾝﾄﾛｰﾙｼｽﾃﾑ株式会社',                  'last_update_user_id' => 1111],
            ['customer_code' => '00100150', 'customer_name' => '株式会社AKｼｽﾃﾑ',                            'last_update_user_id' => 1111],
            ['customer_code' => '00100160', 'customer_name' => '株式会社佐々木精工',                        'last_update_user_id' => 1111],
            ['customer_code' => '00100170', 'customer_name' => 'ﾉｰﾄﾞｿﾝ･ｱﾄﾞﾊﾞﾝｽﾄ･ﾃｸﾉﾛｼﾞｰ株式会社',           'last_update_user_id' => 1111],
            ['customer_code' => '00100180', 'customer_name' => '株式会社ｿｰﾄﾞ',                              'last_update_user_id' => 1111],
            ['customer_code' => '00100200', 'customer_name' => '株式会社ｼﾞｬﾊﾟﾝｾﾐｺﾝﾀﾞｸﾀｰ(大分)',             'last_update_user_id' => 1111],
            ['customer_code' => '00100201', 'customer_name' => '株式会社ｼﾞｬﾊﾟﾝｾﾐｺﾝﾀﾞｸﾀｰ',                   'last_update_user_id' => 1111],
            ['customer_code' => '00100210', 'customer_name' => 'ｿﾆｰｾﾐｺﾝﾀﾞｸﾀﾏﾆｭﾌｧｸﾁｬﾘﾝｸﾞ株式会社',           'last_update_user_id' => 1111],
            ['customer_code' => '00100220', 'customer_name' => 'ﾇｳﾞｫﾄﾝﾃｸﾉﾛｼﾞｰｼﾞｬﾊﾟﾝ株式会社',               'last_update_user_id' => 1111],
            ['customer_code' => '00100230', 'customer_name' => '有限会社宇佐石材工業',                      'last_update_user_id' => 1111],
            ['customer_code' => '00100240', 'customer_name' => '株式会社ｱﾍﾞﾙｩﾌ',                            'last_update_user_id' => 1111],
            ['customer_code' => '00100250', 'customer_name' => 'ｱﾛﾝ化成株式会社',                           'last_update_user_id' => 1111],
            ['customer_code' => '00100260', 'customer_name' => '株式会社鈴木商館',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100270', 'customer_name' => 'ｷｵｸｼｱ株式会社',                             'last_update_user_id' => 1111],
            ['customer_code' => '00100280', 'customer_name' => 'Flash Forward合同会社',                     'last_update_user_id' => 1111],
            ['customer_code' => '00100290', 'customer_name' => 'Flash Partners有限会社',                    'last_update_user_id' => 1111],
            ['customer_code' => '00100300', 'customer_name' => 'Flash Alliance有限会社',                    'last_update_user_id' => 1111],
            ['customer_code' => '00100310', 'customer_name' => 'PHYTEK Corporation',                        'last_update_user_id' => 1111],
            ['customer_code' => '00100320', 'customer_name' => '有限会社河野機工',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100330', 'customer_name' => 'ﾐﾊﾗ電子株式会社',                           'last_update_user_id' => 1111],
            ['customer_code' => '00100340', 'customer_name' => '株式会社ﾌｼﾞｸﾗ',                             'last_update_user_id' => 1111],
            ['customer_code' => '00100350', 'customer_name' => '株式会社精研',                              'last_update_user_id' => 1111],
            ['customer_code' => '00100360', 'customer_name' => '東芝ﾏｲｸﾛｴﾚｸﾄﾛﾆｸｽ株式会社',                  'last_update_user_id' => 1111],
            ['customer_code' => '00100370', 'customer_name' => '大分ﾃﾞﾊﾞｲｽﾃｸﾉﾛｼﾞｰ株式会社',                 'last_update_user_id' => 1111],
            ['customer_code' => '00100380', 'customer_name' => 'ﾌﾟﾗﾝｺﾑ有限会社',                            'last_update_user_id' => 1111],
            ['customer_code' => '00100390', 'customer_name' => 'ｴﾑﾃｲ-ｼｰ株式会社',                           'last_update_user_id' => 1111],
            ['customer_code' => '00100400', 'customer_name' => '株式会社森野',                              'last_update_user_id' => 1111],
            ['customer_code' => '00100410', 'customer_name' => '株式会社堀場製作所',                        'last_update_user_id' => 1111],
            ['customer_code' => '00100420', 'customer_name' => '株式会社ﾆﾁｿﾞｳﾃｯｸ',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100430', 'customer_name' => 'KING YUEN ELECTRONICS CO.,LTD.',            'last_update_user_id' => 1111],
            ['customer_code' => '00100440', 'customer_name' => 'D-LIGHT株式会社',                           'last_update_user_id' => 1111],
            ['customer_code' => '00100450', 'customer_name' => 'ﾃｽ販売株式会社',                            'last_update_user_id' => 1111],
            ['customer_code' => '00100460', 'customer_name' => 'ﾗﾋﾟｽｾﾐｺﾝﾀﾞｸﾀ株式会社',                      'last_update_user_id' => 1111],
            ['customer_code' => '00100461', 'customer_name' => 'ﾗﾋﾟｽｾﾐｺﾝﾀﾞｸﾀ宮城株式会社',                  'last_update_user_id' => 1111],
            ['customer_code' => '00100470', 'customer_name' => 'ASE Test Inc.',                             'last_update_user_id' => 1111],
            ['customer_code' => '00100480', 'customer_name' => '株式会社展商',                              'last_update_user_id' => 1111],
            ['customer_code' => '00100490', 'customer_name' => '株式会社太豊ﾃｸﾉｽ',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100500', 'customer_name' => '株式会社ﾋﾟｰｴﾑﾃｨｰ',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100510', 'customer_name' => 'ﾑﾗﾃｯｸﾒｶﾄﾛﾆｸｽ株式会社',                      'last_update_user_id' => 1111],
            ['customer_code' => '00100520', 'customer_name' => '株式会社ｻｰﾄﾞﾌﾟﾗﾝ',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100530', 'customer_name' => 'ｴｽﾃｨｹｲﾃｸﾉﾛｼﾞｰ株式会社',                     'last_update_user_id' => 1111],
            ['customer_code' => '00100540', 'customer_name' => 'USCIｼﾞｬﾊﾟﾝ株式会社',                        'last_update_user_id' => 1111],
            ['customer_code' => '00100550', 'customer_name' => '公立大学法人大分県立看護科学大学',          'last_update_user_id' => 1111],
            ['customer_code' => '00100560', 'customer_name' => '株式会社ﾄﾞﾘｰﾑ･ｼﾞｰﾋﾟｰ',                      'last_update_user_id' => 1111],
            ['customer_code' => '00100570', 'customer_name' => '株式会社昭和電気研究所',                    'last_update_user_id' => 1111],
            ['customer_code' => '00100580', 'customer_name' => 'ｲｻﾊﾔ電子株式会社',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100590', 'customer_name' => '旭有機材株式会社',                          'last_update_user_id' => 1111],
            ['customer_code' => '00100700', 'customer_name' => '株式会社JSL',                               'last_update_user_id' => 1111],
            ['customer_code' => '00100810', 'customer_name' => '株式会社ﾕﾆｵﾝ',                              'last_update_user_id' => 1111],
            ['customer_code' => '00100820', 'customer_name' => '株式会社ｿﾗｺﾑ',                              'last_update_user_id' => 1111],
            ['customer_code' => '00100830', 'customer_name' => '株式会社ﾗﾑﾀﾞｼｽﾃﾑ',                          'last_update_user_id' => 1111]
        ];

        // データ登録
        foreach($Customers as $Customer) {
            \App\Models\Customer::create($Customer);
        }
    }
}
