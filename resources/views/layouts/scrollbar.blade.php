<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title">
                <span data-key="t-menu">الرئيسية</span>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span data-key="t-layouts">لوحة التحكم</span>
                </a>
            </li>

            @canany(['عرض الادوار', 'انشاء الادوار', 'عرض الصلاحيات','انشاء الصلاحيات'])
            <li class="menu-title">
                <span data-key="t-menu">الأدوار والصلاحيات</span>
            </li>
            @endcanany

            @canany(['عرض الادوار', 'انشاء الادوار'])
            <li class="nav-item">
                <a class="nav-link menu-link" href="#role" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="sidebarLayouts">
                    <i class="bx bxs-user-check"></i>
                    <span data-key="t-layouts">الأدوار</span>
                </a>
                <div class="collapse menu-dropdown" id="role">
                    <ul class="nav nav-sm flex-column">
                        @can('عرض الادوار')
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        @endcan
                        @can('انشاء الادوار')
                        <li class="nav-item">
                            <a href="{{route('roles.create')}}" target="_self" class="nav-link"
                                data-key="t-detached">إنشاء</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany


            @canany(['عرض الصلاحيات', 'انشاء الصلاحيات'])
            <li class="nav-item">
                <a class="nav-link menu-link" href="#permission" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-lock-unlock-fill"></i>
                    <span data-key="t-layouts">الصلاحيات</span>
                </a>
                <div class="collapse menu-dropdown" id="permission">
                    <ul class="nav nav-sm flex-column">
                        @can('عرض الصلاحيات')
                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        @endcan
                        @can('انشاء الصلاحيات')
                        <li class="nav-item">
                            <a href="{{route('permissions.create')}}" target="_self" class="nav-link"
                                data-key="t-detached">إنشاء</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany

            @canany(['عرض ادمن', 'انشاء ادمن', 'عرض المستخدمين'])
            <li class="menu-title">
                <span data-key="t-menu">الموارد البشرية</span>
            </li>
            @endcanany

            @canany(['عرض ادمن', 'انشاء ادمن'])
            <li class="nav-item">
                <a class="nav-link menu-link" href="#admins" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-vip-crown-fill"></i>
                    <span data-key="t-layouts">المسؤولين</span>
                </a>
                <div class="collapse menu-dropdown" id="admins">
                    <ul class="nav nav-sm flex-column">
                        @can('عرض ادمن')
                        <li class="nav-item">
                            <a href="{{route('admins.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        @endcan
                        @can('انشاء ادمن')
                        <li class="nav-item">
                            <a href="{{route('admins.create')}}" target="_self" class="nav-link"
                                data-key="t-detached">إنشاء</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany

            @canany(['عرض المستخدمين'])
            <li class="nav-item">
                <a class="nav-link menu-link" href="#users" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-user-fill"></i>
                    <span data-key="t-layouts">المستخدمين</span>
                </a>
                <div class="collapse menu-dropdown" id="users">
                    <ul class="nav nav-sm flex-column">
                        @can('عرض المستخدمين')
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        @endcan
                        {{-- <li class="nav-item">
                            <a href="{{route('users.create')}}" target="_self" class="nav-link"
                        data-key="t-detached">إنشاء</a>
            </li> --}}
        </ul>
    </div>
    </li>
    @endcanany

    <li class="menu-title"><span data-key="t-menu">التطبيق</span></li>
    @canany(['عرض التصنيفات', 'انشاء التصنيفات'])
    <li class="nav-item">
        <a class="nav-link menu-link" href="#Categories" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarLayouts">
            <i class="ri-apps-line"></i>
            <span data-key="t-layouts">تصنيفات</span>
        </a>
        <div class="collapse menu-dropdown" id="Categories">
            <ul class="nav nav-sm flex-column">
                @can('عرض التصنيفات')
                <li class="nav-item">
                    <a href="{{route('categories.index')}}" target="_self" class="nav-link"
                        data-key="t-horizontal">الرئيسية</a>
                </li>
                @endcan
                @can('انشاء التصنيفات')
                <li class="nav-item">
                    <a href="{{route('categories.create')}}" target="_self" class="nav-link"
                        data-key="t-detached">إنشاء</a>
                </li>
                @endcan
            </ul>
        </div>
    </li>
    @endcanany

    @canany(['عرض المنتجات'])
    <li class="nav-item">
        <a class="nav-link menu-link" href="#Tasks" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarLayouts">
            <i class="ri-shopping-cart-fill"></i>
            <span data-key="t-layouts">المنتجات</span>
        </a>
        <div class="collapse menu-dropdown" id="Tasks">
            <ul class="nav nav-sm flex-column">
                @can('عرض المنتجات')
                <li class="nav-item">
                    <a href="{{route('dproducts.index')}}" target="_self" class="nav-link"
                        data-key="t-horizontal">الرئيسية</a>
                </li>
                @endcan
                {{-- <li class="nav-item">
                            <a href="TasksCreate.html" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li> --}}
            </ul>
        </div>
    </li>
    @endcanany

    @canany(['عرض العروض'])
    <li class="nav-item">
        <a class="nav-link menu-link" href="#Offers" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarLayouts">
            <i class="ri-price-tag-line"></i>
            <span data-key="t-layouts">العروض</span>
        </a>
        <div class="collapse menu-dropdown" id="Offers">
            <ul class="nav nav-sm flex-column">
                @can('عرض العروض')
                <li class="nav-item">
                    <a href="{{route('doffers.index')}}" target="_self" class="nav-link"
                        data-key="t-horizontal">الرئيسية</a>
                </li>
                @endcan
                {{-- <li class="nav-item">
                            <a href="OffersCreate.html" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li> --}}
            </ul>
        </div>
    </li>
    @endcanany

    @canany(['عرض المحادثات'])
    <li class="nav-item">
        <a class="nav-link menu-link" href="#Chat" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarLayouts">
            <i class="ri-chat-1-line"></i>
            <span data-key="t-layouts">المحادثات</span>
        </a>
        <div class="collapse menu-dropdown" id="Chat">
            <ul class="nav nav-sm flex-column">
                @can('عرض المحادثات')
                <li class="nav-item">
                    <a href="{{route('chat.index')}}" target="_self" class="nav-link"
                        data-key="t-horizontal">الرئيسية</a>
                </li>
                @endcan
            </ul>
        </div>
    </li>
    @endcanany

    @can('عرض الاشعارات')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#notifications" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarLayouts">
            <i class="ri-notification-3-line"></i>
            <span data-key="t-layouts">الاشعارات</span>
        </a>
        <div class="collapse menu-dropdown" id="notifications">
            <ul class="nav nav-sm flex-column">
                @can('عرض الاشعارات')
                <li class="nav-item">
                    <a href="notifications.html" target="_self" class="nav-link" data-key="t-horizontal">الرئيسية</a>
                </li>
                @endcan
                {{-- <li class="nav-item">
                    <a href="notificationsCreate.html" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                </li> --}}
            </ul>
        </div>
    </li>
    @endcan

    @can('عرض طلبات التواصل')
    <li class="nav-item">
        <a class="nav-link" href="contacts.html" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
            <i class="ri-mail-line"></i>
            <span data-key="t-layouts">طلبات التواصل</span>
        </a>
    </li>
    @endcan
    </ul>

</div>
<!-- Sidebar -->
</div>