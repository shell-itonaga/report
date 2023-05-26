<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データをクリア
        DB::table('work_types')->truncate();

        // 初期登録データ定義
        $workTypes = [
            ['id' => 1, 'work_type_name' => '製造',     'last_update_user_id' => 1111],
            ['id' => 2, 'work_type_name' => '電気設計', 'last_update_user_id' => 1111],
            ['id' => 3, 'work_type_name' => '機械設計', 'last_update_user_id' => 1111],
            ['id' => 4, 'work_type_name' => '基板',     'last_update_user_id' => 1111],
        ];

        // データ登録
        foreach($workTypes as $workType) {
            \App\Models\WorkType::create($workType);
        }
    }
}
