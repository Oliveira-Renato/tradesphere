<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;

    protected $fillable = ['tenant_id', 'sku', 'name', 'price'];

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
