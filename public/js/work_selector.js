var $selectWorkClass = $('.select-work-class'); // 作業区分のDOM要素
var workClassOrgin = $selectWorkClass.html(); // オリジナルの作業区分のDOM要素
var $selectWorkDetail = $('.select-work-detail'); // 作業内容のDOM要素
var WorkDetailOrgin = $selectWorkDetail.html(); // オリジナルの作業内容のDOM要素

$(function() {

    function isNullorEmpty(val) {
        return (val == null || val == '') ? true : false;
    }

    $('.select-work-type').each(function() {
        let select_work_type = $(this).val();
        if (isNullorEmpty(select_work_type)) {
            // 初期ロード時に作業分類が設定されていない
            // 日報入力画面ではローカルストレージをクリア
            window.sessionStorage.removeItem(['select-work-class']);
            window.sessionStorage.removeItem(['select-work-detail']);
        }
        // 作業区分のセレクトボックスをフィルタリング
        workTypeFilter(select_work_type);
    });

    $('.select-work-type').change(function() {
        workTypeFilter($(this).val());
        // 作業分類変更時、ローカルストレージをクリア
        window.sessionStorage.removeItem(['select-work-class']);
        window.sessionStorage.removeItem(['select-work-detail']);
    });

    /**
     * 選択された作業分類に紐づく作業区分をセレクトボックスに表示する
     * @param {*} val 選択された作業分類コード
     */
    function workTypeFilter(val) {
        // 選択された作業分類のvalueを取得
        var selectCustomerVal = val;

        $selectWorkClass.html(workClassOrgin).find('option').each(function() {
            // 作業区分セレクトボックスのdata-valを取得
            var orderDataVal = $(this).data('val');

            if (selectCustomerVal != orderDataVal) {
                // 作業分類のvalueと異なるdata-valを持つ作業区分の要素を削除
                $(this).not(':first-child').remove();
            }
        });

        // 作業内容リストを一旦削除する
        $selectWorkDetail.html(WorkDetailOrgin).find('option').each(function() {
            $(this).not(':first-child').remove();
        });
    }

    $('.select-work-class').each(function() {

        let select_class_val = $(this).val();

        if (!isNullorEmpty(select_class_val)) {
            window.sessionStorage.setItem(['select-work-class'], [select_class_val]);
            // 作業区分のセレクトボックスをフィルタリング
            workDetailFilter(select_class_val);
        } else {
            // 作業区分のセレクトボックス未選択の場合は
            // ローカルストレージに保存した作業区分に紐づく値にselected属性を付与
            let storage_work_class = window.sessionStorage.getItem(['select-work-class']);
            workDetailFilter(storage_work_class);
            $('.select-work-class option[value="' + storage_work_class + '"]').prop('selected', true);
        }
    });

    $('.select-work-class').change(function() {
        workDetailFilter($(this).val());
        let select_class_val = $('.select-work-class option:selected').val();
        if (!isNullorEmpty(select_class_val)) {
            // 作業区分のセレクトボックス選択済みの場合は
            // ローカルストレージに選択した作業区分を保持
            window.sessionStorage.setItem(['select-work-class'], [select_class_val]);
        }
    });

    /**
     *選択された作業区分に紐づく作業内容をセレクトボックスに表示する
     * @param {*} val 選択された作業区分コード
     */
    function workDetailFilter(val) {
        // 選択された作業区分のvalueを取得
        var selectOrderVal = val;

        $selectWorkDetail.html(WorkDetailOrgin).find('option').each(function() {
            // 作業区分セレクトボックスのdata-valを取得
            var serialDataVal = $(this).data('val');

            if (selectOrderVal != serialDataVal) {
                // 作業区分のvalueと異なるdata-valを持つ作業内容の要素を削除
                $(this).not(':first-child').remove();
            }
        });
    }

    $('.select-work-detail').each(function() {
        console.log('!!! select-work-detail each start');

        let select_detail_val = $('.select-work-detail option:selected').val();
        if (!isNullorEmpty(select_detail_val)) {
            // 作業内容セレクトボックス選択済みの場合は
            // ローカルストレージに選択した作業内容を保持
            window.sessionStorage.setItem(['select-work-detail'], [select_detail_val]);
        } else {
            // 作業内容のセレクトボックス未選択の場合は
            // ローカルストレージに保存した作業内容に紐づく値にselected属性を付与
            let storage_detail_val = window.sessionStorage.getItem(['select-work-detail']);
            $('.select-work-detail option[value="' + storage_detail_val + '"]').prop('selected', true);
        }
    });

    $('.select-work-detail').change(function() {
        console.log('!!! select-work-detail change start');

        let select_detail_val = $('.select-work-detail option:selected').val();
        if (select_detail_val != null && select_detail_val != '') {
            // 作業内容のセレクトボックス選択済みの場合は
            // ローカルストレージに選択した作業内容を保持
            window.sessionStorage.setItem(['select-work-detail'], [select_detail_val]);
        }
    });
})
