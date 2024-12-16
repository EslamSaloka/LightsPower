<?php

namespace App\Http\Controllers\API\Posts;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Post\CommentRequests;
// Resources
use App\Http\Resources\API\Post\CommentResources;
// Models
use App\Models\Post;
use App\Models\Post\Comment;
use App\Models\Post\Comment\Like;
// Support
use App\Support\API;
use Illuminate\Support\Facades\Auth;

class PostCommentsRepliesController extends Controller
{
    public function index(Post $post,Comment $comment) {
        if($comment->post_id != $post->id) {
            return (new API)->isError(__("هذا التعليق ليس موجود في هذا المنشور"))->build();
        }
        return (new API)->isOk(__("عرض التعليقات"))->setData(CommentResources::collection($comment->comments()->get()))->build();
    }

    public function store(CommentRequests $request,Post $post,Comment $comment) {
        $request = $request->validated();
        $request['user_id'] = Auth::user()->id;
        $request['post_id'] = $post->id;
        $request['comment_id'] = $comment->id;
        $reply = $comment->comments()->create($request);
        if(Auth::user()->id != $post->user_id) {
            // ======================================== //
            makeNewNotification("post-comment-replay",$comment->user,Auth::user(),$comment->id);
            // ======================================== //
        }
        return (new API)->isOk(__("تم حفظ التعليق"))->setData(new CommentResources($reply))->build();
    }

    public function update(CommentRequests $request,Post $post,Comment $comment,Comment $reply) {
        $reply->update($request->validated());
        return (new API)->isOk(__("تم تحديث التعليق"))->setData(new CommentResources($reply))->build();
    }

    public function destroy(Post $post,Comment $comment,Comment $reply) {
        $reply->delete();
        return (new API)->isOk(__("تم مسح التعليق"))->build();
    }

    public function makeLikeAndDisLike(Post $post,Comment $comment) {
        $user = Auth::user();
        $like = Like::where([
            "user_id"     => $user->id,
            "comment_id"  => $comment->id,
        ])->first();
        if(is_null($like)) {
            $like = Like::create([
                "user_id"    => $user->id,
                "comment_id" => $comment->id,
            ]);
            if(Auth::user()->id != $comment->user_id) {
                // ======================================== //
                if($comment->comment_id == 0) {
                    makeNewNotification("post-comment-like",$comment->user,Auth::user(),$comment->id);
                } else {
                    makeNewNotification("post-comment-reply-like",$comment->user,Auth::user(),$comment->id);
                }
                // ======================================== //
            }
        } else {
            $like->delete();
        }
        return (new API)->isOk(__("تم تغير حاله الإعجاب"))->build();
    }

}
