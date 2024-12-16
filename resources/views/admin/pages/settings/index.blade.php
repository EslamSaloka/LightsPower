@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@push('scripts')
    <!-- INTERNAL Summernote Editor js -->
    <script src="{{ asset('assets/plugins/summernote-editor/summernote1.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.js') }}"></script>
@endpush
@push('css')
    <!-- Internal Summernote css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote-editor/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote-editor/summernote1.css') }}">
@endpush

<div class="checkout-tabs">
    @php
        $activeTab = request('group_by') ?? 'application';
    @endphp
    <div class="row">
        <div class="col-lg-4 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="main-content-left main-content-left-mail">
                        <div class="main-mail-menu">
                            <nav class="nav main-nav-column mg-b-20">
                                @foreach ($lists as $key=>$value)
                                    <a class="nav-link thumb mb-2 {{ ($activeTab == $key)? 'active': '' }}" id="v-pills-{{$key}}-tab" 
                                        data-bs-toggle="pill" 
                                        href="#v-pills-{{$key}}" 
                                        role="tab" 
                                        aria-controls="v-pills-{{$key}}" 
                                        aria-selected="true">
                                        <i class="fe fe-{{$value['icon']}}"></i>{{ __($value['title']) }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-9">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach ($lists as $key => $value)
                            <div class="tab-pane fade {{ ($activeTab == $key)? 'show active': '' }}" id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab">
                                <div>
                                    @isset($value['db'])
                                        @includeIf('admin.pages.settings.inc.db',['form' => $value['db']])
                                    @elseif( isset($value['caching']))
                                        @includeIf('admin.pages.settings.inc.caching',['form' => $value['caching']])
                                    @else
                                    <form action="{{ route('admin.settings.update',$key) }}" method="post" enctype="multipart/form-data">
                                        @isset($value['form']['group'])
                                            @includeIf('admin.pages.settings.inc.more',['data'=>$value['form']['group'],'group_by'=>$key])
                                        @else
                                            @isset($value['form']['lang'])
                                                @includeIf('admin.pages.settings.inc.lang', [
                                                    'data' => $value['form']['lang']['inputs'],
                                                    'model' => isset($val) ? $val : null,
                                                    'group_by' => $key
                                                ])
                                            @endisset
                                            @includeIf('admin.pages.settings.inc.inputs',['form' => $value['form']])
                                        @endisset
                                        <div class="card-footer mt-3">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                                            <a href="{{ route('admin.home.index')}}" class="btn btn-danger">@lang('Cancel')</a>
                                        </div>
                                    </form>
                                    @endisset
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $('.summernote').summernote({
            tabsize: 3,
            height: 300,
        });
    </script>
@endpush