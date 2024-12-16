<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\API;

class CheckSendDevToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $dev_token = request()->header("devices-token");
        if(is_null($dev_token)) {
            return (new API())->isError(__('برجاء إرسال كود الجهاز'))->setErrors([
                "devices_token" => __("برجاء إرسال كود الجهاز")
            ])->build();
        }
        return $next($request);
    }
}
