@extends('admin.layouts.master')
@section('title', $breadcrumb['title'])
@section('PageContent')

@section('buttons')
    @include('admin.component.buttons.filter')
@endsection

<div class="row row-sm">

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="panel panel-primary tabs-style-3">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="#tab11" class="active" data-bs-toggle="tab"> @lang('Suspended')</a></li>
                        <li><a href="#tab12" data-bs-toggle="tab" class="">@lang('Not Suspended')</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab11">
                        <div class="row">
                            @foreach ($roles as $role)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <a href="{{ route('admin.customers.index', ['role_id' => $role->id, 'suspend' => 0]) }}">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                    <i class="ti-user sidemenu-icon menu-icon"></i>
                                                </div>
                                                <div class="card-item-title mb-2">
                                                    <label class="main-content-label tx-13 font-weight-bold mb-1">@lang($role->name)</label>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="font-weight-bold text-dark">{{$role->users->whereNotNull('completed_at')->where('suspend', 0)->count()}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>  
                    </div>
                    <div class="tab-pane" id="tab12">
                        <div class="row">
                            @foreach ($roles as $role)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <a href="{{ route('admin.customers.index', ['role_id' => $role->id, 'suspend' => 1]) }}">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                    <i class="ti-user sidemenu-icon menu-icon"></i>
                                                </div>
                                                <div class="card-item-title mb-2">
                                                    <label class="main-content-label tx-13 font-weight-bold mb-1">@lang($role->name)</label>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="font-weight-bold text-dark">{{$role->users->whereNotNull('completed_at')->where('suspend', 1)->count()}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card custom-card">
            @if ($lists->count() > 0)
            <div class="card-body">
                <div class="table-responsive border userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-20p"><span>الصوره</span></th>
                                <th class="wd-lg-8p"><span>@lang('User Name')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Email')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Phone')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Created At')</span></th>
                                <th class="wd-lg-20p">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        <img alt="avatar" class="rounded-circle avatar-md me-2" src="{{ (new \App\Support\Image)->displayImageByModel($list,'avatar') }}">
                                    </td>
                                    <td>
                                        @canAny('customers.edit')
                                        <a href="{{ route('admin.customers.edit', [$list->id, 'page' => request()->query('page')]) }}">
                                            {{ $list->username ?? '' }}
                                        </a>
                                        @else
                                            {{ $list->username ?? '' }}
                                        @endcanAny
                                    </td>
                                    <td>
                                        @if (strpos("loopqaz",$list->email))
                                            لا يوجد
                                        @else
                                            <a href="mailto:{{ $list->email ?? '' }}">
                                                {{ $list->email ?? '' }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $list->phone ?? '' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() ?? '' }}
                                    </td>
                                    <td>
                                        @canAny('customers.edit')
                                            <a href="{{ route('admin.customers.edit', [$list->id, 'page' => request()->query('page')]) }}" class="btn btn-sm btn-info">
                                                <i class="fe fe-edit-2"></i>
                                            </a>
                                        @endcanAny
                                        @canAny('customers.show')
                                            <a href="{{ route('admin.customers.show', [$list->id, 'page' => request()->query('page')]) }}" class="btn btn-sm btn-info">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                        @endcanAny
                                        @canAny('customers.destroy')
                                            @include('admin.component.buttons.delete_actions', [
                                                'url' => route('admin.customers.destroy',$list->id),
                                            ])
                                        @endcanAny
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $lists->withQueryString()->withQueryString()->links('admin.layouts.inc.paginator') }}
            </div>
            @else
                @include('admin.component.inc.nodata', [
                    'name' => __('customers')
                ])
            @endif
        </div>
    </div>
</div>
@include('admin.component.modals.filter', [
    'fields' => [
        [
            'name' => 'name',
            'label' => 'Search by name or email or phone number',
            'type' => 'text'
        ],
        [
            'name' => 'suspend',
            'label' => 'Status',
            'type' => 'select',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Not Suspended'
                ],
                [
                    'id' => 0,
                    'name' => 'Suspended'
                ]
            ],
            'translate' => true
        ]
    ],
    'url' => route('admin.customers.index')
])
@include('admin.component.modals.delete')
@endsection