<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QRCode extends Model
{
    protected $table = 'qr_codes';
    
    protected $fillable = [
        'code',
        'gift_id',
        'is_scanned',
        'scanned_at',
        'batch_number',
    ];

    protected $casts = [
        'is_scanned' => 'boolean',
        'scanned_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($qrCode) {
            if (empty($qrCode->code)) {
                $qrCode->code = self::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode()
    {
        do {
            $code = 'MM-' . strtoupper(Str::random(10));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }

    public function scan()
    {
        return $this->hasOne(Scan::class, 'qr_code_id');
    }
}
