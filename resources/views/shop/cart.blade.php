@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Keranjang')">
    <div class="min-h-screen bg-white text-zinc-900">
        
        {{-- ================= NAVBAR ASLI (DIPERTAHANKAN) ================= --}}
        @include('partials.navbar')
        {{-- ================= END NAVBAR ================= --}}

        

        {{-- ================= KONTEN CART  ================= --}}
        <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-0">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-zinc-900">{{ __('Keranjang Belanja') }}</h1>
                <p class="text-sm text-zinc-500">{{ __('Periksa kembali item pilihan Anda sebelum checkout.') }}</p>
            </div>

            @if($cartItems->isEmpty())
                {{-- Empty State --}}
                <div class="flex min-h-[400px] flex-col items-center justify-center rounded-3xl bg-white/80 px-4 py-12 text-center shadow-sm ring-1 ring-zinc-100 backdrop-blur-sm sm:px-8">
                    <div class="mb-6 rounded-full bg-emerald-50 p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900">{{ __('Keranjang Anda Kosong') }}</h3>
                    <p class="mt-2 max-w-sm text-sm text-zinc-500">{{ __('Sepertinya Anda belum menambahkan daging pilihan ke keranjang. Yuk mulai belanja!') }}</p>
                    <a href="{{ route('home') }}" class="mt-8 inline-flex items-center rounded-lg bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-700">
                        {{ __('Mulai Belanja') }}
                    </a>
                </div>
            @else
                <div class="flex flex-col gap-8 lg:flex-row lg:items-start">
                    
                    {{-- Left Column: Cart Items List --}}
                    <div class="flex-1 rounded-3xl bg-white shadow-sm ring-1 ring-black/10">
                        <div class="divide-y divide-zinc-100">
                            @foreach($cartItems as $item)
                                <article class="flex flex-col gap-6 p-6 sm:flex-row sm:items-center transition hover:bg-zinc-50/50">
                                    {{-- Product Image --}}
                                    <div class="relative h-24 w-24 flex-shrink-0 overflow-hidden rounded-xl bg-zinc-100 border border-zinc-200">
                                        @if($item['product']->image_url)
                                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-[10px] uppercase text-zinc-400">
                                                No Image
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Product Details --}}
                                    <div class="flex flex-1 flex-col justify-between gap-4 sm:flex-row sm:gap-6">
                                        <div class="flex-1 space-y-2">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex rounded bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                                                    {{ $item['product']->category ?? 'Item' }}
                                                </span>
                                            </div>
                                            <h3 class="text-base font-bold text-zinc-900 line-clamp-1">
                                                {{ $item['product']->name }}
                                            </h3>
                                            
                                            {{-- Variants Info --}}
                                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-zinc-500">
                                                @if(!empty($item['weight_label']))
                                                    <span class="font-semibold text-zinc-700 bg-zinc-100 px-2 py-1 rounded">{{ $item['weight_label'] }}</span>
                                                @endif
                                                <span>{{ __('Satuan') }}: Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</span>
                                            </div>
                                        </div>

                                        {{-- Actions: Quantity & Remove --}}
                                        <div class="flex items-center justify-between sm:flex-col sm:items-end sm:justify-start gap-4">
                                            
                                            {{-- Quantity Control --}}
                                            <div class="flex items-center rounded-lg border border-zinc-200 bg-white shadow-sm" data-quantity-control>
                                                <button type="button" data-action="decrement" class="flex h-8 w-8 items-center justify-center text-zinc-500 hover:bg-zinc-100 hover:text-emerald-600 disabled:opacity-50">
                                                    -
                                                </button>
                                                <div class="flex h-8 w-10 items-center justify-center border-x border-zinc-100 bg-zinc-50 text-sm font-bold text-zinc-900" data-quantity-display>
                                                    {{ $item['quantity'] }}
                                                </div>
                                                <button type="button" data-action="increment" class="flex h-8 w-8 items-center justify-center text-zinc-500 hover:bg-zinc-100 hover:text-emerald-600">
                                                    +
                                                </button>
                                                
                                                {{-- Hidden Update Form --}}
                                                <form action="{{ route('shop.cart.update', $item['product']) }}" method="POST" class="hidden" data-quantity-form>
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="entry_key" value="{{ $item['entry_key'] }}">
                                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                                                </form>
                                            </div>

                                            {{-- Total Price & Remove --}}
                                            <div class="text-right">
                                                <div class="text-lg font-bold text-emerald-600">
                                                    Rp {{ number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') }}
                                                </div>
                                                
                                                <form method="POST" action="{{ route('shop.cart.remove', $item['product']) }}" class="mt-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="entry_key" value="{{ $item['entry_key'] }}">
                                                    <button type="submit" class="flex items-center gap-1 text-xs font-medium text-zinc-400 transition hover:text-rose-500 ml-auto">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    {{-- Right Column: Summary Sticky --}}
                    <div class="w-full lg:sticky lg:top-24 lg:w-96">
                        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-lg shadow-zinc-200/50">
                            <h2 class="text-lg font-bold text-zinc-900 mb-6">{{ __('Ringkasan Pesanan') }}</h2>
                            
                            <div class="space-y-4 text-sm">
                                <div class="flex items-center justify-between text-zinc-500">
                                    <span>{{ __('Total Item') }}</span>
                                    <span class="font-semibold text-zinc-900">{{ $cartQuantity }} Pcs</span>
                                </div>
                                <div class="flex items-center justify-between text-zinc-500">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span class="font-semibold text-zinc-900">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="border-t border-dashed border-zinc-200 my-4"></div>
                                
                                <div class="flex items-center justify-between text-base">
                                    <span class="font-bold text-zinc-900">{{ __('Total Belanja') }}</span>
                                    <span class="text-xl font-bold text-emerald-600">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                                </div>
                                
                                <p class="text-xs text-zinc-400 text-center leading-relaxed">
                                    {{ __('Harga sudah termasuk pajak. Biaya pengiriman akan dihitung saat checkout.') }}
                                </p>
                            </div>

                            <a href="{{ url('/checkout') }}" class="group mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition-all hover:bg-emerald-700 hover:shadow-xl hover:translate-y-[-2px]">
                                {{ __('Lanjut ke Checkout') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="transition-transform group-hover:translate-x-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </a>
                            
                            <div class="mt-6 flex items-center justify-center gap-4 opacity-50 grayscale hover:grayscale-0 transition-all">
                                <i class="fa-brands fa-cc-visa text-2xl"></i>
                                <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                                <i class="fa-solid fa-wallet text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    {{-- Script JavaScript Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-quantity-control]').forEach(control => {
                const display = control.querySelector('[data-quantity-display]');
                const form = control.querySelector('[data-quantity-form]');
                const input = form?.querySelector('input[name="quantity"]');
                const decrement = control.querySelector('[data-action="decrement"]');
                const increment = control.querySelector('[data-action="increment"]');

                const adjustButtons = (current) => {
                    if (!decrement) {
                        return;
                    }
                    const isDisabled = current <= 1;
                    decrement.disabled = isDisabled;
                    decrement.classList.toggle('opacity-30', isDisabled);
                    decrement.classList.toggle('cursor-not-allowed', isDisabled);
                };

                const updateQuantity = (delta) => {
                    if (!display || !input || !form) {
                        return;
                    }
                    const current = Number(display.textContent) || 0;
                    const next = Math.max(1, current + delta); // Min 1 item
                    if (next === current) {
                        return;
                    }
                    // Optimistic UI Update
                    display.textContent = next;
                    input.value = next;
                    adjustButtons(next);
                    
                    // Delay submit (debounce) to prevent spam
                    clearTimeout(control.submitTimeout);
                    control.submitTimeout = setTimeout(() => {
                        form.submit();
                    }, 500);
                };

                const initialQuantity = Number(display?.textContent) || 0;
                adjustButtons(initialQuantity);

                decrement?.addEventListener('click', (e) => {
                    e.preventDefault();
                    updateQuantity(-1)
                });
                increment?.addEventListener('click', (e) => {
                    e.preventDefault();
                    updateQuantity(1)
                });
            });
        });
    </script>
</x-layouts.plain>