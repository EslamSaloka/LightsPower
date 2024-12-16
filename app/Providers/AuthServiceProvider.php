<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        if(request()->is("*api*")) {
            \Auth::viaRequest('token', function ($request) {
                $token =  request()->header("authorization");
                $dev_token = request()->header("devices-token");
                $token = str_replace("Bearer ","",$token);
                return User::with("tokens")->whereHas("tokens",function($q)use($dev_token,$token){
                    return $q->where("user_tokens.token",$token)->where("user_tokens.devices_token",$dev_token);
                })->first();
            });
        }

        $this->registerPolicies();

        //
    }
}
