@php
    $address = 'Jalan Pahlawan No. 9 Kp. Tengah, RT.01/RW.05, Cileungsi, Kabupaten Bogor, Jawa Barat 16820';
    $phone = '0822-5776-8899';
    $email = 'halo@jurangan99.id';
    // Pastikan URL map valid. Ini contoh embed map Cileungsi
    $mapSrc = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.994553295886!2d106.96010079999999!3d-6.394702499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6995efa2a2c841%3A0x213db704fed9f954!2sJURAGAN%20DAGING%2099!5e0!3m2!1sid!2sid!4v1764094103567!5m2!1sid!2sid';
@endphp

<x-layouts.plain :title="__('Kontak Kami')">
    <div class="min-h-screen bg-white text-zinc-900 font-sans selection:bg-emerald-100 selection:text-emerald-900">
        
        @include('partials.navbar')
        
        <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
            
            {{-- Header Section --}}
            <div class="mb-16 max-w-2xl">
                <span class="mb-3 inline-block rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-emerald-600">
                    {{ __('Hubungi Kami') }}
                </span>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl mb-6">
                    {{ __('Mari Terhubung dengan Kami') }}
                </h1>
                <p class="text-lg leading-relaxed text-zinc-500">
                    {{ __('Punya pertanyaan tentang produk daging premium kami? Atau ingin bermitra? Tim Jurangan 99 siap membantu kebutuhan Anda.') }}
                </p>
            </div>

            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                
                {{-- Kolom Kiri: Info Kontak & Map (Sticky) --}}
                <div class="lg:col-span-5">
                    <div class="lg:sticky lg:top-8 space-y-8">
                        
                        {{-- Contact Cards --}}
                        <div class="rounded-2xl bg-zinc-50 p-8 border border-zinc-100">
                            <h3 class="font-bold text-zinc-900 mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-emerald-600" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                                {{ __('Kantor ') }}
                            </h3>
                            
                            <ul class="space-y-6">
                                <li class="flex gap-4 group">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-zinc-400 shadow-sm ring-1 ring-zinc-200 group-hover:text-emerald-600 group-hover:ring-emerald-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-900">{{ __('Alamat') }}</p>
                                        <p class="mt-1 text-sm text-zinc-500 leading-relaxed">{{ $address }}</p>
                                    </div>
                                </li>
                                <li class="flex gap-4 group">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-zinc-400 shadow-sm ring-1 ring-zinc-200 group-hover:text-emerald-600 group-hover:ring-emerald-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-900">{{ __('Telepon / WhatsApp') }}</p>
                                        <p class="mt-1 text-sm text-zinc-500">{{ $phone }}</p>
                                    </div>
                                </li>
                                <li class="flex gap-4 group">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-zinc-400 shadow-sm ring-1 ring-zinc-200 group-hover:text-emerald-600 group-hover:ring-emerald-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-900">{{ __('Email') }}</p>
                                        <p class="mt-1 text-sm text-zinc-500">{{ $email }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        {{-- Map --}}
                        <div class="overflow-hidden rounded-2xl bg-zinc-100 shadow-sm ring-1 ring-zinc-200">
                            <iframe
                                title="Peta Jurangan 99"
                                src="{{ $mapSrc }}"
                                class="h-64 w-full grayscale transition hover:grayscale-0"
                                loading="lazy"
                                style="border:0;"
                                allowfullscreen=""
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Form --}}
                <div class="lg:col-span-7">
                    <div class="rounded-3xl bg-white shadow-xl shadow-zinc-200/50 ring-1 ring-zinc-100 p-8 sm:p-10">
                        <h2 class="text-2xl font-bold text-zinc-900 mb-2">{{ __('Kirim Pesan') }}</h2>
                        <p class="text-sm text-zinc-500 mb-8">{{ __('Kami biasanya membalas dalam waktu 24 jam kerja.') }}</p>

                        @if(session('success'))
                            <div class="mb-8 flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="space-y-1.5">
                                    <label for="name" class="block text-sm font-semibold text-zinc-700">{{ __('Nama Lengkap') }}</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Cth: Ratu Farelia"
                                        required
                                        class="w-full rounded-xl border-0 bg-zinc-50 px-4 py-3 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 transition"
                                    >
                                    @error('name')<p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>@enderror
                                </div>
                                
                                <div class="space-y-1.5">
                                    <label for="email" class="block text-sm font-semibold text-zinc-700">{{ __('Alamat Email') }}</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="nama@email.com"
                                        required
                                        class="w-full rounded-xl border-0 bg-zinc-50 px-4 py-3 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 transition"
                                    >
                                    @error('email')<p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="space-y-1.5">
                                    <label for="phone" class="block text-sm font-semibold text-zinc-700">{{ __('No. WhatsApp / Telepon') }} <span class="text-zinc-400 font-normal">(Opsional)</span></label>
                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        placeholder="0812..."
                                        class="w-full rounded-xl border-0 bg-zinc-50 px-4 py-3 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 transition"
                                    >
                                    @error('phone')<p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>@enderror
                                </div>
                                
                                <div class="space-y-1.5">
                                    <label for="subject" class="block text-sm font-semibold text-zinc-700">{{ __('Subjek Pesan') }}</label>
                                    <input
                                        type="text"
                                        id="subject"
                                        name="subject"
                                        value="{{ old('subject') }}"
                                        placeholder="Cth: Kerjasama Supplier"
                                        required
                                        class="w-full rounded-xl border-0 bg-zinc-50 px-4 py-3 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 transition"
                                    >
                                    @error('subject')<p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="message" class="block text-sm font-semibold text-zinc-700">{{ __('Isi Pesan') }}</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="5"
                                    required
                                    placeholder="Tuliskan detail pertanyaan atau kebutuhan Anda di sini..."
                                    class="w-full rounded-xl border-0 bg-zinc-50 px-4 py-3 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-200 placeholder:text-zinc-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 transition resize-none"
                                >{{ old('message') }}</textarea>
                                @error('message')<p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>@enderror
                            </div>

                            <button
                                type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition-all hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                            >
                                <span>{{ __('Kirim Pesan') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>
</x-layouts.plain>