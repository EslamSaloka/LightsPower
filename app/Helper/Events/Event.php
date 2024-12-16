<?php


/**
 * Stories
 * Posts
 * Comments
 */

use App\Models\User;

\App\Models\Story::created(function(\App\Models\Story $story){
    preg_match_all('/@{(.*?)}/', $story->description, $mentions);
    preg_match_all('/#{(.*?)}/', $story->description, $tags);
    if(count($mentions[1]) > 0 || count($tags[1]) > 0) {
        \App\Models\User\MAT::create([
            'object_id'     => $story->id,
            'object_type'   => "story",
            'mentions'      => $mentions[1],
            'tags'          => $tags[1],
        ]);
        // ========================================== //
        foreach($mentions[1] as $v) {
            makeNewNotification("story-mention",User::find($story->user_id),User::find($v),$story->id);
        }
        // ========================================== //
    }
});

\App\Models\Story::updating(function(\App\Models\Story $story){
    preg_match_all('/@{(.*?)}/', $story->description, $mentions);
    preg_match_all('/#{(.*?)}/', $story->description, $tags);
    if(count($mentions[1]) > 0 || count($tags[1]) > 0) {
        $check = \App\Models\User\MAT::where([
            'object_id'     => $story->id,
            'object_type'   => "story",
        ])->first();
        if(!is_null($check)) {
            $check->update([
                'mentions' => $mentions[1],
                'tags'     => $tags[1],
            ]);
        } else {
            \App\Models\User\MAT::create([
                'object_id'     => $story->id,
                'object_type'   => "story",
                'mentions'      => $mentions[1],
                'tags'          => $tags[1],
            ]);
            // ========================================== //
            foreach($mentions[1] as $v) {
                makeNewNotification("story-mention",User::find($story->user_id),User::find($v),$story->id);
            }
            // ========================================== //
        }
    }
});

// ================================================================= //


\App\Models\Post::created(function(\App\Models\Post $post){
    preg_match_all('/@{(.*?)}/', $post->description, $mentions);
    preg_match_all('/#{(.*?)}/', $post->description, $tags);
    if(count($mentions[1]) > 0 || count($tags[1]) > 0) {
        \App\Models\User\MAT::create([
            'object_id'     => $post->id,
            'object_type'   => "post",
            'mentions'      => $mentions[1],
            'tags'          => $tags[1],
        ]);
        foreach($mentions[1] as $v) {
            makeNewNotification("post-mention",User::find($post->user_id),User::find($v),$post->id);
        }
    }
});

\App\Models\Post::updating(function(\App\Models\Post $post){
    preg_match_all('/@{(.*?)}/', $post->description, $mentions);
    preg_match_all('/#{(.*?)}/', $post->description, $tags);
    if(count($mentions[1]) > 0 || count($tags[1]) > 0) {
        $check = \App\Models\User\MAT::where([
            'object_id'     => $post->id,
            'object_type'   => "post",
        ])->first();
        if(!is_null($check)) {
            $check->update([
                'mentions' => $mentions[1],
                'tags'     => $tags[1],
            ]);
        } else {
            \App\Models\User\MAT::create([
                'object_id'     => $post->id,
                'object_type'   => "post",
                'mentions'      => $mentions[1],
                'tags'          => $tags[1],
            ]);
            foreach($mentions[1] as $v) {
                makeNewNotification("post-mention",User::find($post->user_id),User::find($v),$post->id);
            }
        }
    }
});

// ================================================================= //


\App\Models\Post\Comment::created(function(\App\Models\Post\Comment $comment){
    preg_match_all('/@{(.*?)}/', $comment->comment, $mentions);
    preg_match_all('/#{(.*?)}/', $comment->comment, $tags);
    if(count($mentions[1]) > 0 || count($tags[1]) > 0) {
        \App\Models\User\MAT::create([
            'object_id'     => $comment->id,
            'object_type'   => "comment",
            'mentions'      => $mentions[1],
            'tags'          => $tags[1],
        ]);
        foreach($mentions[1] as $v) {
            makeNewNotification("comment-mention",User::find($comment->user_id),User::find($v),$comment->id);
        }
    }
});

\App\Models\Post\Comment::updating(function(\App\Models\Post\Comment $comment){
    preg_match_all('/@{(.*?)}/', $comment->comment, $mentions);
    preg_match_all('/#{(.*?)}/', $comment->comment, $tags);
    if(count($mentions[1]) > 0 || count($tags[1]) > 0) {
        $check = \App\Models\User\MAT::where([
            'object_id'     => $comment->id,
            'object_type'   => "comment",
        ])->first();
        if(!is_null($check)) {
            $check->update([
                'mentions' => $mentions[1],
                'tags'     => $tags[1],
            ]);
        } else {
            \App\Models\User\MAT::create([
                'object_id'     => $comment->id,
                'object_type'   => "comment",
                'mentions'      => $mentions[1],
                'tags'          => $tags[1],
            ]);
            foreach($mentions[1] as $v) {
                makeNewNotification("comment-mention",User::find($comment->user_id),User::find($v),$comment->id);
            }
        }
    }
});
