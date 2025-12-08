<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scan;
use Illuminate\Http\Request;

class AdminScanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Scan::with(['qrCode.gift']);

        // Search filter
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Gift status filter
        if ($request->gift_status) {
            $query->where('gift_status', $request->gift_status);
        }

        // Date filter
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $scans = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.scans.index', compact('scans'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Scan $scan)
    {
        $scan->load(['qrCode.gift']);
        return view('admin.scans.show', compact('scan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scan $scan)
    {
        return view('admin.scans.edit', compact('scan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scan $scan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gift_status' => 'required|in:pending,confirmed,sent,delivered',
        ]);

        $scan->update($validated);

        return redirect()->route('admin.scans.index')
            ->with('success', 'Customer details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scan $scan)
    {
        $scan->delete();

        return redirect()->route('admin.scans.index')
            ->with('success', 'Customer record deleted successfully.');
    }

    /**
     * Update gift status
     */
    public function updateStatus(Request $request, Scan $scan)
    {
        $validated = $request->validate([
            'gift_status' => 'required|in:pending,confirmed,sent,delivered',
        ]);

        $scan->update($validated);

        return redirect()->back()
            ->with('success', 'Gift status updated successfully.');
    }

    /**
     * Export scans to CSV
     */
    public function export(Request $request)
    {
        $query = Scan::with(['qrCode.gift']);

        // Apply same filters as index
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->gift_status) {
            $query->where('gift_status', $request->gift_status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $scans = $query->orderBy('created_at', 'desc')->get();

        $filename = 'customer-scans-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($scans) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'QR Code', 'Gift', 'Gift Status', 'IP Address', 'Scanned At']);

            // Add data rows
            foreach ($scans as $scan) {
                fputcsv($file, [
                    $scan->id,
                    $scan->name,
                    $scan->email,
                    $scan->phone,
                    $scan->qrCode->code ?? 'N/A',
                    $scan->qrCode->gift->name ?? 'N/A',
                    ucfirst($scan->gift_status ?? 'pending'),
                    $scan->ip_address ?? 'N/A',
                    $scan->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
