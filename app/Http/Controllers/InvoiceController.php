<?php

namespace App\Http\Controllers;

use App\Models\Shop\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * Generate and download invoice PDF
     */
    public function downloadInvoice(Order $order)
    {
        // Load relationships cần thiết
        $order->load(['customer', 'items.product', 'address', 'payments']);

        $data = [
            'order' => $order,
            'company' => [
                'name' => config('app.name', 'Cửa hàng'),
                'address' => 'Địa chỉ cửa hàng',
                'phone' => '0123-456-789',
                'email' => 'info@cuahang.com',
                'website' => config('app.url'),
            ],
            'invoice_date' => now()->format('d/m/Y'),
            'invoice_number' => 'HD-' . $order->number,
        ];

        $pdf = Pdf::loadView('invoices.order-invoice', $data);
        
        // Thiết lập PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);

        $filename = 'hoa-don-' . $order->number . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * View invoice in browser
     */
    public function viewInvoice(Order $order)
    {
        // Load relationships cần thiết
        $order->load(['customer', 'items.product', 'address', 'payments']);

        $data = [
            'order' => $order,
            'company' => [
                'name' => config('app.name', 'Cửa hàng'),
                'address' => 'Địa chỉ cửa hàng', 
                'phone' => '0123-456-789',
                'email' => 'info@cuahang.com',
                'website' => config('app.url'),
            ],
            'invoice_date' => now()->format('d/m/Y'),
            'invoice_number' => 'HD-' . $order->number,
        ];

        $pdf = Pdf::loadView('invoices.order-invoice', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('hoa-don-' . $order->number . '.pdf');
    }
}