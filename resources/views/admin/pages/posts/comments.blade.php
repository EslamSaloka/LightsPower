
@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

<div class="row row-sm">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card custom-card">
            @if ($lists->count() > 0)
            <div class="card-body">
                <div class="table-responsive border newlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>@lang('Name')</span></th>
                                <th class="wd-lg-20p">
                                    <span>
                                        الردود
                                    </span>
                                </th>
                                <th class="wd-lg-8p"><span>@lang('عدد الإعجابات')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Created At')</span></th>
                                <th class="wd-lg-20p">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        @canAny('customers.edit')
                                            <a href="{{ route('admin.customers.edit',$list->user_id) }}">
                                                {{ $list->user->username ?? '' }}
                                            </a>
                                        @else
                                            {{ $list->user->username ?? '' }}
                                        @endcanAny
                                    </td>
                                    <td>
                                        {!! $list->display_comment !!}
                                    </td>
                                    <td>
                                        {{ $list->likes()->count() }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() ?? '' }}
                                    </td>
                                    <td>
                                        @canAny('posts.destroy')
                                            @include('admin.component.buttons.delete_actions', [
                                                'url' => route('admin.posts.comments.destroy',[$post->id,$list->id]),
                                            ])
                                        @endcanAny
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $lists->withQueryString()->links('admin.layouts.inc.paginator') }}
            </div>
            @else
            @include('admin.component.inc.nodata', [
                'name' => __('المنشورات')
            ])
            @endif
        </div>
    </div>
</div>

@include('admin.component.modals.delete')

@endsection
