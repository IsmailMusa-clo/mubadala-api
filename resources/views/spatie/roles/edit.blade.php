@extends('layouts.parent')

@section('title','تعديل الدور')

@section('content')
<div class="container-fluid">
    <!-- Users Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">تعديل الدور</h5>
                    @can('عرض الادوار')
                    <a class="btn btn-primary" href="{{route('roles.index')}}"> رجوع</a>
                    @endcan
                </div>
                <div class="card-body">
                    <form action="javascript:void(0);">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">الاسم</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your firstname"
                                        value="{{$role->name}}" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" onclick="update('{{$role->id}}')" class="btn btn-primary">
                                        حفظ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>

</div>
@endsection

@push('scripts')
<script>
    function update(roleId){
        axios.put(`/dashboard/roles/${roleId}`,{
            'name': document.getElementById('name').value,
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