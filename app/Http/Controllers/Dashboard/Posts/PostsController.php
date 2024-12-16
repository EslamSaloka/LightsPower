<?php

namespace App\Http\Controllers\Dashboard\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Post\Comment;

class PostsController extends Controller
{
    protected $fileName = "posts";
    protected $controllerName = "المنشورات";
    protected $routeName = "posts";

    public function index() {
        $breadcrumb = [
            'title' =>  __("قائمة $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("قائمة $this->controllerName"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ]
            ],
        ];
        $lists = new Post;
        if(request()->has("user_id") && request("user_id") != "-1") {
            $lists = $lists->where("user_id",request("user_id"));
        }
        if(request()->has("hashtag") && request("hashtag") != "") {
            $lists = $lists->where("description","like","%".request("hashtag")."%");
        }
        $lists = $lists->where("parent",0)->latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function show(Request $request,Post $post) {
        $breadcrumb = [
            'title' =>  __("قائمة $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("قائمة $this->controllerName"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("عرض $this->controllerName"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.$this->fileName.show",get_defined_vars());
    }

    public function destroy(Post $post) {
        $post->comments()->delete();
        $post->likes()->delete();
        $post->images()->delete();
        $post->shares()->delete();
        Post::where("parent",$post->id)->delete();
        $post->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('تم حذف البيانات'));
    }

    public function commentShow(Post $post,Comment $comment) {
        $breadcrumb = [
            'title' =>  __("قائمة الردود"),
            'items' =>  [
                [
                    'title' =>  __("قائمة المنشورات"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("عرض المنشور"),
                    'url'   =>  route("admin.$this->routeName.show",$post->id),
                ],
            ],
        ];
        $lists = $comment->comments()->latest()->paginate();
        return view("admin.pages.$this->fileName.comments",get_defined_vars());
    }

    public function commentDestroy(Post $post,Comment $comment) {
        $comment->delete();
        return redirect()->route("admin.$this->fileName.show",$post->id)->with('success',__('تم حذف التعليق'));
    }
}
