<?php

//签名内
Route::group(['middleware' => ['signature']], function () {
    Route::group(['namespace' => 'Api'], function () {
        //交易相关
        Route::group(['prefix' => 'trade', 'namespace' => 'Trade'], function () {
            //账单
            Route::get('bill', 'BillController@dailyBill');
        });

        //视频相关
        Route::group(['prefix' => 'videos', 'namespace' => 'Videos'], function () {
            //各种协议
            Route::get('publishing-rule', 'ProtocolController@publishingRule');

            //发表评论
            Route::post('comment', 'CommentController@comment');
            //回复评论
            Route::post('reply', 'CommentController@reply');

        });

        //资产
        Route::group(['prefix' => 'assets', 'namespace' => 'Assets'], function () {
            //我的钱包
            Route::post('my-wallet', 'WalletController@myWallet');

        });

        //消息通知
        Route::group(['prefix' => 'message', 'namespace' => 'Message'], function () {
            //消息列表
            Route::post('pull', 'MessageController@pull');
            //删除消息
            Route::post('del', 'MessageController@delete');

            Route::get('test', 'MessageController@test');

            Route::post('delete','MessageController@delById');

        });

    });
});
