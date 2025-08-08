@extends('layouts.parent')

@section('title','ادارة التصنيفات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                        إضافة التصنيفات
                    </h4>
                    <div class="text-end mb-3">
                        <a href="{{route('categories.index')}}" class="btn btn-primary">
                            <i class="ri-back-fill align-bottom me-1"></i>رجوع
                        </a>
                    </div>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <form id="form-create" class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label">اسم الفئة</label>
                                <input type="text" class="form-control" id="name" value="" name="name" required />
                            </div>
                            <div class="col-md-12">
                                <label for="description" class="form-label">وصف الفئة</label>
                                <textarea name="description" class="form-control" id="description" cols="30"
                                    rows="5"></textarea>
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
    function store(){
        axios.post(`/dashboard/categories`,{
            'name': document.getElementById('name').value,
            'description': document.getElementById('description').value,
        })
        .then(function (response) {
            console.log(response.data);
            toastr.success(response.data.message)
            document.getElementById('form-create').reset()
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message)
    })
    }
</script>
@endpush