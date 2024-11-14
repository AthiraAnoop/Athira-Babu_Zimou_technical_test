<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    protected $fillable = [
        'name',
        'store_id',
        'client_id',
        'status',
        'delivery_type',
        'tracking_code'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
