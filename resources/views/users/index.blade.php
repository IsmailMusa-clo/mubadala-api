@extends('layouts.parent')

@section('title','المستخدمين')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">إدارة المستخدمين</h5>
                </div>
                <div class="card-body">
                    <table id="usersTable" class="table table-striped table-bordered nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>الدور</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'لا يوجد' }}</td>
                                <td>{{ $user->role->name ?? 'مستخدم' }}</td>
                                <td>
                                    @if ($user->status == 'active')
                                    <span class="badge bg-success">نشط</span>
                                    @else
                                    <span class="badge bg-danger">محظور</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="{{ route('users.show',$user->id) }}" class="dropdown-item">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> عرض
                                                </a></li>
                                            <li><a href="{{ route('users.edit',$user->id) }}" class="dropdown-item">
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> تعديل
                                                </a></li>
                                            <li><button onclick="confirmDelete('{{ $user->id }}',this)"
                                                    class="dropdown-item">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> حذف
                                                </button></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">لا يوجد مستخدمين</td>
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

    function confirmDelete(userId, ref) {
        Swal.fire({
            title: "هل أنت متأكد؟",
            text: "لن تتمكن من استرجاعه!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "نعم، احذفه!",
            cancelButtonText: "تراجع",
        }).then((result) => {
            if (result.isConfirmed) {
                destroy(userId, ref);
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

    function destroy(userId, ref){
        axios.delete(`/dashboard/users/${userId}`)
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