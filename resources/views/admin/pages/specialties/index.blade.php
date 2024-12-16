@extends('admin.layouts.master')
@section('title', $breadcrumb['title'])
@section('PageContent')

@section('buttons')
    @canAny('specialties.create')
        @include('admin.component.buttons.btn_href', [
            'title' => __('إنشاء مدار جديد'),
            'color_class' => 'primary',
            'url' => route('admin.specialties.create'),
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
                                <th class="wd-lg-8p"><span>@lang('إسم المدار')</span></th>
                                <th class="wd-lg-20p">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        @canAny('specialties.edit')
                                        <a href="{{ route('admin.specialties.edit', [$list->id, 'page' => request()->query('page')]) }}">
                                            {{ $list->name ?? '' }}
                                        </a>
                                        @else
                                            {{ $list->name ?? '' }}
                                        @endcanAny
                                    </td>
                                    <td>
                                        @canAny('specialties.edit')
                                            <a href="{{ route('admin.specialties.edit', [$list->id, 'page' => request()->query('page')]) }}" class="btn btn-sm btn-info">
                                                <i class="fe fe-edit-2"></i>
                                            </a>
                                        @endcanAny
                                        @canAny('specialties.destroy')
                                            @if($list->id != 1)
                                                @include('admin.component.buttons.delete_actions', [
                                                    'url' => route('admin.specialties.destroy',$list->id),
                                                ])
                                            @endif
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
                    'name' => __('المجالات')
                ])
            @endif
        </div>
    </div>
</div>
@include('admin.component.modals.delete')
@endsection