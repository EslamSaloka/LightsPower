@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
<div class="row">

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body" style=" position: relative; ">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="font-size-15">@lang('تفاصيل القصة') :</h5>
                    </div>
                </div>
                <p class="text-muted" style="font-size:16px;">
                    {!! $story->display_description !!}
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                @lang('المستخدم')
                            </td>
                            <td>
                                {{ $story->user->username ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('المدار')
                            </td>
                            <td>
                                {{ $story->specialty->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('المشاهدات')
                            </td>
                            <td>
                                {{ $story->views()->count() ?? '0' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('الإعجابات')
                            </td>
                            <td>
                                {{ $story->likes()->count() ?? '0' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('الفيديو')
                            </td>
                            <td>
                                <video width="320" height="240" controls>
                                    <source src="{{ url($story->video) }}" type="video/mp4">
                                </video>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Created At')
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($story->created_at)->diffForHumans() ?? '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
