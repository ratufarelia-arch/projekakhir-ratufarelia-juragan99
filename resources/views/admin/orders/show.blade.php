@php
    use App\Models\Order;
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="__('Order #') . $order->id">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900">{{ __('Order #:id', ['id' => $order->id]) }}</h1>
                <p class="text-sm text-zinc-500">{{ __('Dibuat pada :date', ['date' => $order->created_at->format('d M Y H:i')]) }}</p>
            </div>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PUT')
                <select name="status" class="rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold text-zinc-900 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30">
                    @foreach(Order::statuses() as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ Str::ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl border border-emerald-500 bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600">{{ __('Update') }}</button>
            </form>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-zinc-900">{{ __('Customer') }}</h2>
                <dl class="mt-4 space-y-3 text-sm text-zinc-600">
                    <div>
                        <dt class="font-medium text-zinc-900">{{ __('Nama') }}</dt>
                        <dd>{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-900">{{ __('Email') }}</dt>
                        <dd>{{ $order->customer_email }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-900">{{ __('Telepon') }}</dt>
                        <dd>{{ $order->customer_phone ?? __('Tidak tersedia') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-900">{{ __('Alamat') }}</dt>
                        <dd>{{ $order->customer_address }}</dd>
                    </div>
                    @if($order->notes)
                        <div>
                            <dt class="font-medium text-zinc-900">{{ __('Catatan') }}</dt>
                            <dd>{{ $order->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </section>

            <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-zinc-900">{{ __('Ringkasan') }}</h2>
                <div class="mt-4 space-y-3 text-sm text-zinc-700">
                    <div class="flex items-center justify-between">
                        <span>{{ __('Total pesanan') }}</span>
                        <span class="font-semibold text-zinc-900">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>{{ __('Status pembayaran') }}</span>
                        <span>{{ Str::ucfirst($order->payment_status) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>{{ __('Status order') }}</span>
                        <span>{{ Str::ucfirst($order->status) }}</span>
                    </div>
                </div>
            </section>
        </div>

        <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-zinc-900">{{ __('Items') }}</h2>
            <div class="mt-4 space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between rounded-2xl border border-zinc-100 p-4">
                        <div>
                            <p class="font-semibold text-zinc-900">{{ $item->product_name }}</p>
                            <p class="text-xs uppercase tracking-[0.3em] text-zinc-500">{{ $item->quantity }} × Rp{{ number_format($item->unit_price, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-zinc-900">Rp{{ number_format($item->total, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        @php
            $proofItems = $order->items->filter(fn($item) => !empty($item->payment_proof));
        @endphp

        @if($proofItems->isNotEmpty())
            <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-zinc-900">{{ __('Bukti Pembayaran') }}</h2>
                <p class="mt-2 text-xs text-zinc-500">{{ __('Klik untuk melihat bukti pembayaran yang diunggah per produk.') }}</p>
                <div class="mt-4 space-y-4">
                    @foreach($proofItems as $item)
                        @php
                            $proofUrl = asset('storage/' . $item->payment_proof);
                            $proofExtension = Str::of($item->payment_proof)->afterLast('.')->lower();
                            $isImageProof = in_array($proofExtension, ['png', 'jpg', 'jpeg', 'webp', 'gif', 'bmp']);
                        @endphp

                        <div class="flex flex-col gap-4 rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-zinc-900">{{ $item->product_name }}</p>
                                <span class="text-[11px] font-semibold uppercase tracking-[0.3em] text-emerald-600">{{ __('Uploaded') }}</span>
                            </div>

                            <div class="grid gap-4 md:grid-cols-[1fr_auto]">
                                <div class="h-52 overflow-hidden rounded-2xl border border-zinc-100 bg-white">
                                    @if($isImageProof)
                                        <img
                                            src="{{ $proofUrl }}"
                                            alt="{{ __('Bukti pembayaran untuk :product', ['product' => $item->product_name]) }}"
                                            class="h-full w-full object-cover"
                                        />
                                    @else
                                        <div class="flex h-full items-center justify-center px-4 text-xs uppercase tracking-[0.3em] text-zinc-500">
                                            {{ __('Preview tidak tersedia') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex max-h-52 flex-col justify-between gap-2">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500">{{ __('Nama file') }}</p>
                                        <p class="text-sm font-medium text-zinc-900">{{ basename($item->payment_proof) }}</p>
                                    </div>
                                    <a
                                        href="{{ $proofUrl }}"
                                        class="inline-flex items-center justify-center rounded-xl border border-emerald-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-700 shadow-sm transition hover:border-emerald-400 hover:bg-emerald-50"
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        {{ __('Buka bukti pembayaran') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-layouts.app>
