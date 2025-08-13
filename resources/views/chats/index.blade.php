@extends('layouts.parent')

@section('title','الدردشات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">إدارة المحادثات</h5>
                </div>
                <div class="card-body">
                    <table id="categoriesTable" class="table table-striped table-bordered nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>المرسل</th>
                                <th>المستقبل</th>
                                <th>المنتج</th>
                                <th>احدث رسالة</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($chats as $chat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $chat->sender->name }}</td>
                                <td>{{ $chat->receiver->name }}</td>
                                <td>{{ $chat->product->name ?? 0 }}</td>
                                <td>{{ $chat->lastMessage->body ?? 0 }}</td>
                                <td>
                                    @if ($chat->status == 'close')
                                    <span class="badge bg-danger">مغلقة</span>
                                    @else
                                    <span class="badge bg-success">مفتوحة</span>
                                    @endif
                                </td>
                                <td>
                                    @canany(['حذف المحادثات'])
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @can('حذف المحادثات')
                                            <li>
                                                <button onclick="confirmDelete('{{ $chat->id }}', this)"
                                                    class="dropdown-item">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> حذف
                                                </button>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                    @endcanany
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">لا توجد تصنيفات</td>
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
    $('#categoriesTable').DataTable({
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

function confirmDelete(chatId, ref) {
    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "لن تتمكن من استرجاعه!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "نعم، احذفه!",
        cancelButtonText: "تراجع",
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(chatId, ref);
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

function destroy(chatId, ref){
    axios.delete(`/dashboard/chats/${chatId}`)
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