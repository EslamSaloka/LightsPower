@php
    $list = \App\Models\User::find($id);
@endphp
@if (is_null($list))
    <div class="alert alert-danger" role="alert">
        تم حذف هذا المتجر
    </div>
    <?php
        return;
    ?>
@endif
@if (!in_array(\App\Models\User::TYPE_STORE,$list->roles()->pluck("name")->toArray()))
    <div class="alert alert-danger" role="alert">
        هذا المستخدم ليس بمتجر
    </div>
    <?php
        return;
    ?>
@endif

<div class="row row-sm">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card card-aside custom-card">
                <a href="#" class="card-aside-column  cover-image rounded-start-11">
                    <img src="{{ (new \App\Support\Image)->displayImageByModel($list->storeSettings,'cover','def_store.jpg') }}" style=" width: 100%; height: 100%; "/>
                </a>
                <div class="card-body">
                    <h5 class="main-content-label tx-dark tx-medium mg-b-10">
                        {{ $list->storeRequest->store_name ?? '' }}
                        @if($list->suspend == 0)
                            <i class="ti-check-box" style=" color: green; "></i>
                        @else
                            <i class="ti-close" style=" color: red; "></i>
                        @endif
                    </h5>
                    <div>
                        @canAny('products.index')
                            <a href="{{ route('admin.products.index') }}?store_id={{$list->id}}" class="btn btn-sm btn-info">
                                المنتجات
                            </a>
                        @endcanAny
                        @canAny('orders.index')
                            <a href="{{ route('admin.orders.index') }}?store_id={{$list->id}}" class="btn btn-sm btn-info">
                                الطلبات
                            </a>
                        @endcanAny
                        @canAny('coupons.index')
                            <a href="{{ route('admin.coupons.index') }}?user_id={{$list->id}}" class="btn btn-sm btn-info">
                                الكوبونات
                            </a>
                        @endcanAny
                        @canAny('stores.plans.index')
                            <a href="{{ route('admin.stores.plans',$list->id) }}" class="btn btn-sm btn-info">
                                الإشتراكات
                            </a>
                        @endcanAny
                        <br />
                        <br />
                        <a href="{{ route('admin.stores.rates.index',$list->id) }}">
                            <ul class="rating" style=" color: #ff9b21; ">
                                @if($list->rates ?? 0 == 0)
                                    <li class="far fa-star"></li>
                                    <li class="far fa-star"></li>
                                    <li class="far fa-star"></li>
                                    <li class="far fa-star"></li>
                                    <li class="far fa-star"></li>
                                @else
                                    @for($i = 0;$i == $list->rates ?? 0; $i++)
                                        <li class="fas fa-star"></li>
                                    @endfor
                                    @for($i = $list->rates ?? 0;$i >= 5; $i++)
                                        <li class="far fa-star"></li>
                                    @endfor
                                @endif
                            </ul>
                        </a>
                    </div>
                    <div class="d-flex align-items-center pt-3 mt-auto">
                        <div class="main-img-user avatar-sm me-3">
                            <img src="{{ (new \App\Support\Image)->displayImageByModel($list->storeSettings,'photo') }}" class="w-10 rounded-circle" alt="avatar-img">
                        </div>
                        <div>
                            <a href="" class="text-default">{{ $list->storeRequest->store_name ?? '' }}</a>
                            <small class="d-block text-muted">{{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() ?? '' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
