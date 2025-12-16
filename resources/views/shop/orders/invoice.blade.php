@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice #{{ $order->id }} - Jurangan99</title>
    
    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Print Specific Adjustments */
        @media print {
            @page { margin: 0; size: auto; }
            body { -webkit-print-color-adjust: exact; background-color: white !important; }
            .no-print { display: none !important; }
            .print-break { page-break-inside: avoid; }
            .invoice-container { box-shadow: none !important; margin: 0 !important; max-width: 100% !important; padding: 40px !important; }
        }
    </style>
</head>
<body class="bg-zinc-100 text-zinc-900 selection:bg-emerald-100 selection:text-emerald-900">

    {{-- Toolbar (Hanya Tampil di Layar) --}}
    <div class="no-print fixed top-0 left-0 right-0 z-50 flex items-center justify-between border-b border-zinc-200 bg-white/90 px-6 py-4 backdrop-blur-md">
        <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-sm font-medium text-zinc-500 transition hover:text-zinc-900">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/></svg>
            Kembali
        </a>
        <div class="flex gap-3">
            <button onclick="window.print()" class="flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-700 hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3z"/></svg>
                Cetak Invoice
            </button>
        </div>
    </div>

    {{-- Kertas Invoice --}}
    <main class="invoice-container mx-auto mt-24 mb-12 max-w-4xl rounded-2xl bg-white p-10 shadow-xl shadow-zinc-200/60 sm:p-12 print:mt-0">
        
        {{-- Header --}}
        <header class="flex flex-col gap-8 border-b border-zinc-100 pb-8 sm:flex-row sm:justify-between">
            <div class="space-y-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-emerald-600 tracking-tight">Jurangan<span class="text-zinc-900">99</span></h1>
                    <p class="text-sm text-zinc-500">Penyedia Daging Sapi Premium</p>
                </div>
                <div class="text-sm text-zinc-600 leading-relaxed">
                    <p>Jl. Pahlawan No. 9, Cileungsi</p>
                    <p>Kabupaten Bogor, Jawa Barat 16820</p>
                    <p>Email: ratufarelia@gmail.com</p>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400 mb-1">Invoice</p>
                <h2 class="text-3xl font-bold text-zinc-900">#{{ $order->id }}</h2>
                
                <div class="mt-4 flex flex-col gap-1 sm:items-end">
                    <p class="text-sm text-zinc-500">
                        Tanggal: <span class="font-medium text-zinc-900">{{ $order->created_at->translatedFormat('d F Y') }}</span>
                    </p>
                    <p class="text-sm text-zinc-500">
                        Waktu: <span class="font-medium text-zinc-900">{{ $order->created_at->format('H:i') }} WIB</span>
                    </p>
                    <div class="mt-2">
                        @php
                            $statusClass = match($order->payment_status) {
                                'paid' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'unpaid' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'failed' => 'bg-rose-100 text-rose-700 border-rose-200',
                                default => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                            };
                        @endphp
                        <span class="inline-block rounded px-2.5 py-1 text-xs font-bold uppercase tracking-wider border {{ $statusClass }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </header>

        {{-- Customer Info --}}
        <div class="grid gap-8 py-8 sm:grid-cols-2">
            <div>
                <p class="mb-3 text-xs font-bold uppercase tracking-wider text-zinc-400">Ditagihkan Kepada</p>
                <h3 class="text-lg font-bold text-zinc-900">{{ $order->customer_name }}</h3>
                <div class="mt-2 space-y-1 text-sm text-zinc-600">
                    <p>{{ $order->customer_email }}</p>
                    <p>{{ $order->customer_phone ?? '-' }}</p>
                    <p class="max-w-xs leading-relaxed">{{ $order->customer_address }}</p>
                </div>
            </div>
            
            @if($order->notes)
            <div class="rounded-xl border border-zinc-100 bg-zinc-50 p-5">
                <p class="mb-2 text-xs font-bold uppercase tracking-wider text-zinc-400">Catatan Pelanggan</p>
                <p class="text-sm italic text-zinc-600">"{{ $order->notes }}"</p>
            </div>
            @else
            <div>
                {{-- Spacer if no notes --}}
            </div>
            @endif
        </div>

        {{-- Table --}}
        <div class="mt-4 overflow-hidden rounded-xl border border-zinc-200">
            <table class="min-w-full divide-y divide-zinc-200">
                <thead class="bg-zinc-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-zinc-500">Produk</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-zinc-500">Qty</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Harga Satuan</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 bg-white">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-bold text-zinc-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-zinc-400 font-mono mt-0.5">{{ Str::limit($item->product_slug, 30) }}</p>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-zinc-600">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-zinc-600">
                                Rp{{ number_format($item->unit_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-semibold text-zinc-900">
                                Rp{{ number_format($item->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-zinc-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-zinc-500">Subtotal</td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-zinc-900">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-base font-bold text-zinc-900">Total Bayar</td>
                        <td class="px-6 py-4 text-right text-xl font-bold text-emerald-600">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Footer Details --}}
        <div class="mt-10 grid gap-10 sm:grid-cols-2 print-break">
            {{-- Payment Proofs --}}
            <div>
                <h4 class="mb-3 text-xs font-bold uppercase tracking-wider text-zinc-400">Bukti Pembayaran</h4>
                @php
                    $proofItems = collect();
                    if ($order->payment_proof) {
                        $proofItems->push((object) [
                            'product_name' => __('Pesanan Anda'),
                            'payment_proof' => $order->payment_proof,
                        ]);
                    }

                    if ($proofItems->isEmpty()) {
                        $proofItems = $order->items->filter(fn ($item) => !empty($item->payment_proof));
                    }
                @endphp
                @if($proofItems->isNotEmpty())
                    <ul class="space-y-2">
                        @foreach($proofItems as $item)
                            <li class="flex items-center gap-2 text-sm text-zinc-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-emerald-500" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                                <span>{{ $item->product_name }}</span>
                                <span class="text-xs text-zinc-400">({{ basename($item->payment_proof) }})</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm italic text-zinc-400">Belum ada bukti pembayaran yang diunggah.</p>
                @endif
            </div>

            {{-- Signature Area (Visible on Print) --}}
            <div class="hidden print:block text-center mt-8">
                <div class="flex justify-end gap-16">
                    <div class="w-40">
                        <p class="text-xs font-bold uppercase text-zinc-400 mb-16">Penerima</p>
                        <div class="border-t border-zinc-300 pt-2">
                            <p class="text-sm font-semibold">{{ $order->customer_name }}</p>
                        </div>
                    </div>
                    <div class="w-40">
                        <p class="text-xs font-bold uppercase text-zinc-400 mb-16">Hormat Kami</p>
                        <div class="border-t border-zinc-300 pt-2">
                            <p class="text-sm font-semibold">Jurangan99</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Thank You Note (Screen Only) --}}
            <div class="no-print flex items-end justify-end">
                <div class="text-right">
                    <p class="text-sm font-medium text-zinc-900">Terima kasih atas kepercayaan Anda!</p>
                    <p class="text-xs text-zinc-500 mt-1">Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada perjanjian.</p>
                </div>
            </div>
        </div>
        
    </main>

    {{-- Print Footer Watermark --}}
    <div class="hidden print:block fixed bottom-4 left-0 right-0 text-center text-[10px] text-zinc-400">
        Dicetak pada {{ now()->format('d M Y H:i') }} | Invocie #{{ $order->id }}
    </div>

</body>
</html>