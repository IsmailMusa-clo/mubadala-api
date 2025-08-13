@extends('layouts.parent')

@section('title', '403 - رفض الوصول')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
    <div class="text-center">
        <h1 class="display-1 text-danger">403</h1>
        <h4 class="mb-3">عذرًا، ليس لديك إذن للوصول إلى هذه الصفحة</h4>
        <a href="{{ url('/') }}" class="btn btn-primary">
            العودة إلى الرئيسية
        </a>
    </div>
</div>
@endsection