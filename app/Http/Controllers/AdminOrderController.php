<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::withCount('items')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', Order::statuses())],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', __('Status pesanan telah diperbarui.'));
    }

    public function salesReport(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $export = $request->boolean('export');

        $query = Order::query();

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($export) {
            return $this->streamSalesReport((clone $query)->orderByDesc('created_at')->get());
        }

        $orders = (clone $query)
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $summary = [
            'orders' => (clone $query)->count(),
            'revenue' => (clone $query)->sum('total'),
        ];

        return view('admin.reports.sales', [
            'orders' => $orders,
            'filters' => compact('dateFrom', 'dateTo'),
            'summary' => $summary,
        ]);
    }

    protected function streamSalesReport(Collection $orders)
    {
        $filename = 'laporan-penjualan-' . now()->format('YmdHis') . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                __('Order ID'),
                __('Customer'),
                __('Email'),
                __('Status'),
                __('Payment Status'),
                __('Total'),
                __('Date'),
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->customer_name,
                    $order->customer_email,
                    $order->status,
                    $order->payment_status,
                    number_format($order->total, 2),
                    $order->created_at->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }
}
