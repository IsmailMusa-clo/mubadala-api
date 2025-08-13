@extends('layouts.parent')

@section('title','المستخدم'." ".$user->name)

@section('content')
<div class="container-fluid">
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="assets/images/profile-bg.jpg" alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    @if (Storage::disk('public')->exists($user->user_img))
                    <img src="{{ Storage::disk('public')->url($user->user_img) }}" alt="user-img"
                        class="img-thumbnail rounded-circle" />
                    @else
                    <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-img"
                        class="img-thumbnail rounded-circle" />
                    @endif
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{$user->name}}</h3>
                    {{-- <p class="text-white-75">عميل عادي</p> --}}
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2">
                            <i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>
                            {{$user->city}}-{{$user->area}}
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-12 col-lg-auto order-last order-lg-0">
                <div class="row text text-white-50 text-center">
                    <div class="col-lg-6 col-4">
                        <div class="p-2">
                            <h4 class="text-white mb-1">{{$user->products()->count()}}</h4>
                            <p class="fs-14 mb-0">عدد المنتجات المقدمة</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4">
                        <div class="p-2">
                            <h4 class="text-white mb-1">{{$user->offers()->count()}}</h4>
                            <p class="fs-14 mb-0">عدد العروض المقدمة</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab"
                                aria-selected="true">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i>
                                <span class="d-none d-md-inline-block">بيانات عامة</span>
                            </a>
                        </li>
                    </ul>
                    @can('تعديل المستخدمين')
                    <div class="flex-shrink-0">
                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-success"><i
                                class="ri-edit-box-line align-bottom"></i>تعديل البروفايل</a>
                    </div>
                    @endcan
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-5">
                                            اكتمال الملف الشخصي
                                        </h5>
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%"
                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                <div class="label">30%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">حول الشخص</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="ps-0" scope="row">
                                                            الاسم :
                                                        </th>
                                                        <td class="text-muted">{{$user->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">رقم جوال :</th>
                                                        <td class="text-muted">{{$user->phone}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">الايميل:</th>
                                                        <td class="text-muted">
                                                            {{$user->email}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">
                                                            الموقع :
                                                        </th>
                                                        <td class="text-muted">
                                                            {{$user->city}}-{{$user->area}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">
                                                            تاريخ الميلاد :
                                                        </th>
                                                        <td class="text-muted">{{$user->birthday}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!--end col-->
                            <div class="col-xxl-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">معلومات</h5>
                                        <p>{{$user->bio}}</p>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">المنتجات</h5>
                                        <!-- Swiper -->
                                        <div class="project-swiper mt-n4">
                                            @if ($user->products()->count())
                                            <div class="d-flex justify-content-end gap-2 mb-2">
                                                <div class="slider-button-prev" tabindex="-1" role="button"
                                                    aria-label="Previous slide">
                                                    <div class="avatar-title fs-18 rounded px-1">
                                                        <i class="ri-arrow-left-s-line"></i>
                                                    </div>
                                                </div>
                                                <div class="slider-button-next" tabindex="0" role="button"
                                                    aria-label="Next slide">
                                                    <div class="avatar-title fs-18 rounded px-1">
                                                        <i class="ri-arrow-right-s-line"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="swiper mySwiper">
                                                <div class="swiper-wrapper">
                                                    @foreach ($user->products as $product)
                                                    <div class="swiper-slide"
                                                        style="width: 292.333px; margin-right: 25px">
                                                        <div
                                                            class="card profile-project-card shadow-none profile-project-success mb-0">
                                                            <div class="card-body p-4">
                                                                <div class="d-flex">
                                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                                        <h5 class="fs-14 text-truncate mb-1">
                                                                            <a href="#" class="text-dark">
                                                                                {{ $product->name ?? 'لا يوجد تصنيف للمهمة' }}
                                                                            </a>
                                                                        </h5>
                                                                        <p class="text-muted text-truncate mb-0">
                                                                            آخر تحديث :
                                                                            <span
                                                                                class="fw-semibold text-dark">{{ $product->created_at }}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="flex-shrink-0 ms-2">
                                                                        <div class="badge badge-soft-warning fs-10">
                                                                            @switch($product->status)
                                                                            @case('free') متاح @break
                                                                            @case('reserved') محجوز @break
                                                                            @case('exchanged') تم التبادل @break
                                                                            @default متاح
                                                                            @endswitch
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="d-flex mt-4">
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div>
                                                                                <h5 class="fs-12 text-muted mb-0">
                                                                                    المبلغ المدفوع :</h5>
                                                                            </div>
                                                                            {{ $task->budget }} $
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <p class="nothing-task">لا يوجد مهام</p>
                                @endif
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end tab-content-->
    </div>
</div>
<!--end col-->
</div>
<!--end row-->
</div>
@endsection


@push('styles')
<style>
    .nothing-task {
        margin-top: 30px
    }

</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 25,
            loop: true,
            navigation: {
                nextEl: ".project-swiper .slider-button-next",
                prevEl: ".project-swiper .slider-button-prev",
            },
            breakpoints: {
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
            }
        });
    });
</script>
@endpush