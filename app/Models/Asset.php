<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'asset_tag',
        'category',
        'description',
        'serial_number',
        'manufacturer',
        'model',
        'purchase_date',
        'purchase_price',
        'status',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(AssetAssignment::class)->where('status', 'active')->latest();
    }
}
