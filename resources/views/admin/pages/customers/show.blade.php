@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
<div class="row">

    <div class="col-lg-12">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                @lang('إسم المستخدم')
                            </td>
                            <td>
                                @canAny('customers.edit')
                                    <a href="{{ route('admin.customers.edit',$customer->id) }}">
                                        {{ $customer->username ?? '' }}
                                    </a>
                                @else
                                    {{ $customer->username ?? '' }}
                                @endcanAny
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Email')
                            </td>
                            <td>
                                @if (strpos("loopqaz",$customer->email))
                                    لا يوجد
                                @else
                                    <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Phone')
                            </td>
                            <td>
                                <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('المسمي الوظيفي')
                            </td>
                            <td>
                                {{ $customer->job_title }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('تاريخ إنشاء الحساب')
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($customer->created_at)->diffForHumans() ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('أخر ظهور')
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($customer->last_action_at)->diffForHumans() ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('عدد منشورات')
                            </td>
                            <td>
                                {{ $customer->posts()->count() }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('عدد القصص')
                            </td>
                            <td>
                                {{ $customer->story()->count() }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('عدد المتابعين') ( followers )
                            </td>
                            <td>
                                {{ $customer->myFollower()->count() }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('عدد المتابعون') ( following )
                            </td>
                            <td>
                                {{ $customer->iFollow()->count() }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('مدارات التخصص')
                            </td>
                            <td>
                                <ul>
                                    @foreach($customer->specialties as $item)
                                        <li>
                                            {{ $item->name }} 
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('مدارات الاهتمام')
                            </td>
                            <td>
                                <ul>
                                    @foreach($customer->interests as $item)
                                        <li>
                                            {{ $item->name }} 
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection