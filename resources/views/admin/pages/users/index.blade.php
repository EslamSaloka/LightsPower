@extends('admin.layouts.master')
@section('title', $breadcrumb['title'])
@section('PageContent')

@section('buttons')
    @canAny('users.create')
        @include('admin.component.buttons.btn_href', [
            'title' => __('إضافة موظف جديد'),
            'color_class' => 'primary',
            'url' => route('admin.users.create'),
            'fe_icon' => 'plus'
        ])
    @endcanAny
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
                                <a href="{{ route('admin.users.index', ['role_id' => $role->id, 'suspend' => 0]) }}">
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
                                                        <h4 class="font-weight-bold text-dark">
                                                            @php
                                                                $c = $role->users()->where("id","!=",1)->where('suspend', 0)->count();
                                                            @endphp
                                                            {{ $c }}
                                                        </h4>
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
                                <a href="{{ route('admin.users.index', ['role_id' => $role->id, 'suspend' => 1]) }}">
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
                                                        <h4 class="font-weight-bold text-dark">
                                                            @php
                                                                $c = $role->users()->where("id","!=",1)->where('suspend', 1)->count();
                                                            @endphp
                                                            {{ $c }}
                                                        </h4>
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
                                <th class="wd-lg-8p"><span>@lang('إسم المستخدم')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Email')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Phone')</span></th>
                                <th class="wd-lg-20p"><span>@lang('الصلاحية')</span></th>
                                <th class="wd-lg-20p"><span>@lang('الحالة')</span></th>
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
                                        @canAny('users.edit')
                                        <a href="{{ route('admin.users.edit', [$list->id, 'page' => request()->query('page')]) }}">
                                            {{ $list->username ?? '' }}
                                        </a>
                                        @else
                                            {{ $list->username ?? '' }}
                                        @endcanAny
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $list->email ?? '' }}">
                                            {{ $list->email ?? '' }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $list->phone ?? '' }}
                                    </td>
                                    <td>
                                        {{ $list->roles->first() ? __($list->roles->first()->name) : "" }}
                                    </td>
                                    <td>
                                        @if ($list->suspend == 1)
                                            غير مفعل
                                        @else
                                            مفعل
                                        @endif
                                    </td>
                                    <td>
                                        @canAny('users.edit')
                                            <a href="{{ route('admin.users.edit', [$list->id, 'page' => request()->query('page')]) }}" class="btn btn-sm btn-info">
                                                <i class="fe fe-edit-2"></i>
                                            </a>
                                        @endcanAny
                                        @canAny('users.destroy')
                                            @include('admin.component.buttons.delete_actions', [
                                                'url' => route('admin.users.destroy',$list->id),
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
                    'name' => __('موظفين')
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
            'name' => 'role_id',
            'label' => 'Search by Role',
            'type' => 'select',
            'data' => $roles,
            'translate' => true
        ],
        [
            'name' => 'suspend',
            'label' => 'Status',
            'type' => 'select',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'غير مفعل'
                ],
                [
                    'id' => 0,
                    'name' => 'مفعل'
                ]
            ],
            'translate' => true
        ]
    ],
    'url' => route('admin.users.index')
])
@include('admin.component.modals.delete')
@endsection