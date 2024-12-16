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
                                <th class="wd-lg-8p"><span>@lang('أخر رساله')</span></th>
                                <th class="wd-lg-20p">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        {{ $list->user->username ?? '' }}
                                    </td>
                                    <td>
                                        @php
                                            $item = $list->messages()->orderBy("id","desc")->first();
                                        @endphp
                                        @if($item)
                                            @if($item->type == "text")
                                                {{ $item->message }}
                                            @elseif($item->type == "product")
                                                {{ $item->product->title ?? '' }}
                                            @else
                                                {{ $item->store->storeRequest->store_name ?? '' }}
                                            @endif
                                        @else
                                            -------
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.chats.show',$list->id) }}" class="btn btn-sm btn-info">
                                            <i class="fe fe-eye"></i>
                                        </a>
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
                'name' => __('محادثات')
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
            'data'  => $users
        ],
    ],
    'url' => route('admin.chats.index')
])

@endsection