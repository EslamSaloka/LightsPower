@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
<div class="row">

    <div class="col-lg-8">
        <div class="card custom-card">
            <div class="main-content-app pt-0">
                <div class="main-content-body main-content-body-chat">
                    <div class="main-chat-body" id="ChatBody">
                        <div class="content-inner">
                            @foreach ($messages as $item)
                                    <div class="media @if ($item->user_id != \Auth::user()->id) flex-row-reverse @endif">
                                        <div class="main-img-user online"><img alt="{{ $item->user->username }}" src="{{ displayAvatarByUser($item->user) }}"></div>
                                        <div class="media-body">
                                            <div class="main-msg-wrapper">
                                                @if($item->type == "text")
                                                    {{ $item->message }}
                                                @elseif($item->type == "product")
                                                    @canAny('products.edit')
                                                        <a href="{{ route('admin.products.edit', $item->message) }}">
                                                            {{ $item->product->title ?? '' }}
                                                        </a>
                                                    @else
                                                        {{ $item->product->title ?? '' }}
                                                    @endcanAny
                                                @else
                                                    @canAny('stores.edit')
                                                        <a href="{{ route('admin.stores.edit', $item->message) }}">
                                                            {{ $item->store->storeRequest->store_name ?? '' }}
                                                        </a>
                                                    @else
                                                        {{ $item->store->storeRequest->store_name ?? '' }}
                                                    @endcanAny
                                                @endif
                                            </div>
                                            <div>
                                                <span>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() ?? '' }}</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                            <div id="a"></div>
                        </div>
                    </div>
                    <div class="main-chat-footer">
                        <form action="{{ route('admin.chats.update',$chat->id) }}" method="post" enctype="multipart/form-data">
                            <input name="message" class="form-control" placeholder="نص الرساله..." type="text">
                            @method("PUT")
                            @csrf
                            <button style=" background: white; border: 0px; position: absolute; left: 10px; " type="submit" class="main-msg-send"><i class="far fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
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
                                @lang('Name')
                            </td>
                            <td>
                                {{ $user['username'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Email')
                            </td>
                            <td>
                                <a href="mailto:{{ $user['email'] }}">{{ $user['email'] }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Phone')
                            </td>
                            <td>
                                <a href="tel:{{ $user['phone'] }}">{{ $user['phone'] }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('أخر ظهور')
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($user['last_seen'])->diffForHumans() ?? '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        $(function() {
            'use strict'
            const ps1 = new PerfectScrollbar('#ChatBody', {
                suppressScrollX: true
            });
        });
        $('#ChatBody').animate({ scrollTop:  $("#a").offset().top - 50 }, 'slow');
    </script>
@endpush