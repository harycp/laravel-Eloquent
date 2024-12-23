<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = "vouchers";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;

    public function uniqueIds()
    {
        return [$this->primaryKey, "voucher_code"];
    }

    protected $fillable = [
        "name",
        "discount",
    ];

    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }

    public function scopeNonActive($query)
    {
        return $query->where('is_active', false);
    }
}
