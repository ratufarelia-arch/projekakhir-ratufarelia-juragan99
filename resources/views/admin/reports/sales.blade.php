<x-layouts.app :title="__('Laporan Penjualan')">
    <div class="space-y-6">
        <section class="rounded-2xl border border-zinc-200 bg-white/80 p-6 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
            <header class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm text-zinc-500">{{ __('Admin mengunduh rekap penjualan dalam format Excel.') }}</p>
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Ekspor Laporan Penjualan') }}</h1>
                    <p class="text-sm text-zinc-500">{{ __('Tentukan rentang tanggal untuk membatasi data yang akan diunduh.') }}</p>
                </div>
            </header>

            <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex flex-col gap-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="flex flex-col text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        <span class="mb-2 text-xs uppercase tracking-wide text-zinc-500">{{ __('Dari tanggal') }}</span>
                        <input
                            type="date"
                            name="date_from"
                            value="{{ $filters['dateFrom'] ?? '' }}"
                            class="rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm shadow-zinc-900/5 transition focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                        />
                    </label>
                    <label class="flex flex-col text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        <span class="mb-2 text-xs uppercase tracking-wide text-zinc-500">{{ __('Sampai tanggal') }}</span>
                        <input
                            type="date"
                            name="date_to"
                            value="{{ $filters['dateTo'] ?? '' }}"
                            class="rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm shadow-zinc-900/5 transition focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                        />
                    </label>
                </div>

                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-zinc-500">
                        {{ __('Rentang ini akan diterapkan pada data yang ditampilkan dan diekspor.') }}
                    </p>

                    <div class="flex flex-wrap items-center gap-2">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm shadow-zinc-900/5 transition hover:border-zinc-300 hover:text-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                        >
                            {{ __('Tampilkan rekap') }}
                        </button>
                        <button
                            type="submit"
                            name="export"
                            value="1"
                            class="inline-flex items-center justify-center rounded-2xl border border-emerald-500 bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600 focus:outline-none"
                        >
                            {{ __('Ekspor Excel') }}
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">{{ __('Rentang aktif') }}</p>
                <p class="text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ $filters['dateFrom'] ?? __('Semua waktu') }} · {{ $filters['dateTo'] ?? __('Hari ini') }}
                </p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">{{ __('Pesanan terfilter') }}</p>
                <p class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ number_format($summary['orders']) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">{{ __('Total pendapatan') }}</p>
                <p class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ number_format($summary['revenue'], 2) }}</p>
            </article>
        </section>

        <section class="rounded-2xl border border-zinc-200 bg-white/80 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
            <header class="flex items-center justify-between border-b border-zinc-100 px-6 py-4 dark:border-zinc-700">
                <div>
                    <p class="text-sm text-zinc-500">{{ __('Ringkasan pesanan terbaru') }}</p>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Pesanan') }}</h2>
                </div>
                <span class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('Menyertakan detail pelanggan, status, dan total') }}</span>
            </header>

            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-zinc-100 text-sm text-zinc-700 dark:divide-zinc-700 dark:text-white">
                    <thead class="bg-zinc-50 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3">{{ __('ID') }}</th>
                            <th class="px-6 py-3">{{ __('Nama pelanggan') }}</th>
                            <th class="px-6 py-3">{{ __('Total') }}</th>
                            <th class="px-6 py-3">{{ __('Status') }}</th>
                            <th class="px-6 py-3">{{ __('Dibayar') }}</th>
                            <th class="px-6 py-3">{{ __('Tanggal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white dark:bg-zinc-900">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-3 font-semibold text-zinc-900 dark:text-white">#{{ $order->id }}</td>
                                <td class="px-6 py-3">
                                    <p class="font-semibold text-zinc-900 dark:text-white">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->customer_email }}</p>
                                </td>
                                <td class="px-6 py-3">{{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-3 capitalize text-zinc-900 dark:text-white">{{ $order->status }}</td>
                                <td class="px-6 py-3 capitalize text-zinc-900 dark:text-white">{{ $order->payment_status }}</td>
                                <td class="px-6 py-3 text-xs text-zinc-500 dark:text-zinc-400">{{ $order->created_at->toDayDateTimeString() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ __('Tidak ada pesanan untuk rentang ini.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4">
                {{ $orders->links() }}
            </div>
        </section>
    </div>
</x-layouts.app>
