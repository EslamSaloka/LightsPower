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
                                <th class="wd-lg-8p"><span>@lang('إسم المستخدم')</span></th>
                                <th class="wd-lg-8p"><span>@lang('Phone')</span></th>
                                <th class="wd-lg-8p"><span>@lang('Email')</span></th>
                                <th class="wd-lg-8p"><span>@lang('Status')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Created At')</span></th>
                                <th class="wd-lg-20p">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        @if (is_null($list->user))
                                            تم حذف المستخدم
                                        @else
                                            <a href="{{ route('admin.customers.edit', $list->user->id) }}">
                                                {{ $list->user->username ?? '-----' }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (is_null($list->user))
                                            تم حذف المستخدم
                                        @else
                                            <a href="tel:{{ $list->user->phone ?? '-----' }}">{{ $list->user->phone ?? '-----' }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (is_null($list->user))
                                            تم حذف المستخدم
                                        @else
                                            <a href="mailto:{{ $list->user->email }}">{{ $list->user->email }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        {!! $list->showStatus() !!}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() ?? '' }}
                                    </td>
                                    <td>
                                        @canAny('contact-us.show')
                                            <a href="{{ route('admin.contact-us.show',$list->id) }}" class="btn btn-sm btn-info">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                        @endcanAny
                                        @canAny('contact-us.destroy')
                                        @include('admin.component.buttons.delete_actions', [
                                            'url' => route('admin.contact-us.destroy',$list->id),
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
                'name' => __('رسائل تواصل')
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
            'name' => 'seen',
            'label' => 'المشاهده',
            'type' => 'select',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'مشاهده'
                ],
                [
                    'id' => 0,
                    'name' => 'لم يتم المشاهده'
                ]
            ],
            'translate' => true
        ]
    ],
    'url' => route('admin.contact-us.index')
])
@include('admin.component.modals.delete')

@endsection