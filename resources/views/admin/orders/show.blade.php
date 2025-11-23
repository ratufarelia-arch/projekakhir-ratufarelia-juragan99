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
    </div>
</x-layouts.app>
