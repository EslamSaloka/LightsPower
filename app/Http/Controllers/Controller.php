<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $hasNoPermissions = false;

    public function __construct(Request $request)
    {
        if ( $request->header('hasNoPermissions') ) {
            $this->hasNoPermissions = true;
        }
        $this->middleware(function ($request, $next) {
            if (request()->is('*dashboard*') && !request()->is('*api*') && !str_contains(Route::currentRouteName(), 'home')) {
                if(auth()->check()) {
                    // if(\Auth::user()->suspend == 1) {
                    //     \Auth::logout();
                    // }
                    $routeName = Route::currentRouteName();
                    $routeName = substr($routeName, 6);
                    $routeName = preg_replace('/\bstore\b/u', 'create', $routeName);
                    $routeName = preg_replace('/\bupdate\b/u', 'edit', $routeName);
                    if(! $this->hasNoPermissions && !str_contains($routeName, 'notifications')
                            && !str_contains($routeName, 'excel_template')
                            && !str_contains($routeName, 'posts.comments.show')
                            && !str_contains($routeName, 'change_store_information')
                            && !str_contains($routeName, 'products.rates.index')
                            && !str_contains($routeName, 'plans.payment_pay')
                            && !str_contains($routeName, 'stores.rates.index')
                            && !str_contains($routeName, 'stores.plans')
                            && !str_contains($routeName, 'stores-requests.active')
                            && !str_contains($routeName, 'orders.refund')
                            && !str_contains($routeName, 'stores-requests.cancel')
                            && !str_contains($routeName, 'products.image.delete')
                            && !str_contains($routeName, 'chats.index')
                            && !str_contains($routeName, 'chats.show')
                            && !str_contains($routeName, 'ppaln')
                            && !str_contains($routeName, 'plans.addHistory')
                            && !str_contains($routeName, 'posts.comments.destroy')
                            && !str_contains($routeName, 'carts.index')
                            && !str_contains($routeName, 'carts.show')
                            && !str_contains($routeName, 'chats.edit')
                            && !str_contains($routeName, 'SupplierDocument.send')
                            && !str_contains($routeName, 'roles.destroy')
                            && !str_contains($routeName, 'store_notifications.index')
                            && !str_contains($routeName, 'store_notifications.create')
                            && !str_contains($routeName, 'categories.getMenu')
                            && !str_contains($routeName, 'tradeIndex.index')
                            && !str_contains($routeName, 'orders.edit')
                            && !str_contains($routeName, 'products.amounts.index')
                            && !str_contains($routeName, 'products.amounts.create')
                            && !str_contains($routeName, 'store_local_notifications.index')
                            && !str_contains($routeName, 'store_local_notifications.destroy')
                            && !str_contains($routeName, 'favorites.index')
                            && !str_contains($routeName, 'favorites.show')
                            && !str_contains($routeName, 'profile') && !str_contains($routeName, 'change_password') && !auth()->user()->hasAnyPermission($routeName)) {
                        return abort(403, 'Unauthorized action');
                    }
                }
            }
            return $next($request);
        })->except('logout');
    }
}
