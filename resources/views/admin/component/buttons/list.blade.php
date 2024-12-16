<button class="btn ripple btn-primary" data-bs-toggle="dropdown">
    <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i>
</button>
<div class="dropdown-menu">
    <a class="dropdown-item">
        <form action="{{ route($route, [request()->getQueryString()]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-block">
                <i class="mdi mdi-file-excel"></i>
                @lang('Export Excel')
            </button>
        </form>
    </a>
</div>