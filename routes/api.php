<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * Login //Done
 * OTP Phone //Done
 * Check OTP //Done
 * Completed Data ( Register ) //Done
 * Forget Password //Done
 * New Password //Done
 */

// Login
Route::post("login",[\App\Http\Controllers\API\Auth\LoginController::class,"store"]);
// OTP Phone
Route::post("otp",[\App\Http\Controllers\API\Auth\OTPController::class,"store"]);
// Check OTP
Route::post("check-otp",[\App\Http\Controllers\API\Auth\CheckOTPController::class,"store"]);
// Completed Data ( Register )
Route::post("completed-data",[\App\Http\Controllers\API\Auth\CompletedDataController::class,"store"])->middleware("auth:api","dev.token");
// Forget Password
Route::post("forget-password",[\App\Http\Controllers\API\Auth\ForgetPasswordController::class,"store"]);
// Re-send-otp
Route::post("re-send",[\App\Http\Controllers\API\Auth\ForgetPasswordController::class,"store"]);
// New Password
Route::post("new-password",[\App\Http\Controllers\API\Auth\NewPasswordController::class,"store"]);



/**
 * Settings //Done
 * Specialties //Done
 * Intros //Done
 * Send Message //Done
 * Pages //Done
 * Show Single Page //Done
*/

// Settings
Route::get("settings",[\App\Http\Controllers\API\Settings\SettingsController::class,"index"]);
// Specialties
Route::get("specialties",[\App\Http\Controllers\API\Specialties\SpecialtiesController::class,"index"]);
// Intros
Route::get("intros",[\App\Http\Controllers\API\Intros\IntrosController::class,"index"]);
// Categories
Route::get("categories",[\App\Http\Controllers\API\Categories\CategoriesController::class,"index"]);
// Plans
Route::get("plans",[\App\Http\Controllers\API\Plans\PlansController::class,"index"]);
// Send Message
Route::post("send-message",[\App\Http\Controllers\API\Contacts\ContactsController::class,"store"])->middleware(["auth:api","dev.token","auth.customer"]);
// Show Single Page
Route::get("pages/{key}",[\App\Http\Controllers\API\Pages\PagesController::class,"show"]);
// menus
Route::get("menus",[\App\Http\Controllers\API\Store\Menus\MenusController::class,"index"]);

/**
 * Show My Profile //Done
 * Edit My Profile //Done
 * Change Password //Done
 * Change Avatar //Done
 * Change Cover //Done
 * Notifications //Done
*/

Route::prefix("my-profile")->middleware(["auth:api","dev.token","auth.customer"])->group(function(){
    // profile
    Route::get("/",[\App\Http\Controllers\API\Profile\ProfileController::class,"index"]);
    Route::post("/",[\App\Http\Controllers\API\Profile\ProfileController::class,"update"]);
    // change-password
    Route::post("/change-password",[\App\Http\Controllers\API\Profile\ProfileController::class,"updatePassword"]);
    // change-avatar
    Route::post("/change-avatar",[\App\Http\Controllers\API\Profile\ProfileController::class,"updateAvatar"]);
    // change-cover
    Route::post("/change-cover",[\App\Http\Controllers\API\Profile\ProfileController::class,"updateCover"]);
    // specialties
    Route::get("/my-specialties",[\App\Http\Controllers\API\Profile\ProfileController::class,"specialties"]);
    Route::post("/my-specialties",[\App\Http\Controllers\API\Profile\ProfileController::class,"specialtiesUpdate"]);
    // interests
    Route::get("/my-interests",[\App\Http\Controllers\API\Profile\ProfileController::class,"interests"]);
    Route::post("/my-interests",[\App\Http\Controllers\API\Profile\ProfileController::class,"interestsUpdate"]);
    // my-posts
    Route::get("/my-posts",[\App\Http\Controllers\API\Profile\ProfileController::class,"getMyPosts"]);
    // my-Stories
    Route::get("/my-stories",[\App\Http\Controllers\API\Profile\ProfileController::class,"getMyStories"]);
    // NOTIFICATIONS
    Route::prefix("notifications")->group(function(){
        Route::get("/",[\App\Http\Controllers\API\Profile\NotificationsController::class,"index"]);
        Route::get("/{notification}",[\App\Http\Controllers\API\Profile\NotificationsController::class,"show"])->where("notification","[0-9]+");
        Route::delete("/{notification}",[\App\Http\Controllers\API\Profile\NotificationsController::class,"destroy"])->where("notification","[0-9]+");
        // ======================================== //
        Route::get("/read-all-notifications",[\App\Http\Controllers\API\Profile\NotificationsController::class,"readAll"]);
        Route::get("/delete-all-notifications",[\App\Http\Controllers\API\Profile\NotificationsController::class,"destroyAll"]);
    });
    // More Actions
    Route::get("/get-notifications-count",[\App\Http\Controllers\API\Profile\ProfileController::class,"notificationsCount"]);
    Route::get("/get-followers",[\App\Http\Controllers\API\Profile\ProfileController::class,"followers"]);
    Route::get("/get-following",[\App\Http\Controllers\API\Profile\ProfileController::class,"following"]);
    Route::get("/get-followers-following",[\App\Http\Controllers\API\Profile\ProfileController::class,"followersAndFollowing"]);
    Route::post("/delete-account",[\App\Http\Controllers\API\Profile\ProfileController::class,"accountDestroy"]);
    Route::post("/logout",[\App\Http\Controllers\API\Profile\ProfileController::class,"logout"]);
});



/**
 * Stories //Done
 * Posts & comments & likes //Done
 * Profile & follow //Done
 * Share Posts
 * Chats //Done
*/

Route::prefix("stories")->middleware(["auth:api","dev.token","auth.customer"])->group(function(){
    Route::get("/",[\App\Http\Controllers\API\Stories\StoriesController::class,"index"]);
    Route::get("/all",[\App\Http\Controllers\API\Stories\StoriesController::class,"indexAll"])->where("story","[0-9]+");
    Route::get("/getSpecialties",[\App\Http\Controllers\API\Stories\StoriesController::class,"getSpecialties"]);
    Route::post("/",[\App\Http\Controllers\API\Stories\StoriesController::class,"store"]);
    Route::delete("/{story}",[\App\Http\Controllers\API\Stories\StoriesController::class,"destroy"])->where("story","[0-9]+");
    Route::get("/{story}/likes",[\App\Http\Controllers\API\Stories\StoriesController::class,"likes"])->where("story","[0-9]+");
    // Route::get("/{story}/view",[\App\Http\Controllers\API\Stories\StoriesController::class,"view"])->where("story","[0-9]+");
    Route::get("/{story}/show",[\App\Http\Controllers\API\Stories\StoriesController::class,"show"])->where("story","[0-9]+");
});

Route::prefix("profile")->middleware(["auth:api","dev.token","auth.customer"])->group(function(){
    Route::get("/{profile}",[\App\Http\Controllers\API\Profile\AccountController::class,"index"])->where("profile","[0-9]+");
    Route::get("/{profile}/follow",[\App\Http\Controllers\API\Profile\AccountController::class,"follow"])->where("profile","[0-9]+");
    Route::get("/{profile}/posts",[\App\Http\Controllers\API\Profile\AccountController::class,"posts"])->where("profile","[0-9]+");
    Route::get("/{profile}/stories",[\App\Http\Controllers\API\Profile\AccountController::class,"stories"])->where("profile","[0-9]+");
});

Route::prefix("posts")->middleware(["auth:api","dev.token","auth.customer"])->group(function(){
    // Posts
    Route::get("/",[\App\Http\Controllers\API\Posts\PostsController::class,"index"]);
    Route::get("/{post}",[\App\Http\Controllers\API\Posts\PostsController::class,"show"]);
    Route::post("/",[\App\Http\Controllers\API\Posts\PostsController::class,"store"]);
    Route::post("/{post}/update",[\App\Http\Controllers\API\Posts\PostsController::class,"update"])->where("post","[0-9]+");
    Route::get("/{post}/like",[\App\Http\Controllers\API\Posts\PostsController::class,"likeOrDislike"])->where("post","[0-9]+");
    Route::delete("/{post}",[\App\Http\Controllers\API\Posts\PostsController::class,"destroy"])->where("post","[0-9]+");
    // image
    Route::delete("/{post}/image/{image}",[\App\Http\Controllers\API\Posts\PostsController::class,"deleteImage"])->where("post","[0-9]+")->where("image","[0-9]+");
    // Comment Reply
    Route::get("/{post}/comments/{comment}/replies",[\App\Http\Controllers\API\Posts\PostCommentsRepliesController::class,"index"])->where("post","[0-9]+")->where("comment","[0-9]+");
    Route::post("/{post}/comments/{comment}/replies",[\App\Http\Controllers\API\Posts\PostCommentsRepliesController::class,"store"])->where("post","[0-9]+")->where("comment","[0-9]+");
    Route::put("/{post}/comments/{comment}/replies/{reply}",[\App\Http\Controllers\API\Posts\PostCommentsRepliesController::class,"update"])->where("post","[0-9]+")->where("comment","[0-9]+")->where('reply',"[0-9]+");
    Route::delete("/{post}/comments/{comment}/replies/{reply}",[\App\Http\Controllers\API\Posts\PostCommentsRepliesController::class,"destroy"])->where("post","[0-9]+")->where("comment","[0-9]+")->where('reply',"[0-9]+");
    // Comment LIKE-DISLIKE
    Route::get("/{post}/comments/{comment}/like",[\App\Http\Controllers\API\Posts\PostCommentsRepliesController::class,"makeLikeAndDisLike"])->where("post","[0-9]+")->where("comment","[0-9]+");
    // Comments
    Route::post("/{post}/comments",[\App\Http\Controllers\API\Posts\PostsController::class,"storeComment"])->where("post","[0-9]+")->where("comment","[0-9]+");
    Route::post("/{post}/comments/{comment}/update",[\App\Http\Controllers\API\Posts\PostsController::class,"updateComment"])->where("post","[0-9]+")->where("comment","[0-9]+");
    Route::delete("/{post}/comments/{comment}",[\App\Http\Controllers\API\Posts\PostsController::class,"deleteComment"])->where("post","[0-9]+")->where("comment","[0-9]+");
    // Share
    Route::post("/share",[\App\Http\Controllers\API\Posts\PostsController::class,"share"]);
});

// ***************************************************
// ********************* Chats *********************
// ***************************************************
Route::prefix("chats")->middleware(["auth:api","dev.token","auth.customer"])->group(function(){
    Route::get("/",[\App\Http\Controllers\API\Chat\ChatController::class,"index"]);
    Route::get("/{chat}",[\App\Http\Controllers\API\Chat\ChatController::class,"show"])->where("chat","[0-9]+");
    Route::get("/{chat}/message/{message}/delete",[\App\Http\Controllers\API\Chat\ChatController::class,"delete"])->where("chat","[0-9]+")->where("message","[0-9]+");
    Route::post("/",[\App\Http\Controllers\API\Chat\ChatController::class,"store"]);
    Route::post("/search",[\App\Http\Controllers\API\Chat\ChatController::class,"search"]);
});

// ***************************************************
// ********************* Search *********************
// ***************************************************
Route::prefix("search")->middleware(["auth:api","dev.token","auth.customer"])->group(function(){
    Route::post("/",[\App\Http\Controllers\API\Search\SearchController::class,"index"]);
    Route::post("/hash-tag",[\App\Http\Controllers\API\Search\SearchController::class,"indexHashTag"]);
});
Route::post("/get-object-notification",[\App\Http\Controllers\API\Search\SearchController::class,"getObjectOfNotification"])->middleware(["auth:api","dev.token","auth.customer"]);
