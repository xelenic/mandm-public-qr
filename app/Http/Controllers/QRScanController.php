<?php

namespace App\Http\Controllers;

use App\Models\QRCode;
use App\Models\Scan;
use Illuminate\Http\Request;

class QRScanController extends Controller
{
    /**
     * Show the QR scan form
     */
    public function show($code)
    {
        $qrCode = QRCode::where('code', $code)->with('gift')->firstOrFail();

        // Check if already scanned
        if ($qrCode->is_scanned) {
            return view('qr.already-scanned', compact('qrCode'));
        }

        return view('qr.form', compact('qrCode'));
    }

    /**
     * Show the "How to Join" page
     */
    public function howToJoin($code)
    {
        $qrCode = QRCode::where('code', $code)->with('gift')->firstOrFail();
        return view('qr.how-to-join', compact('qrCode'));
    }

    /**
     * Process the form submission and reveal the gift
     */
    public function submit(Request $request, $code)
    {
        $qrCode = QRCode::where('code', $code)->with('gift')->firstOrFail();

        // Check if already scanned
        if ($qrCode->is_scanned) {
            return redirect()->route('qr.scan', ['code' => $code]);
        }

        // Validate the form (Personal Details)
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'accept_terms' => 'accepted',
            // Optional legacy field (if present)
            'email' => 'nullable|email|max:255',
        ]);

        $fullName = trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? ''));

        // Create the scan record
        Scan::create([
            'qr_code_id' => $qrCode->id,
            'name' => $fullName,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'],
            'ip_address' => $request->ip(),
        ]);

        // Mark QR code as scanned
        $qrCode->update([
            'is_scanned' => true,
            'scanned_at' => now(),
        ]);

        // Show the "How to Join" page
        return view('qr.how-to-join', compact('qrCode'));
    }
}
