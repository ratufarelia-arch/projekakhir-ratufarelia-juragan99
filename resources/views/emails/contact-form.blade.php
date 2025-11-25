<div style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
    <h2 style="margin-bottom: 8px; font-size: 18px;">Pesan Kontak Baru</h2>
    <p style="margin-bottom: 16px; color: #555;">Berikut adalah detail pesan yang dikirim melalui formulir kontak.</p>
    <ul style="list-style: none; padding: 0; margin: 0 0 16px; font-size: 14px; line-height: 1.6; color: #333;">
        <li><strong>Nama:</strong> {{ $name }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        @if(! empty($phone))
            <li><strong>Telepon:</strong> {{ $phone }}</li>
        @endif
        <li><strong>Subjek:</strong> {{ $subject }}</li>
    </ul>
    <div style="border-top: 1px solid #eee; padding-top: 12px;">
        <p style="margin-bottom: 4px; font-size: 13px; color: #555; text-transform: uppercase; letter-spacing: 0.08em;">Pesan</p>
        <p style="margin: 0; font-size: 15px; color: #111; line-height: 1.5;">{{ $message }}</p>
    </div>
</div>
