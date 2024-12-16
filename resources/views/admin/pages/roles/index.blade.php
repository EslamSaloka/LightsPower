@extends('admin.layouts.master')
@section('title') {{ $breadcrumb['title'] }} @endsection
@section('PageContent')

@section('buttons')
    @canAny('roles.create')
        @include('admin.component.buttons.btn_href', [
            'title' => __('إنشاء صلاحية جديده'),
            'color_class' => 'primary',
            'url' => route('admin.roles.create'),
            'fe_icon' => 'plus'
        ])
    @endcanAny
@endsection

<div class="row row-sm">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card custom-card">
            @if ($lists->count() > 0)
            <div class="card-body">
                <div class="table-responsive border userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-20p">@lang('Name')</th>
                                <th class="wd-lg-20p">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        @canAny('roles.edit')
                                        <a href="{{ route('admin.roles.edit', $list->id) }}">
                                            {{ $list->name ? __($list->name) : '' }}
                                        </a>
                                        @else
                                            {{ $list->name ? __($list->name) : '' }}
                                        @endcanAny
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.roles.edit',$list->id) }}" class="btn btn-sm btn-info">
                                            <i class="fe fe-edit-2"></i>
                                        </a>
                                        @if(!in_array($list->id,[1,2,3]))
                                            @include('admin.component.buttons.delete_actions', [
                                                'url' => route('admin.roles.destroy',$list->id),
                                            ])
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
                @include('admin.component.inc.nodata', [
                    'name' => __('Roles')
                ])
            @endif
        </div>
    </div>
</div>
@include('admin.component.modals.delete')
@endsection