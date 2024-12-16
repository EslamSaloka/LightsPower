
@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

@section('buttons')
    @include('admin.component.buttons.filter')
@endsection

<div class="row row-sm">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card custom-card">
            @if ($lists->count() > 0)
            <div class="card-body">
                <div class="table-responsive border newlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>المنشور</span></th>
                                <th class="wd-lg-8p"><span>@lang('Name')</span></th>
                                <th class="wd-lg-20p">
                                    <span>
                                        محتوى المنشور
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
                                        {{ $list->id ?? '' }}
                                    </td>
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
                                        {!! $list->display_description !!}
                                    </td>
                                    <td>
                                        {{ $list->likes()->count() }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() ?? '' }}
                                    </td>
                                    <td>
                                        @canAny('posts.show')
                                            <a href="{{ route('admin.posts.show',$list->id) }}" class="btn btn-sm btn-info">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                        @endcanAny
                                        @canAny('posts.destroy')
                                            @include('admin.component.buttons.delete_actions', [
                                                'url' => route('admin.posts.destroy',$list->id),
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

@include('admin.component.modals.filter', [
    'fields' => [
        [
            'name'  => 'user_id',
            'label' => 'بحث بالمستخدم',
            'type'  => 'select',
            'data'  => App\Models\User::select("id","username as name")->whereHas("roles",function($q) {
                return $q->where("name",\App\Models\User::TYPE_CUSTOMER);
            })->get()->toArray()
        ],
    ],
    'url'    => route('admin.posts.index')
])

@include('admin.component.modals.delete')

@endsection
