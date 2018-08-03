<?php
/**
 * 账单
 * User: hzg
 * Date: 2018-06-26
 * Time: 15:08
 */

namespace App\Http\Controllers\Api\Trade;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillController extends Controller
{

    public function dailyBill(Request $request)
    {
        if (is_null($request->uid)) {
            $code = 1000;
            $info = "Token does not exist";
        } else {
            $info = "";
            Carbon::setLocale('zh');
            $expiresAt = Carbon::now()->subDays(30);
            $billObj = Bill::where(["created_by" => $request->uid])->where('created_at', '>=', $expiresAt->toDateTimeString())->orderBy('created_at', 'desc')->get();
            $bill = [];
            if ($billObj->isNotEmpty()) {
                $bill = $billObj->toArray();
            }
        }
        return view('trade.daily_bill', compact('bill', 'info'));
    }
}