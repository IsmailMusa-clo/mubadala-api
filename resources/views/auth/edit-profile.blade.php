@extends('layouts.parent')

@section('title','تعديل البروفايل')

@section('content')
<div class="container-fluid">
    <!-- Background and Profile Picture -->
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="assets/images/profile-bg.jpg" class="profile-wid-img" alt="" />
            {{-- <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file"
                            class="profile-foreground-img-file-input" />
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i>
                            تغيير صورة الغلاف
                        </label>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                            @php
                            $admin = auth('admin')->user();
                            $imagePath = $admin->admin_img ?? null;
                            @endphp

                            @if ($imagePath && Storage::disk('public')->exists($imagePath))
                            <img src="{{ Storage::disk('public')->url($imagePath) }}"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                alt="user-profile-image" />
                            @else
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                alt="user-profile-image" />
                            @endif

                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" onchange="updateAvatar()" type="file"
                                    class="profile-img-file-input" />
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <h5 class="fs-16 mb-1">{{ $admin->name }}</h5>
                        {{-- <p class="text-muted mb-0">{{ $admin->role ?? 'عميل عادي' }}</p> --}}
                    </div>
                </div>
            </div>

            <!-- Profile Completion -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-5">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">اكتمال الملف الشخصي</h5>
                        </div>
                    </div>
                    <div class="progress animated-progress custom-progress progress-label">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="label">30%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Details Section -->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> البيانات الشخصية
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i> تغيير كلمة المرور
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">الاسم</label>
                                            <input type="text" class="form-control" id="name" placeholder="ادخل الاسم"
                                                value="{{auth('admin')->user()->name}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">البريد الالكتروني</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="ادخل الايميل" value="{{auth('admin')->user()->email}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-primary" onclick="updateProfile()">
                                                تعديل
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form id="form-create" action="javascript:void(0);">
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="password" class="form-label">كلمة المررو
                                                القديمة*</label>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="ادخل كلمة المرور الحالية" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="new_password" class="form-label">كلمة المرور
                                                الجديدة*</label>
                                            <input type="password" class="form-control" id="new_password"
                                                placeholder="ادخل كلمة المرور الجديدة" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="new_password_confirmation" class="form-label">تأكيد كلمة
                                                المرور*</label>
                                            <input type="password" class="form-control" id="new_password_confirmation"
                                                placeholder="تاكيد كلمة المرور" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="button" onclick="updatePassword()" class="btn btn-success">
                                                تغيير كلمة المرور
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('styles')

@endpush

@push('scripts')
<script>
    function updateProfile(){
        axios.put(`/dashboard/auth/profile/update`,{
            'name': document.getElementById('name').value,
            'email': document.getElementById('email').value,
        })
        .then(function (response) {
            console.log(response.data);
            toastr.success(response.data.message)
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message)
    })
    }
</script>

<script>
    function updatePassword(){
        axios.put("/dashboard/auth/password/update", {
        password: document.getElementById('password').value,
        new_password: document.getElementById("new_password").value,
        new_password_confirmation: document.getElementById("new_password_confirmation").value,
        })
        .then(function (response) {
        console.log(response.data.message);
        document.getElementById('form-create').reset();
        toastr.success(response.data.message)
        })
        .catch(function (error) {
        console.log(error.response);
        toastr.error(error?.response.data.message)
        });
    }
</script>

<script>
    function updateAvatar() {
    let fileInput = document.getElementById('profile-img-file-input');
    let file = fileInput.files[0];
    if (!file) return;

    let formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('admin_img', file);

    axios.post(`/dashboard/auth/profile/update-avatar`, formData)
        .then(function (response) {
            console.log(response.data);
            toastr.success(response.data.message);

            // تحديث الصورة في الصفحة مباشرة (اختياري)
            document.querySelector('.user-profile-image').src = response.data.image_url;
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
}
</script>
@endpush