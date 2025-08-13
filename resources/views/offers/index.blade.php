@extends('layouts.parent')

@section('title','العروض')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">إدارة العروض</h5>
                </div>
                <div class="card-body">
                    <table id="offersTable" class="table table-striped table-bordered nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>المنتج</th>
                                <th>الوصف</th>
                                <th>المنطقة</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($offers as $offers)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$offers->product->name}}</td>
                                <td>{{$offers->description ?? "لا يوجد"}}</td>
                                <td>{{$offers->location ?? "لا يوجد"}}</td>
                                <td>
                                    @if ($offers->status == 'pending')
                                    <span class="badge bg-danger">معلق</span>
                                    @elseif($offers->status == 'accepted')
                                    <span class="badge bg-warning">مقبول</span>
                                    @elseif($offers->status == 'rejected')
                                    <span class="badge bg-warning">مرفوض</span>
                                    @else
                                    <span class="badge bg-success">مكتمل</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="{{route('doffers.show',$offers->id)}}" class="dropdown-item">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> عرض
                                                </a></li>
                                            @can('حذف العروض')
                                            <li><button onclick="confirmDelete('{{$offers->id}}',this)"
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
                                <td colspan="8" class="text-center">لا توجد عروض</td>
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
    $('#offersTable').DataTable({
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

function confirmDelete(productId, ref) {
    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "لن تتمكن من استرجاعه!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "نعم، احذفه!",
        cancelButtonText: "تراجع",
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(productId, ref);
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

function destroy(offerId, ref){
    axios.delete(`/dashboard/offers/${offerId}/delete`)
    .then(function (response) {
        showMessage(response.data);
        $(ref).closest('tr').remove();
    })
    .catch(function (error) {
        toastr.error(error.response.data.message)
    })
}
</script>
@endpush