@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

@section('buttons')
    @canAny('stories.create')
        @include('admin.component.buttons.btn_href', [
            'title' => __('إضافة قصه جديدة'),
            'color_class' => 'primary',
            'url' => route('admin.stories.create'),
            'fe_icon' => 'plus'
        ])
    @endcanAny
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
                                <th class="wd-lg-8p"><span>@lang('Name')</span></th>
                                <th class="wd-lg-8p"><span>@lang('المدار')</span></th>
                                <th class="wd-lg-8p"><span>@lang('عدد المشاهدات')</span></th>
                                <th class="wd-lg-8p"><span>@lang('عدد الإعجابات')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Created At')</span></th>
                                <th class="wd-lg-20p">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        @if(!is_null($list->user))
                                            @if (in_array(\App\Models\User::TYPE_CUSTOMER,$list->user->roles()->pluck("name")->toArray()))
                                                @canAny('customers.edit')
                                                    <a href="{{ route('admin.customers.edit', [$list->id, 'page' => request()->query('page')]) }}">
                                                        {{ $list->user->username ?? '' }}
                                                    </a>
                                                @else
                                                    {{ $list->user->username ?? '' }}
                                                @endcanAny
                                            @else
                                                {{ $list->user->username ?? '' }} - ( إداره )
                                            @endif
                                        @else
                                        @endif

                                    </td>
                                    <td>
                                        {{ $list->specialty->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $list->views()->count() }}
                                    </td>
                                    <td>
                                        {{ $list->likes()->count() }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() ?? '' }}
                                    </td>
                                    <td>
                                        @canAny('stories.show')
                                            <a href="{{ route('admin.stories.show',$list->id) }}" class="btn btn-sm btn-info">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                        @endcanAny
                                        @canAny('stories.destroy')
                                            @include('admin.component.buttons.delete_actions', [
                                                'url' => route('admin.stories.destroy',$list->id),
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
                'name' => __('القصص')
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
    'url'    => route('admin.stories.index')
])
@include('admin.component.modals.delete')
@endsection
