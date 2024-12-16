@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <form action="{{ route('admin.notifications.store') }}" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="users">@lang('مستخدمي التطبيق')</label>
                                <select
                                    id="users"
                                    name="users[]"
                                    class="form-control select2"
                                    multiple>
                                    <option value="0">@lang('إختر') الكل</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}" >
                                            {{ $item->username }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("users")
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            @include('admin.component.form_fields.textarea', [
                                'label' => 'محتوى الإشعار',
                                'name' => 'content',
                                'type' => 'text',
                                'value' => old('content')
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-1">
                    @csrf
                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    <a href="{{ route('admin.notifications.index')}}" class="btn btn-danger">@lang('Cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Dashboard\Notifications\CreateRequest') !!}
@endpush
