<?php

namespace App\Http\Controllers\API\Posts;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Post\PostRequests;
use App\Http\Requests\API\Post\PostUpdateRequests;
use App\Http\Requests\API\Post\CommentRequests;
use App\Http\Requests\API\Post\ShareRequests;
// Resources
use App\Http\Resources\API\Post\PostResources;
use App\Http\Resources\API\Post\CommentResources;
use App\Http\Resources\API\Post\LikeResources;
// Models
use App\Models\User;
use App\Models\Post;
use App\Models\Post\Comment;
use App\Models\Post\Image;
use App\Models\Post\Like;
use App\Models\Product;
// Support
use App\Support\API;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function index() {
        $posts = Post::where("parent",0);
        $ids   = Auth::user()->iFollow()->pluck("follow_id")->toArray();
        $ids[] = Auth::user()->id;
        $posts = $posts->whereIn("user_id",$ids);
        $posts = $posts->orderBy("id","desc")->paginate();
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("المنشورات"))
                ->setData(PostResources::collection($posts))
                ->addAttribute("paginate",api_model_set_paginate($posts))->build();
    }

    public function show(Post $post) {
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("المنشورات"))
                ->setData(new PostResources($post))
                ->addAttribute("comments",CommentResources::collection($post->comments()->where('comment_id',0)->orderBy("id","desc")->get()))
                ->addAttribute("likes",LikeResources::collection($post->likes()->orderBy("id","desc")->get()))
                ->build();
    }

    public function store(PostRequests $request) {
        $request = $request->all();
        $thread = 0;
        $request["user_id"] = Auth::user()->id;
        if($thread == 1) {
            $array = wordwrap($request["description"],280,"<br />\n");
            $content = explode("<br />\n",$array);
            $request["description"] = $content[0];
        }
        $request["post_type"] = "text";
        $post = Post::create($request);
        if($thread == 1) {
            foreach($content as $k=>$v) {
                if($k != 0) {
                    if($v != '') {
                        Post::create([
                            'user_id'       => Auth::user()->id,
                            'description'   => $v,
                            'parent'        => $post->id,
                            'post_type'     => "text",
                        ]);
                    }
                }
            }
        }
        foreach(request("images",[]) as $image) {
            $post->images()->create([
                "image" => (new \App\Support\Image)->FileUpload($image,"posts")
            ]);
        }
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)
        ->isOk(__("تم إضافه منشورك بنجاح"))
        ->setData(new PostResources($post))
        ->build();
    }

    public function update(PostUpdateRequests $request,Post $post) {
        if(Auth::user()->id != $post->user_id) {
            return (new API)->isError(__("ليس لديك صلاحية بالتعديل في هذا المنشور"))->build();
        }
        $post->update($request->all());
        foreach(request("images",[]) as $image) {
            $post->images()->create([
                "image" => (new \App\Support\Image)->FileUpload($image,"posts")
            ]);
        }
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم تعديل منشورك بنجاح"))->build();
    }

    public function deleteImage(Post $post,Image $image) {
        $user = Auth::user();
        if($user->id != $post->user_id) {
            return (new API)->isError(__("ليس لديك صلاحية بالتعديل في هذا المنشور"))->build();
        }
        if($image->post_id != $post->id) {
            return (new API)->isError(__("لا يمكنك حذف الصوره"))->build();
        }
        $image->delete();
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم حذف صوره المنشور"))->build();
    }

    public function destroy(Post $post) {
        $user = Auth::user();
        if($user->id != $post->user_id) {
            return (new API)->isError(__("ليس لديك صلاحية بحذف هذا المنشور"))->build();
        }
        $post->comments()->delete();
        $post->likes()->delete();
        $post->images()->delete();
        $post->shares()->delete();
        Post::where("parent",$post->id)->delete();
        $post->delete();
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم حذف منشورك"))->build();
    }

    public function likeOrDislike(Post $post) {
        $user = Auth::user();
        $like = Like::where([
            "user_id"   => $user->id,
            "post_id"   => $post->id,
        ])->first();
        if(is_null($like)) {
            $like = Like::create([
                "user_id"   => $user->id,
                "post_id"   => $post->id,
            ]);
            // ======================================= //
            if($post->user_id != Auth::user()->id) {
                $message = __(":USERNAME liked on your post",["USERNAME"=>$user->username,"POST_TITLE"=>substr($post->description, 0, 30)]);
                // \App\Models\User\Notification::create([
                //     "user_id"       => $post->user_id,
                //     "model_id"      => $post->id,
                //     "model_type"    => "like_post",
                //     "body"          => $message,
                // ]);
                // $tokens = \App\Models\User\Token::where("user_id",$post->user_id)->pluck("token")->toArray();
                // (new \App\Support\FireBase)->setTitle(env("APP_NAME"))
                //     ->setBody($message)
                //     ->setToken($tokens)
                //     ->build();
                makeNewNotification("post-like",$post->user,Auth::user(),$post->id);
            }
            // ======================================= //
        } else {
            $like->delete();
        }
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم تغير حاله الإعجاب"))->build();
    }

    public function storeComment(CommentRequests $request,Post $post) {
        $comment = $post->comments()->create([
            "user_id"   => Auth::user()->id,
            "comment"   => request("comment")
        ]);

        if($post->user_id != Auth::user()->id) {
            // ======================================= //
            // $message = __(":USERNAME commented on your post",["USERNAME"=>$comment->user->username,"POST_TITLE"=>substr($post->description, 0, 30)]);
            // \App\Models\User\Notification::create([
            //     "user_id"       => $post->user_id,
            //     "model_id"      => $post->id,
            //     "model_type"    => "post_comment",
            //     "body"          => $message,
            // ]);

            // $tokens = \App\Models\User\Token::where("user_id",$post->user_id)->pluck("token")->toArray();
            // (new \App\Support\FireBase)->setTitle(env("APP_NAME"))
            //     ->setBody($message)
            //     ->setToken($tokens)
            //     ->build();
            makeNewNotification("post-comment",$post->user,Auth::user(),$comment->id);
            // ======================================= //
        }
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم إضافه تعليق"))->build();
    }

    public function updateComment(CommentRequests $request,Post $post,Comment $comment) {
        $user = Auth::user();
        if($user->id != $post->user_id) {
            return (new API)->isError(__("هذا المنشور ليس لك"))->build();
        }
        if($comment->post_id != $post->id) {
            return (new API)->isError(__("لا يمكنك تعديل العليق"))->build();
        }
        $comment->update([
            "comment"   => request("comment")
        ]);
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم تعديل تعليقك"))->build();
    }

    public function deleteComment(Post $post,Comment $comment) {
        $user = Auth::user();
        if($user->id != $post->user_id) {
            return (new API)->isError(__("هذا المنشور ليس لك"))->build();
        }
        if($comment->post_id != $post->id) {
            return (new API)->isError(__("لا يمكنك حذف العليق"))->build();
        }
        $comment->delete();
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم حذف تعليقك بنجاح"))->build();
    }

    public function share(ShareRequests $request) {

        // Validation
        $check = Post::find($request->post_type_id);
        if(is_null($check)) {
            return (new API)->isError(__("هذا المنشور غير موجود"))->build();
        }
        $post = Post::create([
            "user_id"        => Auth::user()->id,
            "post_type"      => "post",
            "post_type_id"   => $request->post_type_id,
            "description"    => $request->description ?? '',
        ]);
        \App\Models\Post\Share::create([
            "post_id"   => $request->post_type_id,
            "user_id"   => Auth::user()->id,
        ]);
        Auth::user()->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("تم المشاركة بنجاح"))->build();
    }
}
