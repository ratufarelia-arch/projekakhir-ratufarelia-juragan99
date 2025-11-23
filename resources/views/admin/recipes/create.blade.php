<x-layouts.app :title="__('Tambah Resep')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Tambah resep baru') }}</h1>
            <p class="text-sm text-zinc-500">{{ __('Tulis artikel resep yang mengarahkan pembeli ke produk terkait.') }}</p>
        </div>

        <form method="POST" action="{{ route('admin.recipes.store') }}" class="space-y-6">
            @csrf

            @include('admin.recipes._form', ['recipe' => $recipe])

            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-2xl border border-emerald-500 bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600"
                >
                    {{ __('Simpan resep') }}
                </button>
                <a
                    href="{{ route('admin.recipes.index') }}"
                    class="text-sm font-semibold text-zinc-500 hover:text-zinc-700"
                >{{ __('Batal') }}</a>
            </div>
        </form>
    </div>
</x-layouts.app>
