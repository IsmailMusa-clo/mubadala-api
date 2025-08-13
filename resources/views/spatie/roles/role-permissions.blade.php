@extends('layouts.parent')

@section('title','صلاحيات' . ' '. $role->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">صلاحيات {{$role->name}}</h5>
                </div>
                <div class="card-body">
                    <table id="usersTable" class="table table-striped table-bordered nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الاسم</th>
                                <th>النوع</th>
                                <th>اعطاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <span class="badge bg-success">ادمن</span>
                                </td>
                                <td>
                                    <input style="cursor: pointer" class="form-check-input fs-15"
                                        onchange="update('{{$role->id}}','{{$permission->id}}')"
                                        @checked($permission->assigned)
                                    type="checkbox" id="permission_{{$permission->id}}"
                                    />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">لا يوجد صلاحيات</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            scrollX: true,
            paging: true,
            searching: true,
            lengthChange: true,
            info: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json"
            }
        });
    });

        function update(roleId,permissionId){
        axios.put(`/dashboard/roles/${roleId}/permission`,{
            'permission_id': permissionId,
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