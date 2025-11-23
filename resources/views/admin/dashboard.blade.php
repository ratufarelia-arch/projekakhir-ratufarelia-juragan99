<x-layouts.app :title="__('Admin Dashboard')">
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">{{ __('Total users') }}</p>
                <p class="text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($userCount) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">{{ __('Active sessions') }}</p>
                <p class="text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($sessionCount) }}</p>
            </article>
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">{{ __('Queued jobs') }}</p>
                <p class="text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($jobCount) }}</p>
            </article>
        </div>

        <section class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
            <header class="mb-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-zinc-500">{{ __('Recent users') }}</p>
                    <h1 class="text-xl font-semibold text-zinc-900 dark:text-white">{{ __('Latest sign-ups') }}</h1>
                </div>
            </header>

            @if($recentUsers->isEmpty())
                <p class="text-sm text-zinc-500">{{ __('No users yet.') }}</p>
            @else
                <div class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @foreach($recentUsers as $recentUser)
                        <div class="grid gap-4 py-3 md:grid-cols-3">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-sm font-semibold text-zinc-700 dark:bg-zinc-800 dark:text-white">{{ $recentUser->initials() }}</span>
                                <div>
                                    <p class="font-semibold text-zinc-900 dark:text-white">{{ $recentUser->name }}</p>
                                    <p class="text-xs text-zinc-500">{{ $recentUser->email }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-300">{{ ucfirst($recentUser->role) }}</p>
                            <p class="text-xs text-zinc-500">{{ $recentUser->created_at?->toDayDateTimeString() ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="rounded-2xl border border-zinc-200 bg-white/80 p-6 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm text-zinc-500">{{ __('Ekspor rekap penjualan sebagai Excel untuk keperluan pelaporan.') }}</p>
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">{{ __('Laporan Penjualan') }}</h2>
                </div>
                <a
                    href="{{ route('admin.reports.sales') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-emerald-500 bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600"
                >
                    {{ __('Buka laporan') }}
                </a>
            </div>
        </section>
    </div>
</x-layouts.app>
