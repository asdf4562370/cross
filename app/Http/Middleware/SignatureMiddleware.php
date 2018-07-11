<?php
/**
 * 签名
 * Created by TRush.
 * Date: 2017/12/06
 * Time: 16:09
 */

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    public function handle($request, Closure $next) {
        $request->uid = "5a4b4ba4cdb36737bf02be52";                  //用户UID

        return $next($request);
    }
}