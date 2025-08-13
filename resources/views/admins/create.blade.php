@extends('layouts.parent')

@section('title','انشاء أدمن')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                        إضافة أدمن
                    </h4>
                    <div class="text-end mb-3">
                        <a href="{{route('admins.index')}}" class="btn btn-primary">
                            <i class="ri-back-fill align-bottom me-1"></i>رجوع
                        </a>
                    </div>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <form class="row g-3" id="form-create">
                            <div class="col-md-12">
                                <label for="role" class="form-label">الصلاحيات</label>
                                <select class="form-select" id="role_id">
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">الاسم</label>
                                    <input type="text" class="form-control" id="name" placeholder="ادخل الاسم" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الالكتروني</label>
                                    <input type="email" class="form-control" id="email" placeholder="ادخل الايميل" />
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="button" onclick="store()">
                                    حفظ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
</div>
@endsection

@push('styles')

@endpush

@push('scripts')
<script>
    function store() {
    let name = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    let role_id = document.getElementById('role_id').value;
    axios.post(`/dashboard/admins`, {
        name,
        email,
        role_id
    })
    .then(function (response) {
        console.log(response.data);
        document.getElementById('form-create').reset();
        toastr.success(response.data.message);
    })
    .catch(function (error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
    });
}

</script>
@endpush