@php
    $list = \App\Models\Product::find($id);
@endphp
@if (is_null($list))
    <div class="alert alert-danger" role="alert">
        تم حذف هذا المنتج
    </div>
    <?php 
        return;
    ?>
@endif

<div class="row row-sm">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive border userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="wd-lg-20p"><span>صوره المنتج</span></th>
                                @if (!in_array(\App\Models\User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray()))
                                    <th class="wd-lg-8p"><span>@lang('إسم التاجر')</span></th>
                                @endif
                                <th class="wd-lg-8p"><span>@lang('إسم المنتج')</span></th>
                                <th class="wd-lg-8p"><span>@lang('السعر')</span></th>
                                <th class="wd-lg-20p"><span>@lang('التقييم')</span></th>
                                <th class="wd-lg-20p"><span>@lang('Created At')</span></th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>
                                        <img alt="{{ $list->title ?? '' }}" class="rounded-circle avatar-md me-2" src="{{ $list->displayMainImage }}">
                                    </td>
                                    @if (!in_array(\App\Models\User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray()))
                                        <td>
                                            {{ $list->user->username ?? '' }}
                                        </td>
                                    @endif
                                    <td>
                                        @canAny('products.edit')
                                        <a href="{{ route('admin.products.edit', [$list->id, 'page' => request()->query('page')]) }}">
                                            {{ $list->title ?? '' }}
                                        </a>
                                        @else
                                            {{ $list->title ?? '' }}
                                        @endcanAny
                                    </td>
                                    <td>
                                        {{ $list->price }} ر.س
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.rates.index',$list->id) }}">
                                            ( {{ $list->rates ?? 0 }} ) تقييم
                                        </a>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() ?? '' }}
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>