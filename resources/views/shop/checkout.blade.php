@php
    use Illuminate\Support\Str;
    // Ambil user yang sedang login untuk auto-fill
    $user = auth()->user();
@endphp

<x-layouts.plain :title="__('Checkout')">
    <div class="min-h-screen bg-white pb-20 pt-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            
            {{-- Header Simple --}}
            <div class="mb-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="group flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-zinc-200 transition hover:bg-zinc-50">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-zinc-500 transition group-hover:text-zinc-700">
                            <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">{{ __('Checkout') }}</h1>
                        <p class="text-sm text-zinc-500">{{ __('Selesaikan pesanan Anda') }}</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-900">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form Wrapper starts here covering both columns --}}
            <form action="{{ route('shop.checkout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid gap-8 lg:grid-cols-12">
                    
                    {{-- LEFT COLUMN: Forms --}}
                    <div class="space-y-6 lg:col-span-7 xl:col-span-8">
                        
                        {{-- Section 1: Contact Info --}}
                        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm md:p-8">
                            <div class="mb-6 flex items-center gap-3 border-b border-zinc-100 pb-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-zinc-900">{{ __('Informasi Kontak') }}</h2>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">{{ __('Nama Lengkap') }}</label>
                                    <input type="text" name="customer_name" 
                                        value="{{ old('customer_name', $user->name ?? '') }}"
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-emerald-500/20"
                                        placeholder="Contoh: Rifan Afendi">
                                    @error('customer_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">{{ __('Email') }}</label>
                                    <input type="email" name="customer_email" 
                                        value="{{ old('customer_email', $user->email ?? '') }}"
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-emerald-500/20"
                                        placeholder="email@anda.com">
                                    @error('customer_email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">{{ __('Nomor WhatsApp/Telepon') }}</label>
                                    <input type="text" name="customer_phone" 
                                        value="{{ old('customer_phone', $user->phone ?? '') }}"
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-emerald-500/20"
                                        placeholder="0812...">
                                    @error('customer_phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </section>

                        {{-- Section 2: Address --}}
                        <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm md:p-8">
                            <div class="mb-6 flex items-center gap-3 border-b border-zinc-100 pb-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-zinc-900">{{ __('Detail Pengiriman') }}</h2>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">{{ __('Alamat Lengkap') }}</label>
                                    <textarea name="customer_address" rows="3" 
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-emerald-500/20"
                                        placeholder="Nama jalan, nomor rumah, RT/RW, Kelurahan">{{ old('customer_address', $user->address ?? '') }}</textarea>
                                    @error('customer_address') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">{{ __('Catatan Tambahan (Opsional)') }}</label>
                                    <textarea name="notes" rows="2" 
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-emerald-500/20"
                                        placeholder="Misal: Pagar hitam, tolong titip di pos satpam">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- RIGHT COLUMN: Summary (Sticky) --}}
                    <div class="lg:col-span-5 xl:col-span-4">
                        <div class="sticky top-8 space-y-6">
                            
                            <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-6 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <span class="rounded-full bg-emerald-600/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700">QRIS</span>
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-900">{{ __('Pembayaran QRIS') }}</p>
                                        <p class="text-xs text-emerald-700/70">{{ __('Gunakan aplikasi banking/mPay yang sudah Anda punya untuk melakukan scan.') }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 rounded-2xl bg-white p-4 text-center shadow-inner shadow-emerald-100">
                                    <p class="text-[10px] uppercase tracking-[0.5em] text-zinc-400">{{ __('Kode QRIS') }}</p>
                                    <img src="{{ asset('qris.jpg') }}" alt="QRIS" class="h-60 w-full rounded-full object-cover object-center">
                                    <p class="text-xs text-zinc-500">{{ __('A/N: Jurangan 99 · Bank QRIS') }}</p>
                                </div>
                                <p class="mt-3 text-xs text-zinc-600">{{ __('Setelah menyelesaikan transfer, unggah satu bukti untuk setiap produk agar konfirmasi bisa berjalan tanpa hambatan.') }}</p>
                            </div>

                            <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm ring-4 ring-zinc-50">
                                <h3 class="mb-4 font-bold text-zinc-900">{{ __('Ringkasan Pesanan') }}</h3>
                                
                                {{-- Scrollable Item List --}}
                                <div class="max-h-[320px] space-y-4 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-zinc-200">
                                    @foreach($cartItems as $item)
                                        <div class="flex gap-4">
                                            <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl border border-zinc-100 bg-zinc-50">
                                                @if($item['product']->image_url)
                                                    <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-xs font-bold text-zinc-400">
                                                        {{ Str::substr($item['product']->name, 0, 2) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-1 flex-col justify-center">
                                                <h4 class="line-clamp-1 text-sm font-semibold text-zinc-900">{{ $item['product']->name }}</h4>
                                                <p class="text-xs text-zinc-500">
                                                    {{ $item['quantity'] }} x Rp{{ number_format($item['unit_price'], 0, ',', '.') }}
                                                </p>
                                                @if(!empty($item['weight_label']))
                                                    <p class="text-[11px] uppercase tracking-[0.3em] text-zinc-400">{{ $item['weight_label'] }}</p>
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center text-right">
                                                <p class="text-sm font-semibold text-zinc-900">
                                                    Rp{{ number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2 flex flex-col gap-2 rounded-2xl border border-dashed border-zinc-200 bg-zinc-50 px-3 py-2 sm:px-4 sm:py-3">
                                            <label class="text-[11px] font-semibold uppercase tracking-[0.3em] text-zinc-500">{{ __('Upload bukti pembayaran :product', ['product' => $item['product']->name]) }}</label>
                                            <input
                                                type="file"
                                                name="payment_proof[{{ $item['product']->id }}]"
                                                accept="image/png,image/jpeg,image/jpg,application/pdf"
                                                class="text-xs text-zinc-500"
                                            >
                                            <p class="text-[11px] text-zinc-400">{{ __('PNG, JPG, atau PDF maksimal 2MB per produk.') }}</p>
                                            @error('payment_proof.' . $item['product']->id)
                                                <p class="text-xs text-rose-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Divider --}}
                                <div class="my-6 border-t border-dashed border-zinc-200"></div>

                                {{-- Totals --}}
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm text-zinc-600">
                                        <span>Subtotal</span>
                                        <span class="font-medium text-zinc-900">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-zinc-600">
                                        <span>Biaya Pengiriman</span>
                                        <span class="italic text-zinc-400">Dihitung nanti</span>
                                    </div>
                                    
                                    <div class="mt-4 flex items-center justify-between border-t border-zinc-100 pt-4">
                                        <span class="text-base font-bold text-zinc-900">Total Bayar</span>
                                        <span class="text-xl font-bold text-emerald-600">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                {{-- Main CTA Button --}}
                                <button type="submit" 
                                    class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                    <span>Buat Pesanan</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                {{-- Security Note --}}
                                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-zinc-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Pembayaran aman & terenkripsi</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-layouts.plain>