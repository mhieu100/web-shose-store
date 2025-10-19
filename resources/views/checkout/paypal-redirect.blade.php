@extends('layouts.frontend')

@section('title', 'Chuyển hướng PayPal - Thanh toán')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fab fa-paypal fa-4x text-primary"></i>
                    </div>
                    <h3 class="mb-3">Đang chuyển đến PayPal...</h3>
                    <p class="text-muted mb-4">
                        Bạn sẽ được chuyển đến PayPal để hoàn tất thanh toán.<br>
                        Vui lòng đợi trong giây lát...
                    </p>
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto redirect after 3 seconds if JavaScript redirect fails
setTimeout(function() {
    window.location.href = '{{ $paypal_url ?? "#" }}';
}, 3000);

// Immediate redirect
@if(isset($paypal_url))
window.location.href = '{{ $paypal_url }}';
@endif
</script>
@endsection