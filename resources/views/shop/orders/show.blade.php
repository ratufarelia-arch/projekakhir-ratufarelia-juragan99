@php
    use App\Models\Order;
    use Illuminate\Support\Str;

    // Helper warna status (Konsisten dengan halaman index)
    $getStatusClasses = function($status) {
        return match(Str::lower($status)) {
            'paid', 'completed', 'success', 'dikirim', 'selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'pending', 'unpaid', 'menunggu', 'waiting' => 'bg-amber-100 text-amber-700 border-amber-200',
            'cancelled', 'failed', 'batal' => 'bg-rose-100 text-rose-700 border-rose-200',
            default => 'bg-zinc-100 text-zinc-700 border-zinc-200',
        };
    };
@endphp

<x-layouts.plain :title="__('Order #') . $order->id">
    <div class="min-h-screen bg-white pb-20 pt-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb / Back Button --}}
            <div class="mb-6">
                <a href="{{ route('shop.orders.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-500 transition hover:text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Kembali ke Pesanan Saya') }}
                </a>
            </div>

            {{-- Main Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-zinc-900">{{ __('Order #') }}{{ $order->id }}</h1>
                    <div class="mt-2 flex items-center gap-3 text-sm text-zinc-500">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-zinc-400">
                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                            </svg>
                            {{ $order->created_at->format('d F Y') }}
                        </span>
                        <span class="text-zinc-300">|</span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-zinc-400">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                            </svg>
                            {{ $order->created_at->format('H:i') }} WIB
                        </span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="rounded-full border px-4 py-1.5 text-xs font-bold uppercase tracking-wider {{ $getStatusClasses($order->status) }}">
                        {{ $order->status }}
                    </span>
                    <a
                        href="{{ route('shop.orders.invoice', $order) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white p-2 text-zinc-500 shadow-sm hover:bg-zinc-50 hover:text-zinc-900"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153V2.75zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3z" clip-rule="evenodd" />
                        <span class="text-xs font-semibold uppercase tracking-[0.3em]">{{ __('Cetak Invoice') }}</span>
                    </a>
                </div>

            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                
                {{-- LEFT COLUMN: Items List (Takes up 2/3 width) --}}
                <div class="lg:col-span-2">
                    <section class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm">
                        <div class="border-b border-zinc-100 bg-zinc-50/50 px-6 py-4">
                            <h2 class="font-semibold text-zinc-900">{{ __('Daftar Produk') }}</h2>
                        </div>
                        
                        <div class="divide-y divide-zinc-100">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 p-6 hover:bg-zinc-50/50 transition">
                                    {{-- Product Icon/Image Placeholder --}}
                                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                        {{-- Jika ada relation ke image product, ganti ini dengan <img> --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>

                                    <div class="flex-1">
                                        <h3 class="font-bold text-zinc-900">{{ $item->product_name }}</h3>
                                        <div class="mt-1 flex items-center gap-2 text-sm text-zinc-500">
                                            <span>{{ number_format($item->unit_price, 0, ',', '.') }}</span>
                                            <span>&times;</span>
                                            <span>{{ $item->quantity }} pcs</span>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-bold text-zinc-900">Rp{{ number_format($item->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total Calculation Section --}}
                        <div class="bg-zinc-50 p-6">
                            <div class="ml-auto w-full space-y-3 sm:max-w-xs">
                                <div class="flex justify-between text-sm text-zinc-600">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span class="font-medium text-zinc-900">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-zinc-600">
                                    <span>{{ __('Pengiriman') }}</span>
                                    <span class="text-zinc-400">{{ __('Termasuk') }}</span>
                                </div>
                                <div class="border-t border-zinc-200 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-base font-bold text-zinc-900">{{ __('Total') }}</span>
                                        <span class="text-xl font-bold text-emerald-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- RIGHT COLUMN: Sidebar Info (Takes up 1/3 width) --}}
                <div class="space-y-6 lg:col-span-1">
                    
                    {{-- Customer Info Card --}}
                    <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-400">{{ __('Informasi Pelanggan') }}</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 rounded-full bg-zinc-100 p-1.5 text-zinc-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-zinc-500">{{ $order->customer_email }}</p>
                                </div>
                            </div>
                            
                            @if($order->customer_phone)
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 rounded-full bg-zinc-100 p-1.5 text-zinc-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-sm text-zinc-700">{{ $order->customer_phone }}</p>
                            </div>
                            @endif
                        </div>
                    </section>

                    {{-- Shipping Info Card --}}
                    <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-400">{{ __('Alamat Pengiriman') }}</h2>
                        
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 rounded-full bg-zinc-100 p-1.5 text-zinc-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="space-y-3">
                                <p class="text-sm leading-relaxed text-zinc-700">{{ $order->customer_address }}</p>
                                
                                @if($order->notes)
                                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-3">
                                        <p class="text-xs font-semibold text-amber-800">{{ __('Catatan Kurir:') }}</p>
                                        <p class="text-xs italic text-amber-700">{{ $order->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>

                    {{-- Payment Status Card --}}
                    <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-400">{{ __('Detail Pembayaran') }}</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-zinc-500">{{ __('Status Bayar') }}</span>
                                <span class="font-medium text-zinc-900">{{ Str::ucfirst($order->payment_status) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-500">{{ __('Metode') }}</span>
                                <span class="font-medium text-zinc-900">Transfer / QRIS</span> {{-- Placeholder jika belum ada di DB --}}
                            </div>
                        </div>
                    </section>

                    {{-- Meat care tips --}}
                    <section class="rounded-3xl border border-emerald-200 bg-emerald-50/70 p-6 shadow-sm">
                        <h2 class="mb-3 text-sm font-bold uppercase tracking-[0.4em] text-emerald-700">{{ __('Tips Menyimpan Daging') }}</h2>
                        <p class="text-sm text-emerald-900">{{ __('Supaya daging tetap segar, simpan dengan cara berikut:') }}</p>
                        <ul class="mt-3 space-y-2 text-sm text-zinc-700">
                            <li class="flex gap-2">
                                <span class="mt-0.5 text-emerald-600">•</span>
                                <span>{{ __('Segera pindahkan ke kulkas suhu 0-4°C atau bekukan jika belum diolah dalam 3 jam.') }}</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="mt-0.5 text-emerald-600">•</span>
                                <span>{{ __('Simpan daging di bagian paling dingin, gunakan kemasan rapat agar tidak terkena udara.') }}</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="mt-0.5 text-emerald-600">•</span>
                                <span>{{ __('Untuk beku, pakai kantong vakum dan beri label tanggal agar rotasi stok mudah.') }}</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="mt-0.5 text-emerald-600">•</span>
                                <span>{{ __('Jangan mencairkan dan membekukan ulang agar tekstur tetap terjaga.') }}</span>
                            </li>
                        </ul>
                    </section>

                    @if($order->status === Order::STATUS_COMPLETED)
                        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-400">{{ __('Ulasan & Rating Produk') }}</h2>

                            @if($order->review)
                                <div class="space-y-3 rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-zinc-900">{{ __('Rating') }}: {{ $order->review->rating }}/5</p>
                                            <p class="text-xs text-zinc-500">{{ $order->review->created_at->format('d F Y') }}</p>
                                        </div>
                                        <div class="flex gap-1 text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $order->review->rating ? 'text-amber-500' : 'text-zinc-300' }}">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-zinc-600">{{ $order->review->comment }}</p>
                                </div>
                            @else
                                <form method="POST" action="{{ route('shop.orders.reviews.store', $order) }}" class="space-y-4">
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-zinc-700">{{ __('Rating kualitas (1-5)') }}</label>
                                        <div class="flex flex-wrap items-center gap-3 text-sm font-semibold">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="flex items-center gap-1 text-zinc-500">
                                                    <input
                                                        type="radio"
                                                        name="rating"
                                                        value="{{ $i }}"
                                                        @checked(old('rating') == $i)
                                                        class="h-4 w-4 rounded border border-zinc-300 text-emerald-600 focus:ring-emerald-500"
                                                    />
                                                    {{ $i }}
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <p class="text-xs text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-zinc-700">{{ __('Ulasan Anda') }}</label>
                                        <textarea
                                            name="comment"
                                            rows="4"
                                            class="w-full rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 shadow-sm focus:border-emerald-500 focus:outline-none"
                                        >{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <p class="text-xs text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button
                                        type="submit"
                                        class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm shadow-emerald-600/30 transition hover:bg-emerald-700"
                                    >
                                        {{ __('Kirim Ulasan') }}
                                    </button>
                                </form>
                            @endif
                        </section>
                    @endif

                </div>

            </div>
        </div>
    </div>
</x-layouts.plain>