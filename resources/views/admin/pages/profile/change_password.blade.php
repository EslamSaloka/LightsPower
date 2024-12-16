@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

<div class="row row-sm">
    <div class="col-lg-12 col-md-12 col-md-12">
        <div class="card custom-card">
            <form action="{{ route('admin.change_password.store') }}" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.component.form_fields.input', [
                                'label' => 'كلمة المرور الحالية',
                                'name' => 'current_password',
                                'type' => 'password',
                                'value' => ''
                            ])
                        </div>
                        <div class="col-md-12">
                            @include('admin.component.form_fields.input', [
                                'label' => 'كلمه المرور الجديدة',
                                'name' => 'password',
                                'type' => 'password',
                                'value' => ''
                            ])
                        </div>
                        <div class="col-md-12">
                            @include('admin.component.form_fields.input', [
                                'label' => 'تأكيد كلمة المرور',
                                'name' => 'password_confirmation',
                                'type' => 'password',
                                'value' => ''
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-1">
                    @csrf
                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    <a href="{{ route('admin.home.index')}}" class="btn btn-danger">@lang('Cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Profile\UpdatePasswordRequest') !!}
@endpush
