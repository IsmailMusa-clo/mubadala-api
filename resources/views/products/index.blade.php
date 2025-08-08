@extends('layouts.parent')

@section('title','المنتجات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">إدارة المنتجات</h5>
                </div>
                <div class="card-body">
                    <table id="productsTable" class="table table-striped table-bordered nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الاسم</th>
                                <th>صاحب المنتج</th>
                                <th>التصنيف</th>
                                <th>الوصف</th>
                                <th>المنطقة</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->user->name}}</td>
                                <td>{{$product->category->name ?? 'لا يوجد'}}</td>
                                <td>{{$product->description ?? "لا يوجد"}}</td>
                                <td>{{$product->location ?? "لا يوجد"}}</td>
                                <td>
                                    @if ($product->status == 'free')
                                    <span class="badge bg-success">متاح</span>
                                    @elseif($product->status == 'reserved')
                                    <span class="badge bg-warning">محجوز</span>
                                    @else
                                    <span class="badge bg-danger">تم التبادل</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="{{route('dproducts.show',$product->id)}}"
                                                    class="dropdown-item">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> عرض
                                                </a></li>
                                            <li><button onclick="confirmDelete('{{$product->id}}',this)"
                                                    class="dropdown-item">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> حذف
                                                </button></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">لا توجد منتجات</td>
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
    $('#productsTable').DataTable({
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

function destroy(productId, ref){
    axios.delete(`/dashboard/products/${productId}/delete`)
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