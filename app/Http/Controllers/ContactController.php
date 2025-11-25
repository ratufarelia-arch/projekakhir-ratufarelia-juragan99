<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $recipient = config('mail.contact_recipient') ?: config('mail.from.address');

        $subject = __('[Jurangan 99] :subject', ['subject' => $data['subject']]);

        $parts = [
            __('Nama') . ': ' . $data['name'],
            __('Email') . ': ' . $data['email'],
        ];

        if (! empty($data['phone'])) {
            $parts[] = __('Telepon') . ': ' . $data['phone'];
        }

        $parts[] = '---';
        $parts[] = __('Pesan') . ':';
        $parts[] = $data['message'];

        $body = implode("\n", $parts);

        $mailto = 'mailto:' . rawurlencode($recipient)
            . '?subject=' . rawurlencode($subject)
            . '&body=' . rawurlencode($body);

        return redirect()->away($mailto);
    }
}
