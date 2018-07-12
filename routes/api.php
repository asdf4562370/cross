<?php

//签名内
Route::group(['middleware' => ['signature']], function () {
    Route::group(['namespace' => 'Api'], function () {
        //交易相关
        Route::group(['prefix' => 'trade', 'namespace' => 'Trade'], function () {
            //账单
            Route::get('bill', 'BillController@dailyBill');
            });

    });
});
