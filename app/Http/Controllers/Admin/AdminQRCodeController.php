<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QRCode;
use App\Models\Gift;
use Illuminate\Http\Request;

class AdminQRCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrCodes = QRCode::with(['gift', 'scan'])
            ->orderByRaw('CAST(id AS INTEGER) ASC')
            ->paginate(20);
        
        return view('admin.qrcodes.index', compact('qrCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gifts = Gift::where('is_active', true)->get();
        return view('admin.qrcodes.create', compact('gifts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gift_id' => 'required|exists:gifts,id',
            'batch_number' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1|max:200',
        ]);

        $quantity = $validated['quantity'];
        unset($validated['quantity']);

        // Create multiple QR codes at once
        for ($i = 0; $i < $quantity; $i++) {
            QRCode::create($validated);
        }

        return redirect()->route('admin.qrcodes.index')
            ->with('success', "{$quantity} QR Code(s) created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(QRCode $qrcode)
    {
        $qrcode->load(['gift', 'scan']);
        return view('admin.qrcodes.show', compact('qrcode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QRCode $qrcode)
    {
        $gifts = Gift::where('is_active', true)->get();
        return view('admin.qrcodes.edit', compact('qrcode', 'gifts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QRCode $qrcode)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:255|unique:qr_codes,code,' . $qrcode->id,
            'code_readonly' => 'nullable|string',
            'gift_id' => 'required|exists:gifts,id',
            'batch_number' => 'nullable|string|max:255',
        ]);

        // If code field is disabled (not editing), use the readonly value
        if (empty($validated['code']) && !empty($validated['code_readonly'])) {
            $validated['code'] = $validated['code_readonly'];
        }

        // Remove the readonly field from validated data
        unset($validated['code_readonly']);

        $qrcode->update($validated);

        return redirect()->route('admin.qrcodes.index')
            ->with('success', 'QR Code updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QRCode $qrcode)
    {
        $qrcode->delete();

        return redirect()->route('admin.qrcodes.index')
            ->with('success', 'QR Code deleted successfully.');
    }

    /**
     * Bulk delete QR codes
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|exists:qr_codes,id',
        ]);

        $count = QRCode::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.qrcodes.index')
            ->with('success', "{$count} QR Code(s) deleted successfully.");
    }

    /**
     * Truncate all QR codes
     */
    public function truncate()
    {
        $count = QRCode::count();
        QRCode::truncate();

        return redirect()->route('admin.qrcodes.index')
            ->with('success', "All {$count} QR Code(s) have been permanently deleted.");
    }

    /**
     * Download QR code image
     */
    public function download(QRCode $qrcode)
    {
        // This will be implemented with the QR code generation library
        $url = route('qr.scan', ['code' => $qrcode->code]);
        
        // Generate QR code and return as download
        return response()->streamDownload(function () use ($url) {
            echo \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(300)->generate($url);
        }, "qrcode-{$qrcode->code}.png");
    }

    /**
     * Download QR code as SVG
     */
    public function downloadSvg(QRCode $qrcode)
    {
        $url = route('qr.scan', ['code' => $qrcode->code]);
        
        // Generate QR code as SVG and return as download
        return response()->streamDownload(function () use ($url) {
            echo \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(300)->generate($url);
        }, "qrcode-{$qrcode->code}.svg", [
            'Content-Type' => 'image/svg+xml',
        ]);
    }

    /**
     * Print QR codes sheet
     */
    public function print(Request $request)
    {
        $query = QRCode::with('gift');

        // Filter by scan status
        if ($request->status === 'scanned') {
            $query->where('is_scanned', true);
        } elseif ($request->status === 'not_scanned') {
            $query->where('is_scanned', false);
        }

        // Filter by gift
        if ($request->gift_id) {
            $query->where('gift_id', $request->gift_id);
        }

        // Filter by batch
        if ($request->batch_number) {
            $query->where('batch_number', $request->batch_number);
        }

        // Apply limit
        if ($request->limit) {
            $query->limit($request->limit);
        }

        $qrCodes = $query->orderBy('created_at', 'asc')->get();
        $size = $request->size ?? 'medium';

        return view('admin.qrcodes.print', compact('qrCodes', 'size'));
    }
}
