$(function() {

    let $selectOrder = $('.select-order'); // 受注番号のDOM要素
    let orderOrgin = $selectOrder.html(); // オリジナルの受注番号のDOM要素
    let $selectSerial = $('.select_serial'); // 製番のDOM要素
    let serialOrgin = $selectSerial.html(); // オリジナルの製番のDOM要素
    let $selectCustomer = $('.select-customer'); // 得意先のDOM要素  // ※受注番号からの選択開始対応により追加
    let customerOrgin = $selectCustomer.html(); // オリジナルの得意先のDOM要素  // ※受注番号からの選択開始対応により追加

    function isNullorEmpty(val) {
        return (val == null || val == '') ? true : false;
    }

    // ページロード時起動
    $('.select-customer').each(function() {

        console.log('select-customer each start');
        let select_customer_val = $(this).val();
        if (isNullorEmpty(select_customer_val)) {
            // 初期ロード時に得意先が設定されていない
            // 日報入力画面ではローカルストレージをクリア
            window.sessionStorage.removeItem(['select-order']);
            window.sessionStorage.removeItem(['select_serial']);
        }
        // 受注番号のセレクトボックスをフィルタリング
        orderListFilter(select_customer_val);
    });

    $('.select-customer').change(function() {
        console.log('select-customer change start');
        orderListFilter($(this).val());
        // 得意先変更時、ローカルストレージをクリア
        window.sessionStorage.removeItem(['select-order']);
        window.sessionStorage.removeItem(['select_serial']);

        // ※受注番号からの選択開始対応により以降の処理追加
        let storage_order_val2 = window.sessionStorage.getItem(['select-order2']);
        if (!isNullorEmpty(storage_order_val2)) {
            // ローカルストレージに保存した受注番号に紐づく値にselected属性を付与
            serialListFilter(storage_order_val2);
            $('.select-order option[value="' + storage_order_val2 + '"]').prop('selected', true);
            // ローカルストレージをクリア
            window.sessionStorage.removeItem(['select-order2']);
        }
    });

    /**
     * 選択された得意先番号に紐づく受注番号をセレクトボックスに表示する
     * @param {*} val 選択された得意先番号
     */
    function orderListFilter(val) {
        console.log('!!! orderListFilter val : ' + val);
        // 選択された得意先のvalueを取得
        var selectCustomerVal = val;

        $selectOrder.html(orderOrgin).find('option').each(function() {
            // 受注番号セレクトボックスのdata-valを取得
            var orderDataVal = $(this).data('val');

            if (Number(selectCustomerVal) !== 0) {  // ※受注番号からの選択開始対応により条件文追加
                if (selectCustomerVal != orderDataVal) {
                    // 得意先のvalueと異なるdata-valを持つ受注番号の要素を削除
                    $(this).not(':first-child').remove();
                }
            }
        });

        // 製番情報リストを一旦削除する
        $selectSerial.html(serialOrgin).find('option').each(function() {
            $(this).not(':first-child').remove();
        });
    }

    $('.select-order').each(function() {
        console.log('!!! select-order each start');

        let select_order_val = $(this).val();
        if (!isNullorEmpty(select_order_val)) {
            window.sessionStorage.setItem(['select-order'], [select_order_val]);
            // 製番のセレクトボックスをフィルタリング
            serialListFilter(select_order_val);
        } else {
            // 受注番号のセレクトボックス未選択の場合は
            // ローカルストレージに保存した受注番号に紐づく値にselected属性を付与
            let storage_order_val = window.sessionStorage.getItem(['select-order']);
            serialListFilter(storage_order_val);
            $('.select-order option[value="' + storage_order_val + '"]').prop('selected', true);
        }
    });

    $('.select-order').change(function() {
        console.log('!!! select-order change start');
        serialListFilter($(this).val());
        let select_order_val = $('.select-order option:selected').val();
        if (!isNullorEmpty(select_order_val)) {
            // 受注番号のセレクトボックス選択済みの場合は
            // ローカルストレージに選択した受注番号を保持
            window.sessionStorage.setItem(['select-order'], [select_order_val]);
        }

        // ※受注番号からの選択開始対応により以降の処理追加
        if (Number($('#customer_code').val()) === 0) {
            // ローカルストレージに選択した受注番号を保持
            let select_order_val2 = $('.select-order option:selected').val();
            if (!isNullorEmpty(select_order_val2)) {
                window.sessionStorage.setItem(['select-order2'], [select_order_val2]);
            }

            // 選択された受注番号のdata-valを取得
            var selectOrderVal = $('.select-order option:selected').data('val');
            $selectCustomer.html(customerOrgin).find('option').each(function() {
                // 得意先セレクトボックスのvalueを取得
                var customerDataVal = $(this).val();
    
                if(selectOrderVal === customerDataVal) {
                    // 選択された受注番号の得意先をセレクトボックスで選択
                    $selectCustomer.val(customerDataVal).change();
                    return false;
                }
            });
        }
    });
        
    /**
     *選択された受注番号に紐づく製番をセレクトボックスに表示する
     * @param {*} val
     */
    function serialListFilter(val) {
        console.log('!!! serialListFilter start val : ' + val);
        // 選択された受注番号のvalueを取得
        var selectOrderVal = val;

        $selectSerial.html(serialOrgin).find('option').each(function() {
            // 受注番号セレクトボックスのdata-valを取得
            var serialDataVal = $(this).data('val');

            if (selectOrderVal != serialDataVal) {
                // 得意先のvalueと異なるdata-valを持つ受注番号の要素を削除
                $(this).not(':first-child').remove();
            }
        });
    }

    $('.select_serial').each(function() {
        console.log('!!! select_serial each start');

        let select_serial_val = $('.select_serial option:selected').val();
        if (!isNullorEmpty(select_serial_val)) {
            // 製番のセレクトボックス選択済みの場合は
            // ローカルストレージに選択した製番を保持
            window.sessionStorage.setItem(['select_serial'], [select_serial_val]);
        } else {
            // 受注番号のセレクトボックス未選択の場合は
            // ローカルストレージに保存した受注番号に紐づく値にselected属性を付与
            let storage_serial_val = window.sessionStorage.getItem(['select_serial']);
            $('.select_serial option[value="' + storage_serial_val + '"]').prop('selected', true);
        }
    });

    $('.select_serial').change(function() {
        console.log('!!! select_serial change start');
        let select_serial_val = $('.select_serial option:selected').val();
        // 製番のセレクトボックス選択済みの場合は
        // ローカルストレージに選択した製番を保持
        if (select_serial_val != null && select_serial_val != '') {
            window.sessionStorage.setItem(['select_serial'], [select_serial_val]);
        }
    });
})
