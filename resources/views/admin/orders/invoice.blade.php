@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice #{{ $order->id }} - Jurangan99</title>
    
   <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
            .page-break { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-zinc-100 text-zinc-900 print:bg-white">

    {{-- Toolbar (Hanya tampil di layar) --}}
    <div class="no-print fixed top-0 left-0 right-0 z-50 flex items-center justify-between bg-white/80 px-6 py-4 shadow-sm backdrop-blur-md border-b border-zinc-200">
        <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-900">
            &larr; Kembali ke Detail Order
        </a>
        <button onclick="window.print()" class="rounded-xl bg-emerald-600 px-5 py-2 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-700 hover:-translate-y-0.5">
            Cetak Invoice
        </button>
    </div>

    {{-- Invoice Container --}}
    <div class="mx-auto mt-20 max-w-3xl bg-white p-8 shadow-xl shadow-zinc-200/50 sm:p-12 print:mt-0 print:max-w-none print:shadow-none print:p-0">
        
        {{-- Header: Logo & Status --}}
        <header class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between border-b border-zinc-100 pb-8">
            <div>
                {{-- Logo Toko --}}
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-2xl font-extrabold text-emerald-600 tracking-tight">Jurangan<span class="text-zinc-900">99</span></span>
                </div>
                <p class="text-sm text-zinc-500">Penyedia Daging Sapi Segar & Berkualitas</p>
                <div class="mt-4 text-sm text-zinc-500">
                    <p>Jl. Pahlawan No. 9, Cileungsi</p>
                    <p>Bogor, Jawa Barat 16820</p>
                    <p>ratufarelia@gmail.com</p>
                </div>
            </div>

            <div class="text-right">
                <h1 class="text-3xl font-bold text-zinc-900 uppercase tracking-wide ">Invoice</h1>
                <p class="mt-1 text-sm font-medium text-zinc-500">#{{ $order->id }}</p>
                
                <div class="mt-4 flex flex-col items-end gap-1">
                    @php
                        $paymentColor = match($order->payment_status) {
                            'paid' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'unpaid' => 'bg-amber-100 text-amber-700 border-amber-200',
                            default => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                        };
                    @endphp
                    <span class="inline-block rounded-md border px-3 py-1 text-xs font-bold uppercase tracking-wider {{ $paymentColor }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                    <p class="text-xs text-zinc-400 mt-1">
                        Dibuat: {{ $order->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </header>

        {{-- Bill To Section --}}
        <section class="mt-8 grid gap-8 sm:grid-cols-2">
            <div>
                <p class="mb-2 text-xs font-bold uppercase tracking-wider text-zinc-400">Kepada Yth.</p>
                <h3 class="font-bold text-zinc-900 text-lg">{{ $order->customer_name }}</h3>
                <div class="mt-2 text-sm text-zinc-600 leading-relaxed">
                    <p>{{ $order->customer_address }}</p>
                    <p class="mt-1">{{ $order->customer_email }}</p>
                    <p>{{ $order->customer_phone ?? '-' }}</p>
                </div>
            </div>
            
            @if($order->notes)
            <div class="rounded-xl bg-zinc-50 p-4 border border-zinc-100">
                <p class="mb-2 text-xs font-bold uppercase tracking-wider text-zinc-400">Catatan Order</p>
                <p class="text-sm text-zinc-600 italic">"{{ $order->notes }}"</p>
            </div>
            @endif
        </section>

        {{-- Items Table --}}
        <section class="mt-10">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-zinc-200">
                        <th class="py-3 font-bold uppercase text-zinc-500 text-[11px] tracking-wider w-1/2">Produk</th>
                        <th class="py-3 font-bold uppercase text-zinc-500 text-[11px] tracking-wider text-center">Qty</th>
                        <th class="py-3 font-bold uppercase text-zinc-500 text-[11px] tracking-wider text-right">Harga Satuan</th>
                        <th class="py-3 font-bold uppercase text-zinc-500 text-[11px] tracking-wider text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-zinc-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-zinc-500">{{ Str::limit($item->product_slug, 40) }}</p>
                            </td>
                            <td class="py-4 text-center font-medium text-zinc-700">{{ $item->quantity }}</td>
                            <td class="py-4 text-right font-medium text-zinc-700">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="py-4 text-right font-bold text-zinc-900">Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        {{-- Totals --}}
        <section class="mt-8 flex justify-end page-break">
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <div class="flex justify-between py-2 text-sm text-zinc-600">
                    <span>Subtotal</span>
                    <span class="font-medium">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                {{-- Contoh jika ada Pajak/Ongkir (Hardcoded 0 di contoh ini) --}}
                {{-- 
                <div class="flex justify-between py-2 text-sm text-zinc-600">
                    <span>Pajak (0%)</span>
                    <span class="font-medium">Rp0</span>
                </div> 
                --}}
                <div class="my-2 border-t border-zinc-200"></div>
                <div class="flex justify-between py-2 text-base font-bold text-zinc-900">
                    <span>Total Bayar</span>
                    <span class="text-emerald-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </section>

        {{-- Footer / Payment Proof Info --}}
        <div class="mt-12 border-t border-zinc-100 pt-8 page-break">
            <div class="grid gap-8 sm:grid-cols-2">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-500 mb-3">Informasi Tambahan</h4>
                    <p class="text-sm text-zinc-500 leading-relaxed">
                        Terima kasih telah berbelanja di Jurangan99. Harap simpan invoice ini sebagai bukti transaksi yang sah.
                        Untuk pertanyaan, silakan hubungi kontak kami di atas.
                    </p>
                </div>
                <div>
                    @php
                        $proofItems = collect();
                        if ($order->payment_proof) {
                            $proofItems->push((object) [
                                'product_name' => __('Pesanan Anda'),
                                'payment_proof' => $order->payment_proof,
                            ]);
                        }

                        if ($proofItems->isEmpty()) {
                            $proofItems = $order->items->filter(fn($item) => !empty($item->payment_proof));
                        }
                    @endphp
                    @if($proofItems->isNotEmpty())
                        <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-500 mb-3">Bukti Bayar Diunggah</h4>
                        <ul class="space-y-2">
                            @foreach($proofItems as $item)
                                <li class="flex items-center gap-2 text-sm text-zinc-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-emerald-500" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                                    <span class="truncate max-w-[200px]">{{ $item->product_name }}</span>
                                    <span class="text-xs text-zinc-400">({{ basename($item->payment_proof) }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Print Footer Signature Area (Optional) --}}
        <div class="mt-16 hidden print:block">
            <div class="flex justify-between text-center">
                <div class="w-40">
                    <p class="text-xs font-bold uppercase text-zinc-400 mb-16">Penerima</p>
                    <div class="border-t border-zinc-300"></div>
                    <p class="text-sm mt-1 font-medium">{{ $order->customer_name }}</p>
                </div>
                <div class="w-40">
                    <p class="text-xs font-bold uppercase text-zinc-400 mb-16">Hormat Kami</p>
                    <div class="border-t border-zinc-300"></div>
                    <p class="text-sm mt-1 font-medium">Jurangan99</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>