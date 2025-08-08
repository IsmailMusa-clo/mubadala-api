@extends('layouts.parent')

@section('title','تعديل'." ".$user->name)

@section('content')
<div class="container-fluid">
    <!-- Background and Profile Picture -->
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="" class="profile-wid-img" alt="" />
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file"
                            class="profile-foreground-img-file-input" />
                        {{-- <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                            <i class="ri-image-edit-line align-bottom me-1"></i>
                            تغيير صورة الغلاف
                        </label> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                            @if (Storage::disk('public')->exists($user->user_img))
                            <img src="{{Storage::disk('public')->url($user->user_img)}}"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                alt="user-profile-image" />
                            @else
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                alt="user-profile-image" />
                            @endif
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" onchange="updateUserImage('{{$user->id}}')"
                                    type="file" class="profile-img-file-input" />
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{$user->name}}</h5>
                        {{-- <p class="text-muted mb-0">عميل عادي</p> --}}
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
                                            <label for="first_name" class="form-label">الاسم الاول</label>
                                            <input type="text" class="form-control" id="first_name"
                                                placeholder="Enter your firstname" value="{{$user->first_name}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">الاسم الثاني</label>
                                            <input type="text" class="form-control" id="last_name"
                                                placeholder="Enter your lastname" value="{{$user->last_name}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">رقم الجوال</label>
                                            <input type="text" class="form-control" id="phone"
                                                placeholder="Enter your phone number" value="{{$user->phone}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">البريد الالكتروني</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Enter your email" value="{{$user->email}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="birthday" class="form-label">تاريخ الميلاد</label>
                                            <input type="date" class="form-control" data-provider="flatpickr"
                                                id="birthday" data-date-format="d M, Y" data-deafult-date="24 Nov, 2021"
                                                value="{{$user->birthday}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3 pb-2">
                                            <label for="bio" class="form-label">الوصف</label>
                                            <textarea class="form-control" id="bio" placeholder="Enter your description"
                                                rows="3">{{$user->bio}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" onclick="update('{{$user->id}}')"
                                                class="btn btn-primary">
                                                تعديل
                                            </button>
                                            <button type="button" class="btn btn-soft-success">
                                                إلغاء
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">كلمة المررو
                                                القديمة*</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                placeholder="Enter current password" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">كلمة المرور
                                                الجديدة*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                placeholder="Enter new password" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">تأكيد كلمة
                                                المرور*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">
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
    function updateUserImage(userId) {
    let fileInput = document.getElementById('profile-img-file-input');
    let file = fileInput.files[0];
    if (!file) return;

    let formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('user_img', file);

    axios.post(`/dashboard/users/${userId}/update/user-image`, formData)
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

<script>
    function update(userId){
    axios.put(`/dashboard/users/${userId}`,{
    first_name : document.getElementById('first_name').value,
    last_name : document.getElementById('last_name').value,
    phone : document.getElementById('phone').value,
    birthday : document.getElementById('birthday').value,
    bio : document.getElementById('bio').value,
    email : document.getElementById('email').value,
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
@endpush