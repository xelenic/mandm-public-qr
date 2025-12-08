<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'decimal:2',
    ];

    public function qrCodes()
    {
        return $this->hasMany(QRCode::class, 'gift_id');
    }
}
