@extends('layouts.parent')

@section('title','البروفايل')

@section('content')
<div class="container-fluid">
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            {{-- <img src="assets/images/profile-bg.jpg" alt="" class="profile-wid-img" /> --}}
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    @php
                    $admin = Auth::guard('admin')->user();
                    $imagePath = $admin->admin_img ?? null;
                    @endphp
                    @if (!empty($imagePath) && Storage::disk('public')->exists($imagePath))
                    <img src="{{ Storage::disk('public')->url($imagePath) }}" alt="user-img"
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
                    <h3 class="text-white mb-1">{{auth('admin')->user()->name}}</h3>
                    {{-- <p class="text-white-75">عميل عادي</p> --}}
                    {{-- <div class="hstack text-white-50 gap-1">
                        <div class="me-2">
                            <i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>المملكة العربية
                            السعودية-الرياض
                        </div>
                    </div> --}}
                </div>
            </div>
            <!--end col-->
            {{-- <div class="col-12 col-lg-auto order-last order-lg-0">
                <div class="row text text-white-50 text-center">
                    <div class="col-lg-6 col-4">
                        <div class="p-2">
                            <h4 class="text-white mb-1">24.3K</h4>
                            <p class="fs-14 mb-0">عدد المهام المقدمة</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4">
                        <div class="p-2">
                            <h4 class="text-white mb-1">1.3K</h4>
                            <p class="fs-14 mb-0">عدد العروض المقدمة</p>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                    <div class="flex-shrink-0">
                        <a href="{{route('auth.profile-edit')}}" class="btn btn-success"><i
                                class="ri-edit-box-line align-bottom"></i>تعديل البروفايل</a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-5">اكتمال الملف الشخصي</h5>
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%"
                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                <div class="label">30%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">حول الشخص</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="ps-0" scope="row">الاسم :</th>
                                                        <td class="text-muted">{{ auth('admin')->user()->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row">الايميل:</th>
                                                        <td class="text-muted">{{ auth('admin')->user()->email }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
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

@endpush

@push('scripts')

@endpush