<?php

namespace App\Http\Controllers\API\Search;

// Controllers
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Search\getObjectOfNotificationRequests;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Search\SearchRequests;
use App\Http\Resources\API\Post\CommentResources;
// Models
use App\Models\Post;
use App\Models\User;
// Support
use App\Support\API;
// Resources
use App\Http\Resources\API\User\UserResources;
use App\Http\Resources\API\Post\PostResources;
use App\Http\Resources\API\Story\StoryResources;
use App\Models\Post\Comment;
use App\Models\Story;
use App\Models\User\MAT;

class SearchController extends Controller
{
    public function index(SearchRequests $request) {
        $users = User::where("username","like","%".$request->text."%")->whereHas("roles",function($q){
            return $q->where("roles.name",User::TYPE_CUSTOMER);
        })->paginate();
        $posts = Post::where("description","like","%".$request->text."%")->paginate();
        return (new API)->isOk(__("البحث"))->setData([
            "users" => UserResources::collection($users),
            "posts" => PostResources::collection($posts),
        ])->addAttribute("usersPaginate",api_model_set_paginate($users))
        ->addAttribute("postsPaginate",api_model_set_paginate($posts))->build();
    }

    public function indexHashTag(SearchRequests $request) {
        $storiesIDS      = MAT::select('object_id')->whereJsonContains("tags",$request->text)->where("object_type","story")->pluck("object_id")->toArray();
        $postsIDS        = MAT::select('object_id')->whereJsonContains("tags",$request->text)->where("object_type","post")->pluck("object_id")->toArray();
        $commentsIDS     = MAT::select('object_id')->whereJsonContains("tags",$request->text)->where("object_type","comment")->pluck("object_id")->toArray();
        // ========================================= //
        $stories     = Story::whereIn("id",$storiesIDS)->paginate();
        $posts       = Post::whereIn("id",$postsIDS)->paginate();
        $comments    = Comment::whereIn("id",$commentsIDS)->paginate();
        return (new API)->isOk(__("البحث"))->setData([
            "stories"       => StoryResources::collection($stories),
            "posts"         => PostResources::collection($posts),
            "comments"      => CommentResources::collection($comments),
        ])
        ->addAttribute("storiesPaginate",api_model_set_paginate($stories))
        ->addAttribute("postsPaginate",api_model_set_paginate($posts))
        ->addAttribute("commentsPaginate",api_model_set_paginate($comments))
        ->build();
    }

    public function getObjectOfNotification(getObjectOfNotificationRequests $request) {
        if($request->model_type == "follow") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new UserResources(User::find($request->model_id)))->build();
        } else if($request->model_type == "un-follow") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new UserResources(User::find($request->model_id)))->build();
        } else if($request->model_type == "post-like") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new PostResources(Post::find($request->model_id)))->build();
        } else if($request->model_type == "post-comment") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new CommentResources(Comment::find($request->model_id)))->build();
        } else if($request->model_type == "post-comment-replay") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new CommentResources(Comment::find($request->model_id)))->build();
        } else if($request->model_type == "post-comment-like") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new CommentResources(Comment::find($request->model_id)))->build();
        } else if($request->model_type == "post-mention") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new PostResources(Post::find($request->model_id)))->build();
        } else if($request->model_type == "comment-mention") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new CommentResources(Comment::find($request->model_id)))->build();
        } else if($request->model_type == "story-mention") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new StoryResources(Story::find($request->model_id)))->build();
        } else if($request->model_type == "story-like") {
            return (new API)->isOk(__("عرض البيانات"))->setData(new StoryResources(Story::find($request->model_id)))->build();
        }
    }
}
