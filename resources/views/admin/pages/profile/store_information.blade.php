@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

<div class="row row-sm">
    <div class="col-lg-12 col-md-12 col-md-12">
        <div class="card custom-card">
            <form action="{{ route('admin.change_store_information.store') }}" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'إسم التاجر',
                                'name' => 'username',
                                'type' => 'text',
                                'readOnly' => true,
                                'value' => isset($storeRequest) ? $storeRequest->username ?? '' : null
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'إسم المتجر',
                                'name' => 'store_name',
                                'type' => 'text',
                                'value' => isset($storeRequest) ? $storeRequest->store_name ?? '' : null
                            ])
                        </div>
                        
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'الجوال',
                                'name' => 'phone',
                                'type' => 'text',
                                'value' => isset($storeRequest) ? $storeRequest->phone ?? '' : null
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('admin.component.form_fields.input', [
                                'label' => 'البريد الإلكتروني',
                                'name' => 'email',
                                'type' => 'text',
                                'value' => isset($storeRequest) ? $storeRequest->email ?? '' : null
                            ])
                        </div>

                        <hr>
                        
                        <div class="col-md-12">
                            @include('admin.component.form_fields.select', [
                                'label' => 'الأقسام',
                                'name' => 'categories[]',
                                'data' => \App\Models\Category::all(),
                                'keyV' => 'name',
                                'multiple' => true,
                                'value' => isset($storeCategories) ? $storeCategories->pluck("id")->toArray() : []
                            ])
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="vat"> قيمه الضريبة المضافة <span class="tx-danger">*</span></label>
                                <select name="vat" id="vat" class="form-control select2 @error('var') is-invalid @enderror">    
                                    <option @if(isset($storeSettings)) @if($storeSettings->vat == 1) selected @endif @endif value="1">@lang('تفعيل')</option>
                                    <option @if(isset($storeSettings)) @if($storeSettings->vat == 0) selected @endif @endif value="0">@lang('تعطيل')</option>
                                </select>
                                @error('vat')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            @include('admin.component.form_fields.textarea', [
                                'label' => 'وصف المتجر',
                                'name' => 'short_description',
                                'value' => isset($storeSettings) ? $storeSettings->short_description ?? '' : null
                            ])
                        </div>

                        <div class="col-md-12">
                            @include('admin.component.form_fields.textarea', [
                                'label' => 'الشروط والأحكام',
                                'name' => 'terms_information',
                                'value' => isset($storeSettings) ? $storeSettings->terms_information ?? '' : null
                            ])
                        </div>

                        <div class="col-md-12">
                            @include('admin.component.form_fields.textarea', [
                                'label' => 'سياسه الإسترجاع',
                                'name' => 'return_information',
                                'value' => isset($storeSettings) ? $storeSettings->return_information ?? '' : null
                            ])
                        </div>

                        <hr>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="photo">صوره شعار المتجر</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control" id="photo" name="photo">
                                    @error("photo")
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <span class="text-danger" id="error_images"></span>
                                </div>
                                <img src="{{ $storeSettings->display_photo ?? '' }}" style=" width: 75px; position: absolute; left: 100px; top: 12px; "/>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cover">صوره الخلفية</label>
                                <div class="col-md-10">
                                <input type="file" class="form-control" id="cover" name="cover">
                                @error("cover")
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <span class="text-danger" id="error_images"></span>
                                </div>
                                <img src="{{ $storeSettings->display_cover ?? '' }}" style=" width: 75px; position: absolute; left: 100px; top: 31px; "/>
                            </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Profile\UpdateStoreDataRequest') !!}
@endpush
