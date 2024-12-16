<div class="row">
    <div class="col-lg-12">
        <div class="row">
            @foreach ($statistic as $item)
                <div class="col-lg-4 col-md-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card-item">
                                <div class="card-item-icon card-icon">
                                    <i class="{{$item['icon']}} sidemenu-icon menu-icon "></i>
                                </div>
                                <div class="card-item-title mb-2">
                                    <label class="main-content-label tx-13 font-weight-bold mb-1">{{$item['title']}}</label>
                                </div>
                                <div class="card-item-body">
                                    <div class="card-item-stat">
                                        <h4 class="font-weight-bold">{{$item['count']}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
