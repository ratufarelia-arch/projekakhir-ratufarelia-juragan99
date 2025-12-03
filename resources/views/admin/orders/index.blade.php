@php
use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="__('Orders')">
    <div class="min-h-screen bg-zinc-50 font-sans text-zinc-900 p-4 lg:p-8 rounded-2xl">

        {{-- Header Section --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900">{{ __('Daftar Pesanan') }}</h1>
                <p class="mt-1 text-sm text-zinc-500">{{ __('Pantau transaksi masuk, status pembayaran, dan pengiriman.') }}</p>
            </div>

            {{-- Search / Filter Action --}}
            <div class="flex gap-2">
                <form method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('Cari Order ID, nama, atau email...') }}"
                            class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 w-64">
                        <svg class="absolute right-3 top-2.5 h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-emerald-500 px-4 py-3 text-xs font-semibold uppercase tracking-[0.3em] text-white shadow-sm transition hover:bg-emerald-600">
                        {{ __('Search') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100 text-left text-sm">
                    <thead>
                        <tr class="bg-zinc-50/50">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Order ID') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Pelanggan') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Total') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Status') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Tanggal') }}</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        @forelse($orders as $order)
                        <tr class="group transition hover:bg-zinc-50/80">
                            {{-- Order ID --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-emerald-600">#{{ $order->id }}</span>
                            </td>

                            {{-- Customer Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 flex-shrink-0 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase">
                                        {{ substr($order->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-zinc-900">{{ $order->customer_name }}</div>
                                        <div class="text-xs text-zinc-500">{{ $order->customer_email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Total & Items Count --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-zinc-900">Rp{{ number_format($order->total, 0, ',', '.') }}</div>
                                <div class="text-xs text-zinc-500">{{ $order->items_count }} Item(s)</div>
                            </td>

                            {{-- Status Badges --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                // Logika warna badge sederhana
                                $statusStyles = match($order->status) {
                                'completed', 'shipped' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                'processing', 'paid' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                'cancelled', 'failed' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                                default => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20', // pending
                                };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $statusStyles }}">
                                    {{ Str::ucfirst($order->status) }}
                                </span>
                            </td>

                            {{-- Created Date --}}
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 text-xs">
                                <p>{{ $order->created_at->format('d M Y') }}</p>
                                <p class="text-zinc-400">{{ $order->created_at->format('H:i') }} WIB</p>
                            </td>

                            {{-- Action Button --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:border-emerald-300 hover:text-emerald-700 hover:shadow-md">
                                    {{ __('Detail') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="ml-1.5" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="rounded-full bg-zinc-50 p-4 mb-3">
                                        <svg class="h-8 w-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-zinc-900">{{ __('Belum ada pesanan') }}</h3>
                                    <p class="text-xs text-zinc-500 mt-1 max-w-xs">{{ __('Pesanan baru akan muncul di sini setelah pelanggan melakukan checkout.') }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if($orders->hasPages())
            <div class="border-t border-zinc-100 bg-zinc-50 px-6 py-4">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.app>