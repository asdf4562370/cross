<?php
/**
 * 我的钱包控制器
 * User: hzg
 * Date: 2018-06-19
 * Time: 23:12
 */

namespace App\Http\Controllers\Api\Assets;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function myWallet(Request $request) {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "Token does not exist";
        } else {
            $walletObj = Wallet::where(["created_by"=>$request->uid])->first();
            if (is_null($walletObj)) {
                $walletObj = Wallet::create([
                    'ticket' => 0,
                    'diamond' => 0,
                    'frozen_diamond' => 0,
                    'created_by' => $request->uid,
                ]);
                if ($walletObj) {
                    $code = 200;
                    $info = null;
                    $data = [
                        'ticket' => 0,
                        'diamond' => 0,
                        'frozen_diamond' => 0,
                    ];
                } else {
                    $code = 1001;
                    $info = "数据连接失败";
                }
            } else {
                $code = 200;
                $info = null;
                $data = [
                    'ticket' => $walletObj->ticket,
                    'diamond' => $walletObj->diamond,
                    'frozen_diamond' => $walletObj->frozen_diamond,
                ];
            }
        }

        return response()->json(compact('code', 'info', 'data'));
    }
}