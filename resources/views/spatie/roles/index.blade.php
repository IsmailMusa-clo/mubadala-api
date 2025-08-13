@extends('layouts.parent')

@section('title','الادمن')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">إدارة الادمن</h5>
                </div>
                <div class="card-body">
                    <table id="usersTable" class="table table-striped table-bordered nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الاسم</th>
                                <th>النوع</th>
                                <th>الصلاحيات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a class="btn btn-block btn-primary" href="{{route('roles.show',$role->id)}}">
                                        ({{$role->permissions_count}}) الصلاحيات
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-success">ادمن</span>
                                </td>
                                <td>
                                    @canany(['عرض الادوار', 'تعديل الادوار', 'حذف الادوار'])
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @can('عرض الادوار')
                                            <li><a href="{{ route('roles.show',$role->id) }}" class="dropdown-item">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> عرض
                                                </a></li>
                                            @endcan

                                            @can('تعديل الادوار')
                                            <li><a href="{{ route('roles.edit',$role->id) }}" class="dropdown-item">
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> تعديل
                                                </a></li>
                                            @endcan

                                            @can('حذف الادوار')
                                            <li><button onclick="confirmDelete('{{ $role->id }}',this)"
                                                    class="dropdown-item">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> حذف
                                                </button></li>
                                            @endcan
                                        </ul>
                                    </div>
                                    @endcanany
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">لا يوجد ادمنز</td>
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

    function confirmDelete(roleId, ref) {
        Swal.fire({
            title: "هل أنت متأكد؟",
            text: "لن تتمكن من استرجاعه!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "نعم، احذفه!",
            cancelButtonText: "تراجع",
        }).then((result) => {
            if (result.isConfirmed) {
                destroy(roleId, ref);
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

    function destroy(roleId, ref){
        axios.delete(`/dashboard/roles/${roleId}`)
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