<x-mail::message>
# Đặt hàng thành công! 🎉

Xin chào **{{ $order->user->name ?? 'Khách hàng' }}**,

Cảm ơn bạn đã đặt hàng tại {{ config('app.name') }}!

## Thông tin đơn hàng

**Mã đơn hàng:** {{ $order->order_number }}  
**Ngày đặt:** {{ $order->created_at->format('d/m/Y H:i') }}  
**Phương thức thanh toán:** {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}  
**Tổng cộng:** ${{ number_format($order->total_price, 2) }}

<x-mail::button :url="$orderUrl">
Xem chi tiết đơn hàng
</x-mail::button>

Cảm ơn bạn đã mua sắm tại {{ config('app.name') }}!

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>
