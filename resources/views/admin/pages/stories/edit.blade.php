@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')

<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <form action="{{ route('admin.stories.store') }}" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.component.form_fields.textarea', [
                                'label' => 'محتوي القصه',
                                'name' => 'description',
                                'required' => true,
                                'value' => old('description')
                            ])
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="test">المدار</label>
                                <input type="text" readOnly value="{{ \App\Models\Specialty::find(1)->name ?? '' }}"  class="form-control"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @include('admin.component.form_fields.image', [
                                'label' => 'الفيديو',
                                'name' => 'image',
                                'value' => null
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-1">
                    @csrf
                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    <a href="{{ route('admin.stories.index')}}" class="btn btn-danger">@lang('Cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
