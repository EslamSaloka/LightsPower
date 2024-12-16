@extends('admin.layouts.master')
@section('title')
    @lang('الرئيسية')
@endsection
@section('PageContent')

@section('buttons')
    <h2 class="main-content-title tx-24 mg-b-5">@lang('مرحبا')
        {{auth()->user()->username}}
    </h2>
@endsection

@include('admin.pages.home.more')
@endsection
