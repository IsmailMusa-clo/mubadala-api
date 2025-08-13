@extends('layouts.parent')

@section('title','الصلاحيات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">إدارة الصلاحيات</h5>
                </div>
                <div class="card-body">
                    <table id="usersTable" class="table table-striped table-bordered nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الاسم</th>
                                <th>الصلاحية</th>
                                <th>الإجراءات</th>
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
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @can('عرض الصلاحيات')
                                            <li><a href="{{ route('permissions.show',$permission->id) }}"
                                                    class="dropdown-item">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> عرض
                                                </a></li>
                                            @endcan
                                            @can('تعديل الصلاحيات')
                                            <li><a href="{{ route('permissions.edit',$permission->id) }}"
                                                    class="dropdown-item">
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> تعديل
                                                </a></li>
                                            @endcan
                                            @can('حذف الصلاحيات')
                                            <li><button onclick="confirmDelete('{{ $permission->id }}',this)"
                                                    class="dropdown-item">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> حذف
                                                </button></li>
                                            @endcan
                                        </ul>
                                    </div>
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

    function confirmDelete(permissionId, ref) {
        Swal.fire({
            title: "هل أنت متأكد؟",
            text: "لن تتمكن من استرجاعه!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "نعم، احذفه!",
            cancelButtonText: "تراجع",
        }).then((result) => {
            if (result.isConfirmed) {
                destroy(permissionId, ref);
            }
        });
    }

    function showMessage(data){
        Swal.fire({
            icon: data.icon,
            title: data.message,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function destroy(permissionId, ref){
        axios.delete(`/dashboard/permissions/${permissionId}`)
        .then(function (response) {
            showMessage(response.data);
            $(ref).closest('tr').remove();
        })
        .catch(function (error) {
            toastr.error(error.response.data.message)
        });
    }
</script>
@endpush