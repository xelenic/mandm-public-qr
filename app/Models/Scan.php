<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = [
        'qr_code_id',
        'name',
        'email',
        'phone',
        'ip_address',
        'gift_status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function qrCode()
    {
        return $this->belongsTo(QRCode::class, 'qr_code_id');
    }

    public function gift()
    {
        return $this->qrCode->gift ?? null;
    }
}
