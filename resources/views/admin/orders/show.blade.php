@php
    use App\Models\Order;
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="__('Order #') . $order->id">
    <div class="min-h-screen bg-zinc-50 font-sans text-zinc-900 p-4 lg:p-8 rounded-2xl">
        
        {{-- Header & Navigasi --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-zinc-500 mb-1">
                    <a href="{{ route('admin.orders.index') }}" class="hover:text-emerald-600 transition">Orders</a>
                    <span>/</span>
                    <span>Detail</span>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900">
                    Order #{{ $order->id }}
                </h1>
                <p class="text-sm text-zinc-500 mt-1">
                    Dibuat pada {{ $order->created_at->format('d F Y, H:i') }}
                </p>
            </div>
            
            <div class="flex gap-3">
                {{-- Tombol Print (Opsional/Dummy) --}}
                <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3z"/></svg>
                    Print Invoice
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800 shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-3">
            
            {{-- KOLOM KIRI (UTAMA): List Item & Bukti Bayar --}}
            <div class="space-y-8 lg:col-span-2">
                
                {{-- 1. Order Items --}}
                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
                    <div class="border-b border-zinc-100 px-6 py-4">
                        <h2 class="font-bold text-zinc-900">{{ __('Item Pesanan') }}</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">{{ __('Produk') }}</th>
                                    <th class="px-6 py-3 font-semibold text-right">{{ __('Harga') }}</th>
                                    <th class="px-6 py-3 font-semibold text-center">{{ __('Qty') }}</th>
                                    <th class="px-6 py-3 font-semibold text-right">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach($order->items as $item)
                                    <tr class="hover:bg-zinc-50/50 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-zinc-900">{{ $item->product_name }}</div>
                                            {{-- Jika ada varian, bisa ditampilkan disini --}}
                                        </td>
                                        <td class="px-6 py-4 text-right text-zinc-600">
                                            Rp{{ number_format($item->unit_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-zinc-600">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-medium text-zinc-900">
                                            Rp{{ number_format($item->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-zinc-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-medium text-zinc-500">{{ __('Subtotal') }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-zinc-900">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- 2. Payment Proofs --}}
                @php
                    $proofItems = $order->items->filter(fn($item) => !empty($item->payment_proof));
                @endphp

                @if($proofItems->isNotEmpty())
                    <div class="rounded-2xl border border-zinc-200 bg-white shadow-sm">
                        <div class="border-b border-zinc-100 px-6 py-4 flex justify-between items-center">
                            <h2 class="font-bold text-zinc-900">{{ __('Bukti Pembayaran') }}</h2>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-700">{{ $proofItems->count() }} Files</span>
                        </div>
                        <div class="p-6 grid gap-6 sm:grid-cols-2">
                            @foreach($proofItems as $item)
                                @php
                                    $proofUrl = asset('storage/' . $item->payment_proof);
                                    $proofExtension = Str::of($item->payment_proof)->afterLast('.')->lower();
                                    $isImageProof = in_array($proofExtension, ['png', 'jpg', 'jpeg', 'webp', 'gif', 'bmp']);
                                @endphp

                                <div class="group relative flex flex-col overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 transition hover:border-emerald-300 hover:shadow-md">
                                    {{-- Preview Area --}}
                                    <div class="aspect-video w-full overflow-hidden bg-zinc-200 relative">
                                        @if($isImageProof)
                                            <img
                                                src="{{ $proofUrl }}"
                                                alt="Bukti Bayar"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            />
                                            {{-- Overlay Action --}}
                                            <a href="{{ $proofUrl }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition group-hover:opacity-100">
                                                <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-medium text-white backdrop-blur-sm border border-white/30">
                                                    Lihat Full Size
                                                </span>
                                            </a>
                                        @else
                                            <div class="flex h-full flex-col items-center justify-center text-zinc-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/></svg>
                                                <span class="mt-2 text-xs font-medium uppercase tracking-wide">Dokumen</span>
                                            </div>
                                            <a href="{{ $proofUrl }}" target="_blank" class="absolute inset-0 z-10"></a>
                                        @endif
                                    </div>
                                    
                                    {{-- Caption --}}
                                    <div class="flex flex-1 flex-col justify-between p-3">
                                        <div>
                                            <p class="text-xs font-medium text-emerald-600 mb-1">Untuk Produk:</p>
                                            <p class="text-sm font-bold text-zinc-900 line-clamp-1" title="{{ $item->product_name }}">{{ $item->product_name }}</p>
                                        </div>
                                        <div class="mt-3 flex items-center justify-between border-t border-zinc-200 pt-2 text-[10px] text-zinc-500">
                                            <span class="truncate max-w-[100px]">{{ basename($item->payment_proof) }}</span>
                                            <span class="font-mono">{{ strtoupper($proofExtension) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- KOLOM KANAN (SIDEBAR): Status, Info Customer, Summary --}}
            <div class="space-y-6">
                
                {{-- 1. Status Update Card --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-500">{{ __('Aksi Order') }}</h3>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 mb-2">{{ __('Update Status') }}</label>
                            <div class="relative">
                                <select name="status" class="w-full appearance-none rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm font-semibold text-zinc-900 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                    @foreach(Order::statuses() as $status)
                                        <option value="{{ $status }}" @selected($order->status === $status)>
                                            {{ Str::ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-emerald-200 transition hover:bg-emerald-700 hover:shadow-lg hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/></svg>
                            {{ __('Simpan Perubahan') }}
                        </button>
                    </form>
                </div>

                {{-- 2. Customer Info --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-500">{{ __('Pelanggan') }}</h3>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 flex text-lg font-bold">
                            {{ substr($order->customer_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-zinc-900">{{ $order->customer_name }}</p>
                            <p class="text-xs text-zinc-500">Customer</p>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm">
                        <li class="flex gap-3">
                            <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span class="text-zinc-600">{{ $order->customer_email }}</span>
                        </li>
                        <li class="flex gap-3">
                            <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            <span class="text-zinc-600">{{ $order->customer_phone ?? '-' }}</span>
                        </li>
                        <li class="flex gap-3">
                            <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span class="text-zinc-600 leading-relaxed">{{ $order->customer_address }}</span>
                        </li>
                    </ul>

                    @if($order->notes)
                        <div class="mt-6 rounded-xl bg-amber-50 border border-amber-100 p-4">
                            <p class="text-xs font-bold uppercase text-amber-600 mb-1">{{ __('Catatan:') }}</p>
                            <p class="text-sm text-amber-800">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- 3. Summary Info --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-500">{{ __('Ringkasan Order') }}</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-zinc-500">Status Bayar</span>
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-yellow-50 text-yellow-800 ring-yellow-600/20' }}">
                                {{ Str::ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-zinc-500">Status Order</span>
                            <span class="font-medium text-zinc-900">{{ Str::ucfirst($order->status) }}</span>
                        </div>
                        <div class="border-t border-dashed border-zinc-200 my-3"></div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-zinc-900">Total</span>
                            <span class="text-xl font-bold text-emerald-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>