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
            <li class="menu-title">
                <span data-key="t-menu">الأدوار والصلاحيات</span>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#role" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="sidebarLayouts">
                    <i class="bx bxs-user-check"></i>
                    <span data-key="t-layouts">الأدوار</span>
                </a>
                <div class="collapse menu-dropdown" id="role">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="role.html" target="_self" class="nav-link" data-key="t-horizontal">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="role.create" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#permission" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-lock-unlock-fill"></i>
                    <span data-key="t-layouts">الصلاحيات</span>
                </a>
                <div class="collapse menu-dropdown" id="permission">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="permission.html" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="permission.create" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#users" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-user-fill"></i>
                    <span data-key="t-layouts">المستخدمين</span>
                </a>
                <div class="collapse menu-dropdown" id="users">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('users.create')}}" target="_self" class="nav-link"
                                data-key="t-detached">إنشاء</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-title"><span data-key="t-menu">التطبيق</span></li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#Categories" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-apps-line"></i>
                    <span data-key="t-layouts">تصنيفات</span>
                </a>
                <div class="collapse menu-dropdown" id="Categories">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{route('categories.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('categories.create')}}" target="_self" class="nav-link"
                                data-key="t-detached">إنشاء</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#Tasks" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-task-line"></i>
                    <span data-key="t-layouts">المنتجات</span>
                </a>
                <div class="collapse menu-dropdown" id="Tasks">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{route('dproducts.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="TasksCreate.html" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li> --}}
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#Offers" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-price-tag-line"></i>
                    <span data-key="t-layouts">العروض</span>
                </a>
                <div class="collapse menu-dropdown" id="Offers">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{route('doffers.index')}}" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="OffersCreate.html" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li> --}}
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#Ratings" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-chat-1-line"></i>
                    <span data-key="t-layouts">المحادثات</span>
                </a>
                <div class="collapse menu-dropdown" id="Ratings">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="Ratings.html" target="_self" class="nav-link" data-key="t-horizontal">الرئيسية</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#Questions" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-question-line"></i>
                    <span data-key="t-layouts">الأسئلة</span>
                </a>
                <div class="collapse menu-dropdown" id="Questions">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="Questions.html" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-title">
                <i class="ri-more-fill"></i>
                <span data-key="t-pages">الصفحات</span>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#FAQs" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="sidebarLayouts">
                    <i class="ri-questionnaire-fill"></i>
                    <span data-key="t-layouts">FAQs</span>
                </a>
                <div class="collapse menu-dropdown" id="FAQs">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="FAQs.html" target="_self" class="nav-link" data-key="t-horizontal">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="FAQsCreate.html" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#Helps" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-question-line"></i>
                    <span data-key="t-layouts">قائمة المساعدة</span>
                </a>
                <div class="collapse menu-dropdown" id="Helps">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="Helps.html" target="_self" class="nav-link" data-key="t-horizontal">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="HelpsCreate.html" target="_self" class="nav-link" data-key="t-detached">إنشاء</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#notifications" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-notification-3-line"></i>
                    <span data-key="t-layouts">الاشعارات</span>
                </a>
                <div class="collapse menu-dropdown" id="notifications">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="notifications.html" target="_self" class="nav-link"
                                data-key="t-horizontal">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="notificationsCreate.html" target="_self" class="nav-link"
                                data-key="t-detached">إنشاء</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="contacts.html" role="button" aria-expanded="false"
                    aria-controls="sidebarLayouts">
                    <i class="ri-mail-line"></i>
                    <span data-key="t-layouts">طلبات التواصل</span>
                </a>
            </li>
        </ul>

    </div>
    <!-- Sidebar -->
</div>