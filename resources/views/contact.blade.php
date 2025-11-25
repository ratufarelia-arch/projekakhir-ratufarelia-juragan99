@php
    $address = 'Jalan Pahlawan No. 9 Kp. Tengah, RT.01/RW.05, Cileungsi, Kabupaten Bogor, Jawa Barat 16820';
    $phone = '0822-5776-8899';
    $email = 'ratufarelia@gmail.com';
    $mapSrc = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.994553295886!2d106.96010079999999!3d-6.394702499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6995efa2a2c841%3A0x213db704fed9f954!2sJURAGAN%20DAGING%2099!5e0!3m2!1sid!2sid!4v1764094103567!5m2!1sid!2sid'; 
    // Catatan: Pastikan $storeStatus dan $operatingHours dikirim dari Controller
@endphp

<x-layouts.plain :title="__('Kontak Kami')">
    <div class="min-h-screen bg-white text-zinc-900 font-sans selection:bg-emerald-100 selection:text-emerald-900">
        
        @include('partials.navbar')
        
        <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
            
            {{-- 1. Centered Header Section for Symmetry --}}
            <div class="mx-auto max-w-3xl text-center mb-16 sm:mb-20">
                <span class="mb-4 inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-emerald-700">
                    <span class="mr-2 h-2 w-2 rounded-full bg-emerald-500"></span>
                    {{ __('Hubungi Kami') }}
                </span>
                <h1 class="text-4xl font-extrabold tracking-tight text-zinc-900 sm:text-5xl mb-6">
                    {{ __('Mari Terhubung dengan Kami') }}
                </h1>
                <p class="text-lg leading-relaxed text-zinc-500">
                    {{ __('Tim Jurangan 99 siap membantu kebutuhan daging premium Anda. Silakan hubungi kami atau kunjungi showroom kami di Cileungsi.') }}
                </p>
            </div>

            <div class="grid gap-10 lg:grid-cols-12 lg:gap-12 items-start">
                
                {{-- KOLOM KIRI: Info, Jam Buka, & Map --}}
                <div class="lg:col-span-5 space-y-8">
                    
                    {{-- Card 1: Informasi Kontak Utama --}}
                    <div class="rounded-3xl border border-zinc-100 bg-white p-8 shadow-xl shadow-zinc-200/40">
                        <h3 class="text-lg font-bold text-zinc-900 mb-6 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-emerald-600" viewBox="0 0 16 16"><path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/><path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/></svg>
                            {{ __('Kontak Cepat') }}
                        </h3>
                        <ul class="space-y-6">
                            {{-- Address --}}
                            <li class="flex gap-4">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-50 text-zinc-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">{{ __('Lokasi Showroom') }}</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-900 leading-relaxed">{{ $address }}</p>
                                </div>
                            </li>
                            {{-- Phone --}}
                            <li class="flex gap-4">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-50 text-zinc-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">{{ __('Telepon / WA') }}</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-900">{{ $phone }}</p>
                                </div>
                            </li>
                            {{-- Email --}}
                            <li class="flex gap-4">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-50 text-zinc-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/></svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">{{ __('Email') }}</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-900">{{ $email }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    {{-- Card 2: Jam Operasional & Status --}}
                    <div class="rounded-3xl border border-zinc-100 bg-white p-8 shadow-xl shadow-zinc-200/40">
                         @php
                            $statusColor = $storeStatus['color'] ?? 'emerald';
                        @endphp
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-zinc-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-emerald-600" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 1 .5.5v3.25l2.5 1.5a.5.5 0 1 1-.5.866L8 8V4a.5.5 0 0 1 .5-.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14z"/></svg>
                                {{ __('Jam Operasional') }}
                            </h3>
                            <span class="inline-flex items-center rounded-full bg-{{ $statusColor }}-100 px-2.5 py-0.5 text-xs font-bold text-{{ $statusColor }}-700">
                                <svg class="mr-1.5 h-2 w-2 text-{{ $statusColor }}-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                {{ $storeStatus['label'] }}
                            </span>
                        </div>
                        
                        <div class="space-y-3">
                            @foreach ($operatingHours as $entry)
                                <div class="flex items-center justify-between py-2 border-b border-zinc-50 last:border-0">
                                    <span class="text-sm {{ $entry['is_today'] ? 'font-bold text-zinc-900' : 'text-zinc-500' }}">
                                        {{ $entry['label'] }}
                                    </span>
                                    <span class="text-sm {{ $entry['is_today'] ? 'font-bold text-emerald-600' : 'text-zinc-700' }}">
                                        @if ($entry['open'] && $entry['close'])
                                            {{ $entry['open'] }} - {{ $entry['close'] }}
                                        @else
                                            {{ __('Libur') }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                     {{-- Card 3: Map (Placed here to balance height with the form) --}}
                     <div class="overflow-hidden rounded-3xl border border-zinc-100 shadow-lg shadow-zinc-200/40">
                        <iframe
                            title="Peta Jurangan 99"
                            src="{{ $mapSrc }}"
                            class="h-48 w-full grayscale transition duration-500 hover:grayscale-0"
                            loading="lazy"
                            style="border:0;"
                            allowfullscreen=""
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                         <a href="https://maps.google.com" target="_blank" class="block bg-zinc-50 px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-zinc-500 hover:bg-emerald-50 hover:text-emerald-600 transition">
                            {{ __('Buka di Google Maps') }} &rarr;
                        </a>
                    </div>

                </div>

                {{-- KOLOM KANAN: Form Pesan --}}
                <div class="lg:col-span-7">
                    <div class="rounded-3xl bg-white p-8 sm:p-10 shadow-xl shadow-zinc-200/40 border border-zinc-100 h-full">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-zinc-900">{{ __('Kirim Pesan') }}</h2>
                            <p class="text-sm text-zinc-500 mt-2">{{ __('Isi formulir di bawah ini dan kami akan segera menghubungi Anda kembali.') }}</p>
                        </div>

                        @if(session('success'))
                            <div class="mb-8 flex items-start gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-4 text-sm font-medium text-emerald-800">
                                <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            {{-- Grid Nama & Email --}}
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label for="name" class="text-xs font-bold uppercase tracking-wide text-zinc-500">{{ __('Nama Lengkap') }}</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Nama Anda"
                                        required
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3.5 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500 transition"
                                    >
                                    @error('name')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="email" class="text-xs font-bold uppercase tracking-wide text-zinc-500">{{ __('Alamat Email') }}</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="email@anda.com"
                                        required
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3.5 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500 transition"
                                    >
                                    @error('email')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Grid Phone & Subject --}}
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label for="phone" class="text-xs font-bold uppercase tracking-wide text-zinc-500">{{ __('WhatsApp / Telepon') }}</label>
                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        placeholder="08..."
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3.5 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500 transition"
                                    >
                                    @error('phone')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="subject" class="text-xs font-bold uppercase tracking-wide text-zinc-500">{{ __('Subjek') }}</label>
                                    <input
                                        type="text"
                                        id="subject"
                                        name="subject"
                                        value="{{ old('subject') }}"
                                        placeholder="Perihal pesan..."
                                        required
                                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3.5 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500 transition"
                                    >
                                    @error('subject')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Textarea --}}
                            <div class="space-y-2">
                                <label for="message" class="text-xs font-bold uppercase tracking-wide text-zinc-500">{{ __('Isi Pesan') }}</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="6"
                                    required
                                    placeholder="Jelaskan kebutuhan Anda..."
                                    class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3.5 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500 transition resize-none"
                                >{{ old('message') }}</textarea>
                                @error('message')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-emerald-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition-all hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                            >
                                {{ __('Kirim Pesan') }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>
</x-layouts.plain>