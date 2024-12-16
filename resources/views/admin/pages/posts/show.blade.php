@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
<div class="row">

    <div class="col-lg-8" style=" margin-bottom: 20px; ">
        @if ($post->post_type_id == 0)
            <div id="lay">
                <ul class="notification">
                    <li>
                        <div class="notification-icon">
                            <a href="javascript:void(0);"></a>
                        </div>
                        <div class="notification-body" style="padding:25px !important;;">
                            <div class="media mt-0">
                                <div class="media-body ms-3 d-flex">
                                    <div class="">
                                        <p class="mb-0 tx-13 text-muted" style="overflow-wrap: anywhere;font-size:15px;">{!! $post->display_description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @if ($post->threads()->count() > 0)
                        @foreach ($post->threads as $item)
                            <li>
                                <div class="notification-icon">
                                    <a href="javascript:void(0);"></a>
                                </div>
                                <div class="notification-body">
                                    <div class="media mt-0">
                                        <div class="media-body ms-3 d-flex">
                                            <div class="">
                                                <p class="mb-0 tx-13 text-muted" style="overflow-wrap: anywhere;">
                                                    <a href="{{ route("admin.posts.show",$item->id) }}">
                                                        {{ $item->display_description }}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        @else
            @if ($post->post_type == "post")
                @include('admin.pages.posts.more.post',["id"=>$post->post_type_id])
            @elseif ($post->post_type == "product")
                @include('admin.pages.posts.more.product',["id"=>$post->post_type_id])
            @else
                @include('admin.pages.posts.more.store',["id"=>$post->post_type_id])
            @endif

            @if (!is_null($post->display_description))
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" style=" position: relative; ">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5 class="font-size-15">@lang('تفاصيل المنشور') :</h5>
                                </div>
                            </div>
                            <p class="text-muted">
                                {!! $post->display_description !!}
                            </p>
                        </div>
                    </div>
                </div>
                <br>
            @endif
        @endif
        <div class="card">
            <div class="card-body" style=" position: relative; ">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="font-size-15">@lang('تعليقات المنشور') :</h5>
                    </div>
                </div>
                <ul id="chatsMessages">
                    @foreach ($post->comments()->where("comment_id",0)->orderBy("id","desc")->get() as $comment)
                        <li style="border: 1px solid #0000001c;border-radius: 7px;padding: 7px;margin-top: 15px;list-style: none;">
                            <div style="position: relative;border-bottom: 1px solid #00000014;padding-bottom: 5px;">
                                <img
                                    alt="avatar"
                                    class="rounded-circle avatar-md me-2"
                                    src="{{ (new \App\Support\Image)->displayImageByModel($comment->user,'avatar') }}">
                                    {{ $comment->user->username }}
                                    <div style=" position: absolute; left: 15px; top: 11px; ">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() ?? '' }}
                                    </div>
                                    <div style="position: absolute;right: -42px;top: 32px;">
                                        @include('admin.component.buttons.delete_actions', [
                                            'url' => route('admin.posts.comments.destroy',[$post->id,$comment->id]),
                                        ])
                                    </div>
                            </div>
                            <div style=" padding: 10px; ">
                                {!! $comment->display_comment !!}
                                <div style=" float: left; ">
                                    الردود ( <a href="{{ route('admin.posts.comments.show',[$post->id,$comment->id]) }}">{{ $comment->comments()->count() }}</a> )
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                @lang('المستخدم')
                            </td>
                            <td>
                                @canAny('customers.edit')
                                    <a href="{{ route('admin.customers.edit',$post->user_id) }}">
                                        {{ $post->user->username ?? '' }}
                                    </a>
                                @else
                                    {{ $post->user->username ?? '' }}
                                @endcanAny
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('الإعجابات')
                            </td>
                            <td>
                                {{ $post->likes()->count() ?? '0' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Created At')
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() ?? '' }}
                            </td>
                        </tr>
                        @if ($post->post_type_id == 0)
                            <tr>
                                <td>
                                    @lang('صور المنشور')
                                </td>
                                <td>
                                    <ul>
                                        @foreach($post->images as $image)
                                            <li>
                                                <img class="clickImage" src="{{ $image->display_image }}" width="50" alt="Thumb-1">
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.component.modals.delete')
@endsection


<!-- Modal -->
<div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="composemodalTitle">@lang('الصوره')</h5>
                <button aria-label="Close" class="btn btn-sm" data-bs-dismiss="modal" type="button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row showImage">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('إلغاء')</button>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        #lay {
            margin-right: -150px;
        }
        @media only screen and (max-width: 800px) {
            #lay {
                margin-right: 0px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(".clickImage").click(function() {
            $("#composemodal").modal("show");
            $(".showImage").html("<img src='"+$(this).attr("src")+"' />");
        });
    </script>
@endpush
