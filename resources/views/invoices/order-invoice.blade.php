<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #{{ $invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .company-info {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .invoice-info {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .invoice-number {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        
        .customer-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .customer-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1f2937;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th {
            background-color: #2563eb;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .summary {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        
        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .summary-label {
            display: table-cell;
            padding: 8px 0;
            font-weight: bold;
        }
        
        .summary-value {
            display: table-cell;
            text-align: right;
            padding: 8px 0;
        }
        
        .total-row {
            border-top: 2px solid #2563eb;
            background-color: #eff6ff;
            padding: 10px 0;
        }
        
        .total-row .summary-label,
        .total-row .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #1d4ed8;
        }
        
        .footer {
            clear: both;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-new { background-color: #dbeafe; color: #1d4ed8; }
        .status-processing { background-color: #fef3c7; color: #d97706; }
        .status-shipped { background-color: #d1fae5; color: #059669; }
        .status-delivered { background-color: #dcfce7; color: #16a34a; }
        .status-cancelled { background-color: #fee2e2; color: #dc2626; }
        
        .currency {
            font-weight: normal;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <div class="company-name">{{ $company['name'] }}</div>
                <div>{{ $company['address'] }}</div>
                <div>Điện thoại: {{ $company['phone'] }}</div>
                <div>Email: {{ $company['email'] }}</div>
                <div>Website: {{ $company['website'] }}</div>
            </div>
            <div class="invoice-info">
                <div class="invoice-title">HÓA ĐƠN</div>
                <div class="invoice-number">{{ $invoice_number }}</div>
                <div>Ngày: {{ $invoice_date }}</div>
                <div>
                    <span class="status-badge status-{{ $order->status->value }}">
                        {{ $order->status->getLabel() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <div class="customer-title">Thông tin khách hàng:</div>
            <div><strong>Tên:</strong> {{ $order->customer->name ?? 'Khách vãng lai' }}</div>
            @if($order->customer && $order->customer->email)
                <div><strong>Email:</strong> {{ $order->customer->email }}</div>
            @endif
            @if($order->customer && $order->customer->phone)
                <div><strong>Điện thoại:</strong> {{ $order->customer->phone }}</div>
            @endif
            @if($order->address)
                <div><strong>Địa chỉ giao hàng:</strong></div>
                <div>
                    {{ $order->address->street }}<br>
                    {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip }}<br>
                    {{ $order->address->country }}
                </div>
            @endif
        </div>

        <!-- Order Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 10%;">STT</th>
                    <th style="width: 40%;">Sản phẩm</th>
                    <th style="width: 15%;" class="text-center">Số lượng</th>
                    <th style="width: 17.5%;" class="text-right">Đơn giá</th>
                    <th style="width: 17.5%;" class="text-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</strong>
                        @if($item->product && $item->product->sku)
                            <br><small>SKU: {{ $item->product->sku }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($item->qty) }}</td>
                    <td class="text-right">
                        {{ number_format($item->unit_price, 0, ',', '.') }} 
                        <span class="currency">{{ $order->currency }}</span>
                    </td>
                    <td class="text-right">
                        {{ number_format($item->total_price, 0, ',', '.') }} 
                        <span class="currency">{{ $order->currency }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <div class="summary-label">Tạm tính:</div>
                <div class="summary-value">
                    {{ number_format($order->items->sum('total_price'), 0, ',', '.') }} {{ $order->currency }}
                </div>
            </div>
            
            @if($order->shipping_price > 0)
            <div class="summary-row">
                <div class="summary-label">Phí vận chuyển:</div>
                <div class="summary-value">
                    {{ number_format($order->shipping_price, 0, ',', '.') }} {{ $order->currency }}
                </div>
            </div>
            @endif
            
            <div class="summary-row total-row">
                <div class="summary-label">Tổng cộng:</div>
                <div class="summary-value">
                    {{ number_format($order->total_price, 0, ',', '.') }} {{ $order->currency }}
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn bạn đã mua hàng tại {{ $company['name'] }}!</p>
            <p>Mọi thắc mắc xin liên hệ: {{ $company['phone'] }} hoặc {{ $company['email'] }}</p>
        </div>
    </div>
</body>
</html>