@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
<div class="row">

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body" style=" position: relative; ">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="font-size-15">@lang('تفاصيل الرساله') :</h5>
                    </div>
                </div>
                <p class="text-muted">
                    {!! $contact_u->message !!}
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
                                @lang('Name')
                            </td>
                            <td>
                                @if (is_null($contact_u->user))
                                    تم حذف المستخدم
                                @else
                                
                                    @canAny('customers.edit')
                                        <a href="{{ route('admin.customers.edit',$contact_u->user_id) }}">
                                            {{ $contact_u->user->username ?? '' }}
                                        </a>
                                    @else
                                        {{ $contact_u->user->username ?? '' }}
                                    @endcanAny
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Email')
                            </td>
                            <td>
                                @if (is_null($contact_u->user))
                                    تم حذف المستخدم
                                @else
                                    <a href="mailto:{{ $contact_u->user->email }}">{{ $contact_u->user->email }}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Phone')
                            </td>
                            <td>
                                @if (is_null($contact_u->user))
                                    تم حذف المستخدم
                                @else
                                    <a href="tel:{{ $contact_u->user->phone }}">{{ $contact_u->user->phone }}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Status')
                            </td>
                            <td>
                                {!! $contact_u->showStatus() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Created At')
                            </td>
                            <td>
                                {{ $contact_u->created_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection