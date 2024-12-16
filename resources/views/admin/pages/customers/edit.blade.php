@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            @if(isset($user))
                <form action="{{ route('admin.customers.update', [$user->id, 'page' => request()->query('page')]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('admin.customers.store') }}" method="post" enctype="multipart/form-data">
            @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'User Name',
                                'name' => 'username',
                                'type' => 'text',
                                'required' => true,
                                'value' => old('username') ??(isset($user) ? $user->username : null)
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'Email',
                                'name' => 'email',
                                'placeholder' => 'Email',
                                'type' => 'email',
                                'required' => true,
                                'value' => old('email') ??(isset($user) ? $user->email : null)
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'Phone',
                                'name' => 'phone',
                                'placeholder' => 'Enter Phone',
                                'type' => 'text',
                                'required' => true,
                                'value' => old('phone') ??(isset($user) ? $user->phone : null)
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'المسمي الوظيفي',
                                'name' => 'job_title',
                                'placeholder' => 'برجاء إدخال المسمي الوظيفي',
                                'type' => 'text',
                                'value' => old('job_title') ??(isset($user) ? $user->job_title : null)
                            ])
                        </div>
                        <div class="col-md-12">
                            @include('admin.component.form_fields.textarea', [
                                'label' => 'نبذه مختصره',
                                'name' => 'bio',
                                'height' => '100',
                                'placeholder' => 'برجاءبرجاء إدخال نبذه مختصره',
                                'value' => old('bio') ??(isset($user) ? $user->bio : null)
                            ])
                        </div>
                        <div class="col-md-12">
                            @include('admin.component.form_fields.image', [
                                'label' => 'Image',
                                'name' => 'avatar',                                
                                'value' => old('img_base64') ?? (isset($user) && $user->avatar ? asset($user->avatar) : null)
                            ])
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="suspend">@lang('Suspend') <span class="tx-danger">*</span></label>
                                <select name="suspend" id="suspend" class="form-control select2 @error('suspend') is-invalid @enderror">    
                                    <option @if(isset($user)) @if($user->suspend == 1) selected @endif @endif value="1">@lang('Not Suspended')</option>
                                    <option @if(isset($user)) @if($user->suspend == 0) selected @endif @endif value="0">@lang('Suspended')</option>
                                </select>
                                @error('suspend')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-1">
                    @csrf
                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    <a href="{{ route('admin.customers.index')}}" class="btn btn-danger">@lang('Cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    @if (isset($user))
        {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Customers\UpdateRequest') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Customers\CreateRequest') !!}
    @endif
@endpush