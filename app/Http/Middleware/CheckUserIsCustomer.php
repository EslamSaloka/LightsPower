<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\API;

class CheckUserIsCustomer
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
        if(\Auth::check()) {
            if(!in_array(\App\Models\User::TYPE_CUSTOMER,\Auth::user()->roles()->pluck("name")->toArray())) 
            {
                return (new API)->isError(__("لا يوجد لديك صلاحيه بالتواجد هنا"))->build();
            }
            
            if(is_null(\Auth::user()->completed_at)) {
                return (new API)->isError(__("برجاء إستكمال بيانات الحساب اولا"))->build();
            }
            
            \Auth::user()->update([
                "last_action_at"    => \Carbon\Carbon::now()
            ]);
        }
        return $next($request);
    }
}
