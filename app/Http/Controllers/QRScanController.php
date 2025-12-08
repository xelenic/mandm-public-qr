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
     * Process the form submission and reveal the gift
     */
    public function submit(Request $request, $code)
    {
        $qrCode = QRCode::where('code', $code)->with('gift')->firstOrFail();

        // Check if already scanned
        if ($qrCode->is_scanned) {
            return redirect()->route('qr.scan', ['code' => $code]);
        }

        // Validate the form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Create the scan record
        Scan::create([
            'qr_code_id' => $qrCode->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'ip_address' => $request->ip(),
        ]);

        // Mark QR code as scanned
        $qrCode->update([
            'is_scanned' => true,
            'scanned_at' => now(),
        ]);

        // Show the gift reveal page
        return view('qr.reveal', compact('qrCode'));
    }
}
