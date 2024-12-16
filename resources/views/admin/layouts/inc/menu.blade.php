<div class="sticky">
    <div class="main-menu main-sidebar main-sidebar-sticky side-menu">
        <div class="main-sidebar-header main-container-1 active">
            <div class="sidemenu-logo">
                <a class="main-logo" href="{{route('admin.home.index')}}">
                    <img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" height="45px;" class="header-brand-img desktop-logo" alt="logo">
                    <img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" height="45px;" class="header-brand-img icon-logo" alt="logo">
                    <img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" class="header-brand-img desktop-logo theme-logo" alt="logo">
                    <img src="{{ getSettings("logo",asset('/dashboard.svg')) }}" class="header-brand-img icon-logo theme-logo" alt="logo">
                </a>
            </div>
            <div class="main-sidebar-body main-body-1">
                <div class="slide-left disabled" id="slide-left"><i class="fe fe-chevron-left"></i></div>
                <ul class="menu-nav nav">
                    <li class="nav-item  @if( Str::contains(Route::currentRouteName(), 'home') ) active @endif">
                        <a class="nav-link" href="{{ route('admin.home.index') }}">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-home sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">@lang('Home')</span>
                        </a>
                    </li>
                    @canAny(['users.index', 'customers.index', 'roles.index', 'stores.index'])
                    @php
                        $open_users = false;
                        if( Request::is(['*users*', '*customers*', '*roles*', '*stores*']) ) {
                            $open_users = true;
                        }
                    @endphp
                    <li class="nav-item @if($open_users) show @endif">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-user sidemenu-icon menu-icon "></i>
                            <span class="sidemenu-label">@lang('المستخدمين')</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub @if($open_users) open @endif" @if($open_users) style="display: block;" @else style="display: none;" @endif>
                            @canAny(['users.index'])
                                <li class="nav-item @if( Request::is('*dashboard/users*') ) active @endif">
                                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                                        <span class="shape1"></span>
                                        <span class="shape2"></span>
                                        <i class="ti-user sidemenu-icon menu-icon "></i>
                                        <span class="sidemenu-label">@lang('إداره الموظفين')</span>
                                    </a>
                                </li>
                            @endcanAny
                            @canAny(['customers.index'])
                                <li class="nav-item @if( Request::is('*dashboard/customers*') ) active @endif">
                                    <a class="nav-link" href="{{ route("admin.customers.index") }}">
                                        <span class="shape1"></span>
                                        <span class="shape2"></span>
                                        <i class="ti-mobile sidemenu-icon menu-icon "></i>
                                        <span class="sidemenu-label">@lang("مستخدمي التطبيق")</span>
                                    </a>
                                </li>
                            @endcanAny
                            @canAny(['roles.index'])
                                <li class="nav-item @if( Request::is('*dashboard/roles*') ) active @endif">
                                    <a class="nav-link" href="{{ route('admin.roles.index') }}">
                                        <span class="shape1"></span>
                                        <span class="shape2"></span>
                                        <i class="ti-clipboard sidemenu-icon menu-icon "></i>
                                        <span class="sidemenu-label">@lang('الصلاحيات')</span>
                                    </a>
                                </li>
                            @endcanAny
                        </ul>
                    </li>
                    @endcanAny

                    @canAny(['contact-us.index'])
                        <li class="nav-item @if( Request::is('*dashboard/contact-us*') ) active @endif">
                            <a class="nav-link" href="{{ route('admin.contact-us.index') }}">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-rss sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('رسائل التواصل')</span>
                                @php
                                    $contactUsCount = \App\Models\Contact::where('seen',0)->count();
                                    @endphp
                                @if($contactUsCount != 0)
                                <span class="badge bg-primary side-badge">
                                    {{ ($contactUsCount > 1000) ? "1000 +" : $contactUsCount }}
                                </span>
                                @endif
                            </a>
                        </li>
                    @endcanAny

                    @php
                        $open_settings = false;
                        if( Request::is(['*settings*', '*pages*']) ) {
                            $open_settings = true;
                        }
                    @endphp
                    @canAny(['settings.index','pages.index'])
                        <li class="nav-item @if($open_settings) show @endif">
                            <a class="nav-link with-sub" href="javascript:void(0)">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-settings sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('الإعدادت')</span>
                                <i class="angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="nav-sub @if($open_settings) open @endif" @if($open_settings) style="display: block;" @else style="display: none;" @endif>
                                @canAny('settings.index')
                                    <li class="nav-item @if( Request::is('*dashboard/settings*') ) active @endif">
                                        <a class="nav-link" href="{{ route('admin.settings.index') }}">
                                            <span class="shape1"></span>
                                            <span class="shape2"></span>
                                            <i class="ti-settings sidemenu-icon menu-icon "></i>
                                            <span class="sidemenu-label">@lang('الإعدادات العامة')</span>
                                        </a>
                                    </li>
                                @endcanAny
                                @canAny('pages.index')
                                    <li class="nav-item @if( Request::is('*dashboard/pages*') ) active @endif">
                                        <a class="nav-link" href="{{ route('admin.pages.index') }}">
                                            <span class="shape1"></span>
                                            <span class="shape2"></span>
                                            <i class="ti-book sidemenu-icon menu-icon"></i>
                                            <span class="sidemenu-label">@lang('الصفحات')</span>
                                        </a>
                                    </li>
                                @endcanAny
                            </ul>
                        </li>
                    @endcanAny


                    @php
                        $open_address = false;
                        if( Request::is(['*address*', '*address/types*']) ) {
                            $open_address = true;
                        }
                    @endphp
                    @canAny(['address.index','address.types.index'])
                        <li class="nav-item @if($open_address) show @endif">
                            <a class="nav-link with-sub" href="javascript:void(0)">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-world sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('العناوين')</span>
                                <i class="angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="nav-sub @if($open_address) open @endif" @if($open_address) style="display: block;" @else style="display: none;" @endif>
                                @canAny('address.index')
                                    <li class="nav-item @if( Request::is('*dashboard/address*') ) @if(!Request::is('*dashboard/address/types*')) active @endif @endif">
                                        <a class="nav-link" href="{{ route('admin.address.index') }}">
                                            <span class="shape1"></span>
                                            <span class="shape2"></span>
                                            <i class="ti-world sidemenu-icon menu-icon "></i>
                                            <span class="sidemenu-label">@lang('العناوين')</span>
                                        </a>
                                    </li>
                                @endcanAny
                                @canAny('address.types.index')
                                    <li class="nav-item @if( Request::is('*dashboard/address/types*') ) active @endif">
                                        <a class="nav-link" href="{{ route('admin.address.types.index') }}">
                                            <span class="shape1"></span>
                                            <span class="shape2"></span>
                                            <i class="ti-world sidemenu-icon menu-icon "></i>
                                            <span class="sidemenu-label">@lang('انواع العناوين')</span>
                                        </a>
                                    </li>
                                @endcanAny
                            </ul>
                        </li>
                    @endcanAny

                    @canAny(['intros.index'])
                        <li class="nav-item @if( Request::is('*dashboard/intros*') ) active @endif">
                            <a class="nav-link" href="{{ route('admin.intros.index') }}">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-blackboard sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('الصفحات الإفتتاحية')</span>
                            </a>
                        </li>
                    @endcanAny

                    @canAny(['specialties.index'])
                        <li class="nav-item @if( Request::is('*dashboard/specialties*') ) active @endif">
                            <a class="nav-link" href="{{ route('admin.specialties.index') }}">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-archive sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('المدارات')</span>
                            </a>
                        </li>
                    @endcanAny

                    @canAny(['posts.index'])
                        <li class="nav-item @if( Request::is('*dashboard/posts*') ) active @endif">
                            <a class="nav-link" href="{{ route('admin.posts.index') }}">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-pencil-alt sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('المنشورات')</span>
                            </a>
                        </li>
                    @endcanAny

                    @canAny(['stories.index'])
                        <li class="nav-item @if( Request::is('*dashboard/stories*') ) active @endif">
                            <a class="nav-link" href="{{ route('admin.stories.index') }}">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-agenda sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('القصص')</span>
                            </a>
                        </li>
                    @endcanAny

                    @canAny(['notifications.index'])
                        <li class="nav-item @if( Request::is('*dashboard/notifications*') ) active @endif">
                            <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-announcement sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">@lang('الإشعارات')</span>
                            </a>
                        </li>
                    @endcanAny

                </ul>
                <div class="slide-right" id="slide-right"><i class="fe fe-chevron-right"></i></div>
            </div>
        </div>
    </div>
</div>
