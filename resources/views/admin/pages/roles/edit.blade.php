@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

<div class="row row-sm">
    <div class="col-lg-12 col-md-12 col-md-12">
        <div class="card custom-card">
            @if(isset($role))
                <form action="{{ route('admin.roles.update', [$role->id, 'page' => request()->query('role')]) }}" method="post" enctype="multipart/form-data">
            @else
                <form action="{{ route('admin.roles.store') }}" method="post" enctype="multipart/form-data">
            @endif
            <div class="card-body">
                <div class="form-group">
                    <label for="name">@lang('Name')</label>
                    <input type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" 
                        @if(isset($role)) 
                            @if (in_array($role->id,[1,2,3]))
                                readonly
                            @endif
                            value="{{ $role->name }}" 
                        @else 
                            value="{{old('name')}}" 
                        @endif />
                    @error('name')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <hr>
                <div class="form-group">
                    <label for="roles"><h5>@lang('الصلاحيات'):</h5></label>
                    @error('permissions')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                    <br>
                    <div class="mb-3 row">
                        @foreach ((new \App\Support\UserPermissions)->getPermissionsByKey() as $key => $value)
                            @if (!in_array($key,\App\Models\User::adminDisplayPermissions()))
                                <div class="col-md-3">
                                    <label class="font-weight-bold mb-1">
                                        @php
                                            $key = ($key == "customers") ? "مستخدمي التطبيق" : $key;
                                        @endphp
                                        {{ __(ucwords($key)) }}
                                    </label>
                                    <ul class="p-0">
                                        @foreach ($value as $v)
                                            @if(!in_array($v,\App\Models\User::adminDisplayPermissionsActions()))
                                                <li class="list-unstyled">
                                                    <label class="ckbox mt-1" for="customCheckcolor{{$v}}">
                                                        <input 
                                                            type="checkbox" 
                                                            id="customCheckcolor{{$v}}" 
                                                            name="permissions[]" 
                                                            value="{{$v}}" 
                                                            @if (in_array(($v), old('permissions') ?? []) || (isset($permissions) && in_array(($v), $permissions) ) )
                                                                checked
                                                            @endif
                                                        >
                                                        <span>
                                                            @php
                                                                if($v == "stores.plans.index") {
                                                                    $index = "عرض إشتراكات المتجر";
                                                                } else {
                                                                    $index = explode('.', $v);
                                                                    $index = (count($index) > 2) ? $index[2] : $index[1] ;
                                                                    if($index == "show") {
                                                                        $index = "عرض التفاصيل";
                                                                    }
                                                                    
                                                                }
                                                            @endphp
                                                            {{ __(ucwords($index)) }}
                                                        </span>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer mb-1">
                @csrf
                @if(isset($role))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $role->id }}">
                @endif
                <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                <a href="{{ route('admin.roles.index')}}" class="btn btn-danger">@lang('Cancel')</a>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    @if (isset($role))
        {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Roles\UpdateRequest') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Roles\CreateRequest') !!}
    @endif
@endpush