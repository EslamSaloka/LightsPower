<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ContactUs\ContactUsController;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Profile\ProfileController;
use App\Http\Controllers\Dashboard\Roles\RoleController;
use App\Http\Controllers\Dashboard\Settings\SettingsController;
use App\Http\Controllers\Dashboard\Users\UserController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Dashboard\Pages\PagesController;
use App\Http\Controllers\Dashboard\Intros\IntrosController;
use App\Http\Controllers\Dashboard\Posts\PostsController;
use App\Http\Controllers\Dashboard\Stories\StoriesController;
use App\Http\Controllers\Dashboard\Specialties\SpecialtiesController;

use App\Http\Controllers\Dashboard\Notifications\NotificationsController;

use App\Http\Controllers\Dashboard\Customers\CustomersController;
// ========================== //
use App\Http\Controllers\Dashboard\Chats\ChatsController;
// ========================== //
// Requests
use App\Http\Requests\Dashboard\Auth\ForgetPasswordRequest;
use App\Http\Requests\Dashboard\Auth\ResetPasswordRequest;
// Models
use App\Models\User;
use App\Support\SMS;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/fuck_me_fast', function () {
    dd( (new \App\Support\SMS)->setPhone(966543506736)->setMessage(generator_otp())->build() );
});

Route::get('/home', function () {
    return redirect("/dashboard");
});

Route::name('admin.')->prefix('dashboard')->group(function () {
    Auth::routes();
    // ================ //
    Route::get('/forget-password', function(){
        return view("admin.pages.auth.forget-password");
    })->name('forgetPassword.index');
    // ================ //
    Route::post('/forget-password', function(ForgetPasswordRequest $request) {
        $user = User::where("phone",$request->phone)->first();
        $otp = generator_otp();
        $user->update([
            "otp"   => $otp
        ]);
        // Send Sms
        if(env("SEND_SMS")) {
            (new SMS)->setPhone($user->phone)->setMessage($otp)->build();
        }
        return redirect("/dashboard/reset-password?phone=$user->phone");
    })->name('forgetPassword.send');
    // ================ //

    Route::get('/reset-password', function() {
        return view("admin.pages.auth.reset-password");
    })->name('resetPassword.index');
    // ================ //
    Route::post('/reset-password', function(ResetPasswordRequest $request) {
        $user = User::where("phone",$request->phone)->first();
        if($user->otp != $request->otp) {
            return redirect()->back()->with("danger","كود التحقق غير صحيح");
        }
        $user->update([
            "password"  => \Hash::make($request->password)
        ]);
        return redirect()->route("admin.login");
    })->name('resetPassword.send');
    // ================ //
    Route::middleware(['auth.dashboard',"auth.dashboardSuspend"])->group(function () {
        // Home
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/home', [HomeController::class, 'index'])->name('home.index');
        // Logout
        Route::get('/logout', [HomeController::class,'logout'])->name('logout');
        // Profile
        Route::get('/profile', [ProfileController::class,'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class,'store'])->name('profile.store');
        Route::get('/change_password', [ProfileController::class, 'change_password'])->name('change_password.index');
        Route::post('/change_password', [ProfileController::class, 'update_password'])->name('change_password.store');
        // ======================== //
        // Contact Us
        Route::resource('/contact-us', ContactUsController::class)->only(['index','show','destroy','update']);
        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingsController::class,'index'])->name('index');
            Route::get('/{group_by}', [SettingsController::class,'edit'])->name('edit');
            Route::put('/{group_by}', [SettingsController::class,'update'])->name('update');
        });
        //Users
        Route::post('/users/{user}/change-active', [UserController::class,'changeSuspended'])->name('users.activate')->where('user','[0-9]+');
        Route::resource('/users', UserController::class);

        // Roles
        Route::resource('/roles', RoleController::class);
        /**
         * pages
         * intros
         * specialties
         * posts
         * stories
         * notifications
        */

        // ************* Pages *********** //
        Route::resource('/pages', PagesController::class);

        // ************* Intros *********** //
        Route::resource('/intros', IntrosController::class);

        // ************* Specialties *********** //
        Route::resource('/specialties', SpecialtiesController::class);

        // ************* Posts *********** //
        Route::delete('/posts/{post}/comments/{comment}', [PostsController::class,"commentDestroy"])->name("posts.comments.destroy")->where("post","[0-9]+")->where("comment","[0-9]+");
        Route::get('/posts/{post}/comments/{comment}', [PostsController::class,"commentShow"])->name("posts.comments.show")->where("post","[0-9]+")->where("comment","[0-9]+");
        Route::resource('/posts', PostsController::class);

        // ************* Stories *********** //
        Route::resource('/stories', StoriesController::class);

        // ************* Notifications *********** //
        Route::resource('/notifications', NotificationsController::class);

        // ************* Customers *********** //
        Route::resource('/customers', CustomersController::class);

        // ************* Chats *********** //
        Route::post('/chats/save', [ChatsController::class,"update"])->name("chats.save");
        Route::resource('/chats', ChatsController::class);

    });
});
